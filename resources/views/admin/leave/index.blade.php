@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Manage Izin/Cuti</h1>

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left">
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
                    <tr class="border-t">
                        <td class="p-3">{{ $l->employee?->name }} ({{ $l->employee?->nip }})</td>
                        <td class="p-3">{{ $l->tipe }}</td>
                        <td class="p-3">{{ $l->tanggal_mulai?->toDateString() }} - {{ $l->tanggal_selesai?->toDateString() }}</td>
                        <td class="p-3">{{ $l->alasan }}</td>
                        <td class="p-3">{{ $l->status }}</td>
                        <td class="p-3">
                            @if($l->status === 'pending')
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('admin.leave.approve', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1 rounded-lg bg-green-600 text-white">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.leave.reject', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1 rounded-lg bg-red-600 text-white">Reject</button>
                                    </form>
                                </div>
                            @elseif($l->status === 'cancellation_requested')
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs text-orange-600 font-bold">Request Batal</span>
                                    <form method="POST" action="{{ route('admin.leave.approve_cancellation', $l) }}">
                                        @csrf
                                        <button class="px-3 py-1 rounded-lg bg-orange-600 text-white text-xs">Setujui Batal</button>
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

