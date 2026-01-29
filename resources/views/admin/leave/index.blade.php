@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Manage Izin/Cuti</h1>
        <p class="text-gray-500 mt-1 text-sm">Tinjau pengajuan dan status persetujuan</p>
    </div>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50/50 text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-medium">Karyawan</th>
                    <th class="px-6 py-4 font-medium">Tipe</th>
                    <th class="px-6 py-4 font-medium">Tanggal</th>
                    <th class="px-6 py-4 font-medium">Alasan</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($leaves as $l)
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $l->employee?->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ ucwords(str_replace('_', ' ', $l->tipe)) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $l->tanggal_mulai?->toDateString() }} - {{ $l->tanggal_selesai?->toDateString() }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $l->alasan }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $l->status === 'approved' ? 'bg-green-50 text-green-700 ring-1 ring-green-200/50' : '' }}
                                {{ $l->status === 'rejected' ? 'bg-red-50 text-red-700 ring-1 ring-red-200/50' : '' }}
                                {{ $l->status === 'pending' ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200/50' : '' }}
                                {{ $l->status === 'cancellation_requested' ? 'bg-orange-50 text-orange-700 ring-1 ring-orange-200/50' : '' }}
                            ">
                                {{ ucfirst(str_replace('_', ' ', $l->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($l->status === 'pending')
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('admin.leave.approve', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 rounded-xl bg-green-600 text-white hover:bg-green-700 transition shadow-sm font-medium text-xs">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.leave.reject', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition font-medium text-xs">Reject</button>
                                    </form>
                                </div>
                            @elseif($l->status === 'cancellation_requested')
                                <div class="flex flex-col gap-2">
                                    <span class="text-xs text-orange-600 font-medium">Request Batal</span>
                                    <form method="POST" action="{{ route('admin.leave.approve_cancellation', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 rounded-xl bg-orange-600 text-white text-xs hover:bg-orange-700 transition shadow-sm font-medium">Setujui Batal</button>
                                    </form>
                                </div>
                            @else
                                <div class="text-xs text-gray-500">
                                    <div class="font-medium text-gray-900">{{ $l->approver?->name }}</div>
                                    {{ optional($l->approval_date)->format('d M Y, H:i') }}
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
