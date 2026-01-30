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
        $user = request()->user();
        
        $usedDays = LeaveRequest::query()
            ->where('employee_id', $user->id)
            ->where('tipe', 'cuti_tahunan')
            ->whereIn('status', ['approved', 'pending'])
            ->whereYear('tanggal_mulai', now()->year)
            ->get()
            ->sum(function ($leave) {
                return \Illuminate\Support\Carbon::parse($leave->tanggal_mulai)
                    ->diffInDays(\Illuminate\Support\Carbon::parse($leave->tanggal_selesai)) + 1;
            });
            
        $remainingQuota = max(0, 12 - $usedDays);

        return view('karyawan.leave.create', compact('remainingQuota'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $type = (string) $request->input('tipe', '');
        if ($type === 'melahirkan' && $request->filled('tanggal_acuan')) {
            $acuan = \Illuminate\Support\Carbon::parse($request->input('tanggal_acuan'));
            $startCalc = (clone $acuan)->subDays(30)->toDateString();
            $endCalc = (clone $acuan)->addDays(29)->toDateString();
            $request->merge([
                'tanggal_mulai' => $startCalc,
                'tanggal_selesai' => $endCalc,
            ]);
        }

        $rules = [
            'tipe' => ['required', 'string', 'in:sakit,cuti_tahunan,melahirkan,menikah,duka_keluarga_inti,duka_bukan_keluarga_inti,ulang_tahun,idul_fitri,tahun_baru'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'alasan' => ['nullable', 'string'],
            'dokumen_pendukung' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'signature' => ['required', 'string'],
        ];

        // Validasi logika khusus sebelum validasi Laravel
        if ($request->filled(['tanggal_mulai', 'tanggal_selesai', 'tipe'])) {
            $start = \Illuminate\Support\Carbon::parse($request->tanggal_mulai);
            $end = \Illuminate\Support\Carbon::parse($request->tanggal_selesai);
            $diffInDays = $start->diffInDays($end) + 1;

            // 1. Logika Sakit
            if ($request->tipe === 'sakit') {
                // Jika > 2 hari, dokumen wajib
                if ($diffInDays > 2) {
                    $rules['dokumen_pendukung'][0] = 'required';
                }
            }
            
            // 2. Logika Cuti Tahunan
            if ($request->tipe === 'cuti_tahunan') {
                // Max 5 hari berurutan
                if ($diffInDays > 5) {
                    return back()->withErrors(['tanggal_selesai' => 'Maksimal cuti tahunan adalah 5 hari berurutan.'])->withInput();
                }

                // Cek Quota (12 hari per tahun)
                $usedDays = LeaveRequest::query()
                    ->where('employee_id', $user->id)
                    ->where('tipe', 'cuti_tahunan')
                    ->whereIn('status', ['approved', 'pending'])
                    ->whereYear('tanggal_mulai', now()->year)
                    ->get()
                    ->sum(function ($leave) {
                        return \Illuminate\Support\Carbon::parse($leave->tanggal_mulai)
                            ->diffInDays(\Illuminate\Support\Carbon::parse($leave->tanggal_selesai)) + 1;
                    });
                
                if (($usedDays + $diffInDays) > 12) {
                    return back()->withErrors(['tipe' => "Sisa kuota cuti tahunan anda tidak mencukupi. (Terpakai: $usedDays, Sisa: " . (12 - $usedDays) . ")"])->withInput();
                }
            }

            // Logika Menikah (tetap wajib, max 2 hari)
            if ($request->tipe === 'menikah') {
                $rules['dokumen_pendukung'][0] = 'required';
                
                if ($diffInDays > 2) {
                    return back()->withErrors(['tanggal_selesai' => 'Maksimal izin menikah adalah 2 hari.'])->withInput();
                }
            }
            
            // Logika Duka Keluarga Inti (max 2 hari)
            if ($request->tipe === 'duka_keluarga_inti') {
                if ($diffInDays > 2) {
                    return back()->withErrors(['tanggal_selesai' => 'Maksimal izin duka keluarga inti adalah 2 hari.'])->withInput();
                }
            }
            
            // Logika Duka Bukan Keluarga Inti (max 1 hari)
            if ($request->tipe === 'duka_bukan_keluarga_inti') {
                if ($diffInDays > 1) {
                    return back()->withErrors(['tanggal_selesai' => 'Maksimal izin duka bukan keluarga inti adalah 1 hari.'])->withInput();
                }
            }

            // Ulang Tahun (sekali setahun, 1 hari)
            if ($request->tipe === 'ulang_tahun') {
                if ($diffInDays > 1) {
                    return back()->withErrors(['tanggal_selesai' => 'Ulang Tahun hanya boleh 1 hari.'])->withInput();
                }
                $count = LeaveRequest::query()
                    ->where('employee_id', $user->id)
                    ->where('tipe', 'ulang_tahun')
                    ->whereIn('status', ['approved', 'pending'])
                    ->whereYear('tanggal_mulai', now()->year)
                    ->count();
                if ($count >= 1) {
                    return back()->withErrors(['tipe' => 'Ulang Tahun hanya bisa diajukan sekali dalam setahun.'])->withInput();
                }
            }

            // Idul Fitri (sekali setahun, max 2 hari)
            if ($request->tipe === 'idul_fitri') {
                if ($diffInDays > 2) {
                    return back()->withErrors(['tanggal_selesai' => 'Idul Fitri maksimal 2 hari.'])->withInput();
                }
                $count = LeaveRequest::query()
                    ->where('employee_id', $user->id)
                    ->where('tipe', 'idul_fitri')
                    ->whereIn('status', ['approved', 'pending'])
                    ->whereYear('tanggal_mulai', now()->year)
                    ->count();
                if ($count >= 1) {
                    return back()->withErrors(['tipe' => 'Idul Fitri hanya bisa diajukan sekali dalam setahun.'])->withInput();
                }
            }

            // Tahun Baru (sekali setahun, 1 hari)
            if ($request->tipe === 'tahun_baru') {
                if ($diffInDays > 1) {
                    return back()->withErrors(['tanggal_selesai' => 'Tahun Baru hanya boleh 1 hari.'])->withInput();
                }
                $count = LeaveRequest::query()
                    ->where('employee_id', $user->id)
                    ->where('tipe', 'tahun_baru')
                    ->whereIn('status', ['approved', 'pending'])
                    ->whereYear('tanggal_mulai', now()->year)
                    ->count();
                if ($count >= 1) {
                    return back()->withErrors(['tipe' => 'Tahun Baru hanya bisa diajukan sekali dalam setahun.'])->withInput();
                }
            }
        }

        $messages = [
            'dokumen_pendukung.required' => '*Dokumen pendukung Wajib diisi.',
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
