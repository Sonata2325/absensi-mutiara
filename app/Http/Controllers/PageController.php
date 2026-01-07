<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    // public function about()
    // {
    //     return view('about');
    // }

    public function services()
    {
        return view('services');
    }

    public function tracking()
    {
        $resi = (string) request()->query('resi', '');
        $order = null;
        $history = collect();
        $otherOrdersCount = null;

        if ($resi !== '') {
            $order = Order::with(['truck', 'driver', 'shipmentSession', 'history'])
                ->where('nomor_resi', $resi)
                ->first();

            if ($order) {
                $history = OrderHistory::where('order_id', $order->id)->orderBy('created_at')->get();

                if ($order->shipment_session_id) {
                    $sessionOrderIds = (array) ($order->shipmentSession?->order_ids ?? []);
                    $otherOrdersCount = max(0, count($sessionOrderIds) - 1);
                }
            }
        }

        return view('tracking', [
            'order' => $order,
            'history' => $history,
            'otherOrdersCount' => $otherOrdersCount,
        ]);
    }

    public function order()
    {
        return view('order');
    }

    public function submitOrder(Request $request)
    {
        $serviceType = strtolower((string) $request->input('service_type', ''));
        if (! in_array($serviceType, ['b2b', 'b2c'], true)) {
            $serviceType = 'b2b';
        }

        $rules = [
            'receiver_name' => ['required', 'string', 'max:255'],
            'receiver_phone' => ['required', 'string', 'max:50'],
            'receiver_address' => ['required', 'string'],
            'item_description' => ['required', 'string'],
            'item_weight_kg' => ['required', 'numeric', 'min:0.01'],
        ];
        if ($serviceType === 'b2b') {
            $rules = array_merge($rules, [
                'sender_company' => ['required', 'string', 'max:255'],
                'sender_contact' => ['required', 'string', 'max:255'],
                'sender_phone' => ['required', 'string', 'max:50'],
                'sender_email' => ['required', 'email', 'max:255'],
                'pickup_address' => ['required', 'string'],
            ]);
        } else {
            $rules = array_merge($rules, [
                'sender_name' => ['required', 'string', 'max:255'],
                'sender_phone_b2c' => ['required', 'string', 'max:50'],
                'sender_email_b2c' => ['required', 'email', 'max:255'],
                'office_id' => ['required', 'string', 'max:50'],
            ]);
        }
        $request->validate($rules);

        $status = $serviceType === 'b2b' ? 'menunggu_konfirmasi' : 'menunggu_drop_barang';

        $order = DB::transaction(function () use ($request, $serviceType, $status) {
            $prefix = 'MJE'.now()->format('Ymd');
            $last = Order::where('nomor_resi', 'like', $prefix.'%')
                ->orderBy('nomor_resi', 'desc')
                ->first();

            $seq = 1;
            if ($last) {
                $tail = (int) substr((string) $last->nomor_resi, -3);
                $seq = max(1, $tail + 1);
            }

            $resi = $prefix.str_pad((string) $seq, 3, '0', STR_PAD_LEFT);
            while (Order::where('nomor_resi', $resi)->exists()) {
                $seq++;
                $resi = $prefix.str_pad((string) $seq, 3, '0', STR_PAD_LEFT);
            }

            $senderPhone = $serviceType === 'b2b' ? $request->input('sender_phone') : $request->input('sender_phone_b2c');
            $senderEmail = $serviceType === 'b2b' ? $request->input('sender_email') : $request->input('sender_email_b2c');

            $order = Order::create([
                'nomor_resi' => $resi,
                'jenis_layanan' => $serviceType,
                'pengirim_nama' => $serviceType === 'b2b' ? $request->input('sender_company') : $request->input('sender_name'),
                'pengirim_kontak_person' => $serviceType === 'b2b' ? $request->input('sender_contact') : null,
                'pengirim_telepon' => $senderPhone,
                'pengirim_email' => $senderEmail,
                'pengirim_alamat_pickup' => $serviceType === 'b2b' ? $request->input('pickup_address') : null,
                'pengirim_jadwal_pickup' => $serviceType === 'b2b' ? $request->input('pickup_schedule') : null,
                'pengirim_catatan_pickup' => $serviceType === 'b2b' ? $request->input('pickup_note') : null,
                'pengirim_office_id' => $serviceType === 'b2c' ? $request->input('office_id') : null,
                'penerima_nama' => $request->input('receiver_name'),
                'penerima_telepon' => $request->input('receiver_phone'),
                'penerima_alamat' => $request->input('receiver_address'),
                'penerima_catatan' => $request->input('receiver_note'),
                'deskripsi_barang' => $request->input('item_description'),
                'berat_kg' => (float) $request->input('item_weight_kg'),
                'panjang_cm' => $request->input('item_length_cm'),
                'lebar_cm' => $request->input('item_width_cm'),
                'tinggi_cm' => $request->input('item_height_cm'),
                'jenis_armada_diminta' => $request->input('fleet_type'),
                'fragile' => (bool) $request->boolean('item_fragile'),
                'catatan_barang' => $request->input('item_note'),
                'status' => $status,
                'tanggal_order' => now(),
                'qr_code_data' => [],
            ]);

            $qr = [
                'resi' => $order->nomor_resi,
                'jenis' => strtoupper($order->jenis_layanan),
                'pengirim' => (string) ($order->pengirim_nama ?: ''),
                'penerima' => (string) $order->penerima_nama,
                'alamat_tujuan' => (string) $order->penerima_alamat,
                'berat' => rtrim(rtrim((string) $order->berat_kg, '0'), '.').'kg',
                'deskripsi' => (string) $order->deskripsi_barang,
                'tanggal_order' => $order->tanggal_order?->toDateString(),
            ];
            $checksum = hash_hmac('sha256', json_encode($qr), (string) config('app.key'));
            $qr['checksum'] = $checksum;

            $order->update([
                'qr_code_data' => $qr,
                'qr_checksum' => $checksum,
            ]);

            OrderHistory::create([
                'order_id' => $order->id,
                'status_sebelumnya' => null,
                'status_baru' => $order->status,
                'keterangan' => 'Pesanan Dibuat',
            ]);

            return $order;
        });

        return redirect()->route('order.success', ['resi' => $order->nomor_resi]);
    }

    public function orderSuccess(Request $request)
    {
        $resi = (string) $request->query('resi', '');
        $order = Order::where('nomor_resi', $resi)->first();

        if (! $order) {
            return redirect()->route('order')->with('status', 'Nomor resi tidak ditemukan. Silakan buat pesanan baru.');
        }

        $office = null;
        if ($order->jenis_layanan === 'b2c') {
            $office = match ($order->pengirim_office_id) {
                'jelambar' => [
                    'name' => 'Kantor Pusat - Jelambar',
                    'address' => 'Ruko Jelambar Center, Blok E41, Jl P. TB. Angke No 10, Jelambar Baru, Jakarta Barat',
                    'hours' => 'Senin–Sabtu 08:00–17:00',
                ],
                'bandung' => [
                    'name' => 'Kantor Bandung',
                    'address' => 'Bandung, Jawa Barat',
                    'hours' => 'Senin–Sabtu 08:00–17:00',
                ],
                'surabaya' => [
                    'name' => 'Kantor Surabaya',
                    'address' => 'Surabaya, Jawa Timur',
                    'hours' => 'Senin–Sabtu 08:00–17:00',
                ],
                default => null,
            };
        }

        return view('order-success', [
            'order' => $order,
            'resi' => $order->nomor_resi,
            'office' => $office,
            'qrPayload' => json_encode($order->qr_code_data ?? []),
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContact(Request $request)
    {
        return redirect()
            ->route('contact')
            ->with('status', 'Pesan berhasil dikirim. Tim kami akan membalas maksimal 1x24 jam.');
    }
}
