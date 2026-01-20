@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manage Izin/Cuti</h1>
        <p class="text-gray-500 mt-1 text-sm">Tinjau pengajuan dan status persetujuan</p>
    </div>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-3">Karyawan</th>
                    <th class="p-3">Tipe</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Alasan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $l)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $l->employee?->name }} ({{ $l->employee?->nip }})</td>
                        <td class="p-3">{{ $l->tipe }}</td>
                        <td class="p-3">{{ $l->tanggal_mulai?->toDateString() }} - {{ $l->tanggal_selesai?->toDateString() }}</td>
                        <td class="p-3">{{ $l->alasan }}</td>
                        <td class="p-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $l->status === 'approved' ? 'bg-green-50 text-green-700 ring-1 ring-green-200' : '' }}
                                {{ $l->status === 'rejected' ? 'bg-red-50 text-red-700 ring-1 ring-red-200' : '' }}
                                {{ $l->status === 'pending' ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200' : '' }}
                                {{ $l->status === 'cancellation_requested' ? 'bg-orange-50 text-orange-700 ring-1 ring-orange-200' : '' }}
                            ">
                                {{ $l->status }}
                            </span>
                        </td>
                        <td class="p-3">
                            @if($l->status === 'pending')
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('admin.leave.approve', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 rounded-lg bg-green-600 text-white hover:bg-green-700">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.leave.reject', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700">Reject</button>
                                    </form>
                                </div>
                            @elseif($l->status === 'cancellation_requested')
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs text-orange-600 font-bold">Request Batal</span>
                                    <form method="POST" action="{{ route('admin.leave.approve_cancellation', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 rounded-lg bg-orange-600 text-white text-xs hover:bg-orange-700">Setujui Batal</button>
                                    </form>
                                </div>
                            @else
                                <div class="text-xs text-gray-600">
                                    {{ $l->approver?->name }}<br>
                                    {{ optional($l->approval_date)->format('Y-m-d H:i') }}
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $leaves->links() }}</div>
@endsection
