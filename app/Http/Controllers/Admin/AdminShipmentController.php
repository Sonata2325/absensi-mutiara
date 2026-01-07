<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\ShipmentSession;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminShipmentController extends Controller
{
    public function active()
    {
        $sessions = ShipmentSession::query()
            ->with(['truck', 'driver'])
            ->where('status', 'dalam_perjalanan')
            ->orderByDesc('waktu_berangkat')
            ->get();

        $sessions->each(function (ShipmentSession $session) {
            $session->setRelation(
                'orders',
                Order::query()
                    ->whereIn('id', (array) ($session->order_ids ?? []))
                    ->orderBy('created_at')
                    ->get()
            );
        });

        return view('admin.shipments.active', [
            'sessions' => $sessions,
        ]);
    }

    public function finish(Request $request, ShipmentSession $session)
    {
        if ($session->status !== 'dalam_perjalanan') {
            return redirect()->back()->with('status', 'Shipment ini tidak bisa diselesaikan.');
        }

        $validated = $request->validate([
            'admin_nama' => ['nullable', 'string', 'max:255'],
            'order_ids' => ['nullable', 'array'],
            'order_ids.*' => ['integer', 'exists:orders,id'],
        ]);

        $selectedIds = array_values(array_unique(array_map('intval', $validated['order_ids'] ?? [])));
        if (count($selectedIds) === 0) {
            $selectedIds = array_map('intval', (array) ($session->order_ids ?? []));
        }

        $orders = Order::query()->whereIn('id', $selectedIds)->get();
        if ($orders->isEmpty()) {
            return redirect()->back()->with('status', 'Tidak ada pesanan yang dipilih.');
        }

        $now = Carbon::now();

        DB::transaction(function () use ($session, $orders, $validated, $now) {
            foreach ($orders as $order) {
                if (in_array($order->status, ['selesai', 'dibatalkan'], true)) {
                    continue;
                }

                $prevStatus = $order->status;
                $order->update(['status' => 'selesai']);

                OrderHistory::create([
                    'order_id' => $order->id,
                    'status_sebelumnya' => $prevStatus,
                    'status_baru' => 'selesai',
                    'keterangan' => 'Pesanan selesai',
                    'admin_nama' => $validated['admin_nama'] ?: null,
                ]);
            }

            $remaining = Order::query()
                ->whereIn('id', (array) ($session->order_ids ?? []))
                ->whereNotIn('status', ['selesai', 'dibatalkan'])
                ->count();

            if ($remaining === 0) {
                $session->update([
                    'status' => 'selesai',
                    'waktu_selesai' => $now,
                    'admin_selesaikan_nama' => $validated['admin_nama'] ?: null,
                ]);

                $truck = Truck::find($session->truck_id);
                $driver = Driver::find($session->driver_id);

                if ($truck) {
                    $truck->update(['status' => 'tersedia']);
                }
                if ($driver) {
                    $driver->update(['status' => 'aktif']);
                }
            }
        });

        return redirect()->route('admin.shipments.active')->with('status', 'Shipment berhasil diperbarui.');
    }

    public function history(Request $request)
    {
        $query = ShipmentSession::query()
            ->with(['truck', 'driver'])
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->orderByDesc('waktu_berangkat');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('truck_id')) {
            $query->where('truck_id', $request->integer('truck_id'));
        }
        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->integer('driver_id'));
        }
        if ($request->filled('from')) {
            $query->whereDate('waktu_berangkat', '>=', $request->string('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('waktu_berangkat', '<=', $request->string('to'));
        }

        $sessions = $query->get();
        $sessions->each(function (ShipmentSession $session) {
            $session->setRelation(
                'orders',
                Order::query()
                    ->whereIn('id', (array) ($session->order_ids ?? []))
                    ->orderBy('created_at')
                    ->get()
            );
        });

        return view('admin.shipments.history', [
            'sessions' => $sessions,
            'trucks' => Truck::query()->orderBy('plat_nomor')->get(),
            'drivers' => Driver::query()->orderBy('nama')->get(),
        ]);
    }
}
