<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $types = $this->getLeaveTypeDefinitions();
        $quota = $this->buildQuota($user->id, $types);

        return view('karyawan.leave.index', compact('leaves', 'quota', 'types'));
    }

    public function create()
    {
        $user = request()->user();

        $types = $this->getLeaveTypeDefinitions();
        $quota = $this->buildQuota($user->id, $types);

        return view('karyawan.leave.create', [
            'quota' => $quota,
            'types' => $types,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $types = $this->getLeaveTypeDefinitions();
        $typeKeys = array_keys($types);
        $typeList = implode(',', $typeKeys);

        $rules = [
            'kategori' => ['required', 'string', 'in:paid,unpaid'],
            'tipe' => ['required', 'string', "in:{$typeList}"],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'alasan' => ['required', 'string'],
            'dokumen_pendukung' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'signature' => ['required', 'string'],
        ];

        if ($request->filled(['tanggal_mulai', 'tanggal_selesai', 'tipe'])) {
            $start = Carbon::parse($request->tanggal_mulai);
            $end = Carbon::parse($request->tanggal_selesai);
            $diffInDays = $start->diffInDays($end) + 1;

            $quota = $this->buildQuota($user->id, $types);
            $quotaInfo = $quota[$request->tipe] ?? null;
            $typeInfo = $types[$request->tipe] ?? null;

            if ($quotaInfo && $quotaInfo['remaining'] !== null && $diffInDays > $quotaInfo['remaining']) {
                $label = $quotaInfo['label'];
                $remaining = $quotaInfo['remaining'];
                $period = $quotaInfo['period'] ?? '';
                $periodLabel = $period === 'bulan' ? 'bulan ini' : ($period === 'tahun' ? 'tahun ini' : 'untuk kejadian ini');

                return back()->withErrors(['tipe' => "Sisa kuota {$label} {$periodLabel} tidak mencukupi. (Sisa: {$remaining} hari)"])->withInput();
            }

            $maxDays = $typeInfo['max_days'] ?? null;
            if ($maxDays !== null && $diffInDays > $maxDays) {
                return back()->withErrors(['tanggal_selesai' => "Maksimal izin {$typeInfo['label']} adalah {$maxDays} hari."])->withInput();
            }

            if ($request->tipe === 'sakit') {
                if ($diffInDays > 2) {
                    $rules['dokumen_pendukung'][0] = 'required';
                }
            }

            if ($request->tipe === 'menikah') {
                $rules['dokumen_pendukung'][0] = 'required';
            }
        }

        $messages = [
            'dokumen_pendukung.required' => '*Dokumen pendukung Wajib diisi.',
            'signature.required' => 'Tanda tangan wajib diisi.',
        ];

        $data = $request->validate($rules, $messages);
        $category = $data['kategori'] ?? '';
        $type = $data['tipe'] ?? '';
        $typeInfo = $types[$type] ?? null;
        if (! $typeInfo || ($typeInfo['kategori'] ?? '') !== $category) {
            return back()->withErrors(['tipe' => 'Jenis izin tidak sesuai dengan kategori.'])->withInput();
        }

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

    private function getLeaveTypeDefinitions(): array
    {
        return [
            'cuti_tahunan' => ['label' => 'Cuti Tahunan', 'kategori' => 'paid', 'limit' => 12, 'period' => 'tahun', 'max_days' => 12],
            'sakit' => ['label' => 'Sakit', 'kategori' => 'paid', 'limit' => 3, 'period' => 'bulan', 'max_days' => 3],
            'melahirkan' => ['label' => 'Melahirkan', 'kategori' => 'paid', 'limit' => 30, 'period' => 'tahun', 'max_days' => 30],
            'menikah' => ['label' => 'Menikah', 'kategori' => 'paid', 'limit' => 3, 'period' => 'tahun', 'max_days' => 3],
            'duka_keluarga_inti' => ['label' => 'Duka Keluarga Inti', 'kategori' => 'paid', 'limit' => 3, 'period' => 'kejadian', 'max_days' => 3],
            'duka_bukan_keluarga_inti' => ['label' => 'Duka Bukan Keluarga Inti', 'kategori' => 'paid', 'limit' => 1, 'period' => 'kejadian', 'max_days' => 1],
            'cuti_tidak_dibayar' => ['label' => 'Cuti Tidak Dibayar', 'kategori' => 'unpaid', 'limit' => null, 'period' => null, 'max_days' => 30],
        ];
    }

    private function buildQuota(int $employeeId, array $types): array
    {
        $sumDays = function ($query) {
            return (int) $query->get()->sum(function ($leave) {
                return Carbon::parse($leave->tanggal_mulai)
                        ->diffInDays(Carbon::parse($leave->tanggal_selesai)) + 1;
            });
        };

        $year = now()->year;
        $month = now()->month;
        $baseQuery = LeaveRequest::query()
            ->where('employee_id', $employeeId)
            ->whereIn('status', ['approved', 'pending']);

        $quota = [];
        foreach ($types as $key => $info) {
            $used = 0;
            if (($info['period'] ?? null) === 'tahun') {
                $used = $sumDays((clone $baseQuery)->where('tipe', $key)->whereYear('tanggal_mulai', $year));
            } elseif (($info['period'] ?? null) === 'bulan') {
                $used = $sumDays((clone $baseQuery)->where('tipe', $key)->whereYear('tanggal_mulai', $year)->whereMonth('tanggal_mulai', $month));
            }

            $limit = $info['limit'] ?? null;
            $remaining = $limit === null ? null : max(0, $limit - $used);

            $quota[$key] = [
                'label' => $info['label'],
                'limit' => $limit,
                'used' => $used,
                'remaining' => $remaining,
                'period' => $info['period'] ?? null,
                'kategori' => $info['kategori'] ?? null,
                'max_days' => $info['max_days'] ?? null,
            ];
        }

        return $quota;
    }
}
