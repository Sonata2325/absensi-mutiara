<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function newOrders()
    {
        $orders = Order::query()
            ->whereIn('status', ['menunggu_konfirmasi', 'menunggu_drop_barang'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.orders.new', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['truck', 'driver']);

        return view('admin.orders.show', [
            'order' => $order,
            'qrPayload' => json_encode($order->qr_code_data ?? []),
            'drivers' => Driver::query()->orderBy('nama')->get(),
        ]);
    }

    public function confirm(Request $request, Order $order)
    {
        if ($order->jenis_layanan !== 'b2b' || $order->status !== 'menunggu_konfirmasi') {
            return redirect()->back()->with('status', 'Pesanan ini tidak bisa dikonfirmasi.');
        }

        $validated = $request->validate([
            'admin_nama' => ['nullable', 'string', 'max:255'],
            'pickup_schedule' => ['required', 'date'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'catatan' => ['nullable', 'string'],
        ]);

        $prevStatus = $order->status;
        $order->update([
            'pengirim_jadwal_pickup' => $validated['pickup_schedule'],
            'driver_id' => $validated['driver_id'] ?? null,
            'status' => 'dikonfirmasi_menunggu_pickup',
        ]);

        OrderHistory::create([
            'order_id' => $order->id,
            'status_sebelumnya' => $prevStatus,
            'status_baru' => 'dikonfirmasi_menunggu_pickup',
            'keterangan' => trim((string) ($validated['catatan'] ?? '')) ?: 'Dikonfirmasi oleh admin',
            'admin_nama' => $validated['admin_nama'] ?: null,
        ]);

        return redirect()->route('admin.orders.show', $order)->with('status', 'Pesanan berhasil dikonfirmasi.');
    }

    public function cancel(Request $request, Order $order)
    {
        if (in_array($order->status, ['selesai', 'dibatalkan'], true)) {
            return redirect()->back()->with('status', 'Pesanan ini tidak bisa dibatalkan.');
        }

        $validated = $request->validate([
            'admin_nama' => ['nullable', 'string', 'max:255'],
            'alasan' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ]);

        $prevStatus = $order->status;
        $order->update(['status' => 'dibatalkan']);

        $detail = trim((string) ($validated['catatan'] ?? ''));
        $keterangan = 'Dibatalkan: '.$validated['alasan'].($detail !== '' ? "\n".$detail : '');

        OrderHistory::create([
            'order_id' => $order->id,
            'status_sebelumnya' => $prevStatus,
            'status_baru' => 'dibatalkan',
            'keterangan' => $keterangan,
            'admin_nama' => $validated['admin_nama'] ?: null,
        ]);

        return redirect()->route('admin.orders.new')->with('status', 'Pesanan berhasil dibatalkan.');
    }
}
