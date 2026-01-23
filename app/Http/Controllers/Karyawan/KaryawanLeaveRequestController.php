<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryawanLeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $leaves = LeaveRequest::query()
            ->where('employee_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('karyawan.leave.index', compact('leaves'));
    }

    public function create()
    {
        return view('karyawan.leave.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $rules = [
            'tipe' => ['required', 'string', 'in:sakit,cuti_tahunan,melahirkan,menikah,duka_keluarga_inti,duka_bukan_keluarga_inti'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'alasan' => ['nullable', 'string'],
            'dokumen_pendukung' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'signature' => ['required', 'string'],
        ];

        if (in_array($request->input('tipe'), ['sakit', 'menikah'])) {
            $rules['dokumen_pendukung'][0] = 'required';
        }

        $messages = [
            'dokumen_pendukung.required' => '*Dokumen pendukung Wajib diisi',
            'signature.required' => 'Tanda tangan wajib diisi.',
        ];

        $data = $request->validate($rules, $messages);

        $path = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $path = $request->file('dokumen_pendukung')->store('izin', 'public');
        }

        $signaturePath = null;
        if ($request->filled('signature')) {
            $image_parts = explode(";base64,", $request->signature);
            if (count($image_parts) > 1) {
                $image_base64 = base64_decode($image_parts[1]);
                $signaturePath = 'signatures/' . uniqid() . '.png';
                Storage::disk('public')->put($signaturePath, $image_base64);
            }
        }

        LeaveRequest::create([
            'employee_id' => $user->id,
            'tipe' => $data['tipe'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'alasan' => $data['alasan'] ?? null,
            'dokumen_pendukung' => $path,
            'signature' => $signaturePath,
            'status' => 'pending',
        ]);

        return redirect()->route('karyawan.leave.index')->with('status', 'Pengajuan Izin anda berhasil terkirim');
    }

    public function destroy(LeaveRequest $leave)
    {
        $user = request()->user();

        if ($leave->employee_id !== $user->id) {
            abort(403);
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan pending yang bisa dihapus.');
        }

        $leave->delete();

        return back()->with('status', 'Pengajuan berhasil dihapus.');
    }

    public function cancel(LeaveRequest $leave)
    {
        $user = request()->user();

        if ($leave->employee_id !== $user->id) {
            abort(403);
        }

        if ($leave->status !== 'approved') {
            return back()->with('error', 'Hanya pengajuan yang sudah disetujui yang bisa diajukan pembatalan.');
        }

        $leave->update([
            'status' => 'cancellation_requested',
        ]);

        return back()->with('status', 'Permintaan pembatalan berhasil dikirim ke admin.');
    }
}
