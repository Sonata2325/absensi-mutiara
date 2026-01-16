@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manajemen Shift</h1>
    <a href="{{ route('admin.shifts.create') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm">Tambah</a>
</div>

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Nama Shift</th>
                    <th class="p-3">Jam</th>
                    <th class="p-3">Toleransi (menit)</th>
                    <th class="p-3">Aktif</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shifts as $s)
                    <tr class="border-t">
                        <td class="p-3">{{ $s->nama_shift }}</td>
                        <td class="p-3">{{ $s->jam_masuk }} - {{ $s->jam_keluar }}</td>
                        <td class="p-3">{{ $s->toleransi_terlambat }}</td>
                        <td class="p-3">{{ $s->is_active ? 'yes' : 'no' }}</td>
                        <td class="p-3 flex gap-2">
                            <a class="px-3 py-1 rounded-lg border" href="{{ route('admin.shifts.edit', $s) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.shifts.destroy', $s) }}" onsubmit="return confirm('Hapus shift ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 rounded-lg bg-red-600 text-white">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $shifts->links() }}</div>
@endsection

