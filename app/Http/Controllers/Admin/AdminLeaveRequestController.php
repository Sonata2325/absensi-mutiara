<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class AdminLeaveRequestController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::query()
            ->with(['employee', 'approver'])
            ->orderByRaw("case when status = 'pending' then 0 else 1 end")
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.leave.index', compact('leaves'));
    }

    public function approveCancellation(Request $request, LeaveRequest $leave)
    {
        $data = $request->validate([
            'approval_note' => ['nullable', 'string'],
        ]);

        $leave->update([
            'status' => 'cancelled',
            'approved_by' => $request->user()->id,
            'approval_date' => now(),
            'approval_note' => $data['approval_note'] ?? null,
        ]);

        return back()->with('status', 'Pengajuan berhasil dibatalkan (status: cancelled).');
    }

    public function approve(Request $request, LeaveRequest $leave)
    {
        $data = $request->validate([
            'approval_note' => ['nullable', 'string'],
        ]);

        $leave->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approval_date' => now(),
            'approval_note' => $data['approval_note'] ?? null,
        ]);

        return back()->with('status', 'Pengajuan berhasil di-approve.');
    }

    public function reject(Request $request, LeaveRequest $leave)
    {
        $data = $request->validate([
            'approval_note' => ['nullable', 'string'],
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => $request->user()->id,
            'approval_date' => now(),
            'approval_note' => $data['approval_note'] ?? null,
        ]);

        return back()->with('status', 'Pengajuan berhasil di-reject.');
    }
}
