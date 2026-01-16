@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Pengajuan Izin/Cuti</h1>
    <a href="{{ route('karyawan.leave.create') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm">Ajukan</a>
</div>

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
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
                        <td class="p-3">{{ $l->tipe }}</td>
                        <td class="p-3">{{ $l->tanggal_mulai?->toDateString() }} - {{ $l->tanggal_selesai?->toDateString() }}</td>
                        <td class="p-3">{{ $l->alasan }}</td>
                        <td class="p-3">{{ $l->status }}</td>
                        <td class="p-3">
                            @if($l->status === 'pending')
                                <form action="{{ route('karyawan.leave.destroy', $l) }}" method="POST" onsubmit="return confirm('Yakin hapus pengajuan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            @elseif($l->status === 'approved')
                                <form action="{{ route('karyawan.leave.cancel', $l) }}" method="POST" onsubmit="return confirm('Ajukan pembatalan untuk cuti ini?');">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:underline">Batalkan</button>
                                </form>
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

