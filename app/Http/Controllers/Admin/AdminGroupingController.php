<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminScanLog;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\ShipmentSession;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminGroupingController extends Controller
{
    public function index(Request $request)
    {
        $trucks = Truck::query()->orderBy('plat_nomor')->get();
        $drivers = Driver::query()->orderBy('nama')->get();

        $selectedTruck = null;
        $session = null;
        $orders = collect();
        $totalWeight = 0;

        $truckId = $request->query('truck_id');
        if ($truckId) {
            $selectedTruck = Truck::find($truckId);
            if ($selectedTruck) {
                $session = ShipmentSession::query()
                    ->where('truck_id', $selectedTruck->id)
                    ->where('status', 'draft')
                    ->latest()
                    ->first();

                if ($session) {
                    $orders = Order::query()
                        ->where('shipment_session_id', $session->id)
                        ->orderBy('created_at')
                        ->get();

                    $totalWeight = (float) $orders->sum('berat_kg');
                }
            }
        }

        return view('admin.grouping.index', [
            'trucks' => $trucks,
            'drivers' => $drivers,
            'selectedTruck' => $selectedTruck,
            'session' => $session,
            'orders' => $orders,
            'totalWeight' => $totalWeight,
        ]);
    }

    public function start(Request $request)
    {
        $validated = $request->validate([
            'truck_id' => ['required', 'exists:trucks,id'],
            'driver_id' => ['required', 'exists:drivers,id'],
        ]);

        $truck = Truck::findOrFail($validated['truck_id']);
        if ($truck->status !== 'tersedia') {
            return redirect()->back()->with('status', 'Truck tidak tersedia untuk grouping.');
        }

        $driver = Driver::findOrFail($validated['driver_id']);
        if ($driver->status === 'sedang_bertugas') {
            return redirect()->back()->with('status', 'Driver sedang bertugas dan tidak bisa dipilih.');
        }

        $session = ShipmentSession::query()
            ->where('truck_id', $truck->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (! $session) {
            $session = ShipmentSession::create([
                'truck_id' => $truck->id,
                'driver_id' => $driver->id,
                'order_ids' => [],
                'status' => 'draft',
            ]);
        } else {
            $session->update(['driver_id' => $driver->id]);
        }

        $truck->update(['driver_id_current' => $driver->id]);
        $driver->update(['truck_id_current' => $truck->id]);

        return redirect()->route('admin.grouping', ['truck_id' => $truck->id]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'truck_id' => ['required', 'exists:trucks,id'],
            'resi' => ['required', 'string'],
            'admin_nama' => ['nullable', 'string', 'max:255'],
            'force' => ['nullable', 'boolean'],
        ]);

        $truck = Truck::findOrFail($validated['truck_id']);
        $session = ShipmentSession::query()
            ->where('truck_id', $truck->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (! $session) {
            return redirect()->back()->with('status', 'Pilih truck dan driver terlebih dahulu.');
        }

        $order = Order::query()->where('nomor_resi', $validated['resi'])->first();
        if (! $order) {
            return redirect()->back()->with('status', 'Resi tidak ditemukan.');
        }

        if (in_array($order->status, ['dibatalkan', 'selesai'], true)) {
            return redirect()->back()->with('status', 'Pesanan ini sudah tidak bisa diproses.');
        }

        if ($order->shipment_session_id && $order->shipment_session_id !== $session->id) {
            $existingSession = ShipmentSession::find($order->shipment_session_id);
            if ($existingSession && $existingSession->status === 'dalam_perjalanan') {
                return redirect()->back()->with('status', 'Pesanan ini sudah dimuat di truck lain yang sedang dalam perjalanan.');
            }
        }

        $sessionOrderIds = (array) ($session->order_ids ?? []);
        if (in_array($order->id, $sessionOrderIds, true)) {
            return redirect()->back()->with('status', 'QR/Resi ini sudah ada di grup.');
        }

        $requestedFleet = (string) ($order->jenis_armada_diminta ?: '');
        if ($requestedFleet !== '' && $requestedFleet !== 'recommendation') {
            $normalizedRequested = strtolower(str_replace('_', ' ', $requestedFleet));
            $normalizedTruck = strtolower((string) $truck->jenis_armada);
            if (! str_contains($normalizedTruck, $normalizedRequested) && ! ($request->boolean('force'))) {
                return redirect()
                    ->back()
                    ->with('status', 'Armada tidak cocok. Aktifkan override untuk tetap memuat.');
            }
        }

        DB::transaction(function () use ($order, $truck, $session, $validated) {
            $prevStatus = $order->status;

            $order->update([
                'shipment_session_id' => $session->id,
                'truck_id' => $truck->id,
                'driver_id' => $session->driver_id,
                'status' => 'dimuat_di_truck',
            ]);

            $keterangan = 'Barang dimuat ke truck '.$truck->plat_nomor.' ('.$truck->jenis_armada.')';
            OrderHistory::create([
                'order_id' => $order->id,
                'status_sebelumnya' => $prevStatus,
                'status_baru' => 'dimuat_di_truck',
                'keterangan' => $keterangan,
                'admin_nama' => $validated['admin_nama'] ?: null,
            ]);

            $orderIds = (array) ($session->order_ids ?? []);
            $orderIds[] = $order->id;
            $session->update(['order_ids' => array_values(array_unique($orderIds))]);

            AdminScanLog::create([
                'order_id' => $order->id,
                'truck_id' => $truck->id,
                'shipment_session_id' => $session->id,
                'admin_nama' => $validated['admin_nama'] ?: null,
                'action' => 'scan',
            ]);
        });

        return redirect()->route('admin.grouping', ['truck_id' => $truck->id])->with('status', 'Barang berhasil dimuat ke grup.');
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'truck_id' => ['required', 'exists:trucks,id'],
            'order_id' => ['required', 'exists:orders,id'],
            'admin_nama' => ['nullable', 'string', 'max:255'],
        ]);

        $truck = Truck::findOrFail($validated['truck_id']);
        $session = ShipmentSession::query()
            ->where('truck_id', $truck->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (! $session) {
            return redirect()->back()->with('status', 'Grup tidak ditemukan.');
        }

        $order = Order::findOrFail($validated['order_id']);
        if ($order->shipment_session_id !== $session->id) {
            return redirect()->back()->with('status', 'Pesanan ini tidak ada di grup truck yang dipilih.');
        }

        DB::transaction(function () use ($order, $truck, $session, $validated) {
            $prevStatus = $order->status;
            $defaultRollback = $order->jenis_layanan === 'b2b' ? 'menunggu_konfirmasi' : 'menunggu_drop_barang';
            $lastLoad = OrderHistory::query()
                ->where('order_id', $order->id)
                ->where('status_baru', 'dimuat_di_truck')
                ->latest()
                ->first();

            $rollbackStatus = (string) ($lastLoad?->status_sebelumnya ?: $defaultRollback);
            $rollbackDriverId = $rollbackStatus === 'dikonfirmasi_menunggu_pickup' ? $order->driver_id : null;

            $order->update([
                'shipment_session_id' => null,
                'truck_id' => null,
                'driver_id' => $rollbackDriverId,
                'status' => $rollbackStatus,
            ]);

            OrderHistory::create([
                'order_id' => $order->id,
                'status_sebelumnya' => $prevStatus,
                'status_baru' => $rollbackStatus,
                'keterangan' => 'Barang dihapus dari grup truck '.$truck->plat_nomor,
                'admin_nama' => $validated['admin_nama'] ?: null,
            ]);

            $orderIds = array_values(array_filter((array) ($session->order_ids ?? []), fn ($id) => (int) $id !== (int) $order->id));
            $session->update(['order_ids' => $orderIds]);

            AdminScanLog::create([
                'order_id' => $order->id,
                'truck_id' => $truck->id,
                'shipment_session_id' => $session->id,
                'admin_nama' => $validated['admin_nama'] ?: null,
                'action' => 'remove',
            ]);
        });

        return redirect()->route('admin.grouping', ['truck_id' => $truck->id])->with('status', 'Barang berhasil dihapus dari grup.');
    }

    public function depart(Request $request)
    {
        $validated = $request->validate([
            'truck_id' => ['required', 'exists:trucks,id'],
            'admin_nama' => ['nullable', 'string', 'max:255'],
            'waktu_berangkat' => ['nullable', 'date'],
        ]);

        $truck = Truck::findOrFail($validated['truck_id']);
        $session = ShipmentSession::query()
            ->where('truck_id', $truck->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (! $session) {
            return redirect()->back()->with('status', 'Grup tidak ditemukan.');
        }

        $orders = Order::query()->where('shipment_session_id', $session->id)->get();
        if ($orders->isEmpty()) {
            return redirect()->back()->with('status', 'Tidak ada barang di grup ini.');
        }

        $driver = Driver::find($session->driver_id);
        if (! $driver) {
            return redirect()->back()->with('status', 'Driver tidak ditemukan.');
        }

        $departAt = $validated['waktu_berangkat'] ? Carbon::parse($validated['waktu_berangkat']) : now();

        DB::transaction(function () use ($truck, $driver, $session, $orders, $validated, $departAt) {
            $session->update([
                'status' => 'dalam_perjalanan',
                'waktu_berangkat' => $departAt,
                'admin_berangkatkan_nama' => $validated['admin_nama'] ?: null,
            ]);

            $truck->update(['status' => 'dalam_perjalanan', 'driver_id_current' => $driver->id]);
            $driver->update(['status' => 'sedang_bertugas', 'truck_id_current' => $truck->id]);

            foreach ($orders as $order) {
                $prevStatus = $order->status;
                $order->update([
                    'status' => 'dalam_perjalanan',
                    'truck_id' => $truck->id,
                    'driver_id' => $driver->id,
                ]);

                $keterangan = 'Pengiriman dimulai. Truck '.$truck->plat_nomor.' berangkat.';
                if (($validated['catatan'] ?? '') !== '') {
                    $keterangan .= "\n".$validated['catatan'];
                }

                OrderHistory::create([
                    'order_id' => $order->id,
                    'status_sebelumnya' => $prevStatus,
                    'status_baru' => 'dalam_perjalanan',
                    'keterangan' => $keterangan,
                    'admin_nama' => $validated['admin_nama'] ?: null,
                ]);
            }
        });

        return redirect()->route('admin.shipments.active')->with('status', 'Truck berhasil diberangkatkan.');
    }
}
