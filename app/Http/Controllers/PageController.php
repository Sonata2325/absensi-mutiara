<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        return view('tracking');
    }

    public function order()
    {
        return view('order');
    }

    public function submitOrder(Request $request)
    {
        $serviceType = strtolower((string) $request->input('service_type', ''));
        if (!in_array($serviceType, ['b2b', 'b2c'], true)) {
            $serviceType = 'b2b';
        }

        $resi = 'MJE' . now()->format('ymd') . strtoupper(Str::random(6));

        $order = [
            'resi' => $resi,
            'order_date' => now()->toDateTimeString(),
            'service_type' => $serviceType,
            'sender' => $serviceType === 'b2b'
                ? [
                    'company' => $request->input('sender_company'),
                    'contact' => $request->input('sender_contact'),
                    'phone' => $request->input('sender_phone'),
                    'email' => $request->input('sender_email'),
                    'pickup_address' => $request->input('pickup_address'),
                    'pickup_schedule' => $request->input('pickup_schedule'),
                    'pickup_note' => $request->input('pickup_note'),
                ]
                : [
                    'name' => $request->input('sender_name'),
                    'phone' => $request->input('sender_phone_b2c'),
                    'email' => $request->input('sender_email_b2c'),
                    'office_id' => $request->input('office_id'),
                ],
            'receiver' => [
                'name' => $request->input('receiver_name'),
                'phone' => $request->input('receiver_phone'),
                'address' => $request->input('receiver_address'),
                'note' => $request->input('receiver_note'),
            ],
            'item' => [
                'description' => $request->input('item_description'),
                'weight_kg' => $request->input('item_weight_kg'),
                'length_cm' => $request->input('item_length_cm'),
                'width_cm' => $request->input('item_width_cm'),
                'height_cm' => $request->input('item_height_cm'),
                'fleet_type' => $request->input('fleet_type'),
                'fragile' => (bool) $request->boolean('item_fragile'),
                'note' => $request->input('item_note'),
            ],
        ];

        $request->session()->put('last_order', $order);

        return redirect()->route('order.success', ['resi' => $resi]);
    }

    public function orderSuccess(Request $request)
    {
        $order = $request->session()->get('last_order');
        $resi = (string) $request->query('resi', '');

        if (is_array($order) && isset($order['resi'])) {
            $resi = (string) $order['resi'];
        }

        $office = null;
        if (is_array($order) && ($order['service_type'] ?? null) === 'b2c') {
            $officeId = $order['sender']['office_id'] ?? null;
            $office = match ($officeId) {
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
            'order' => is_array($order) ? $order : null,
            'resi' => $resi,
            'office' => $office,
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
