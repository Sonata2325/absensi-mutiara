<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

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

        $data = $request->validate([
            'tipe' => ['required', 'string', 'in:sakit,cuti,izin'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'alasan' => ['nullable', 'string'],
            'dokumen_pendukung' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $path = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $path = $request->file('dokumen_pendukung')->store('izin', 'public');
        }

        LeaveRequest::create([
            'employee_id' => $user->id,
            'tipe' => $data['tipe'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'alasan' => $data['alasan'] ?? null,
            'dokumen_pendukung' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('karyawan.leave.index')->with('status', 'Pengajuan berhasil dikirim.');
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
