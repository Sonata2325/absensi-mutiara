@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Shift</h1>
        <p class="text-gray-500 mt-1 text-sm">Kelola jam kerja dan toleransi</p>
    </div>
    <a href="{{ route('admin.shifts.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-[#D61600] text-white text-sm font-semibold shadow-sm hover:bg-[#b01200] transition">
        Tambah Shift
    </a>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase tracking-wider text-gray-500">
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
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $s->nama_shift }}</td>
                        <td class="p-3">{{ $s->jam_masuk }} - {{ $s->jam_keluar }}</td>
                        <td class="p-3">{{ $s->toleransi_terlambat }}</td>
                        <td class="p-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $s->is_active ? 'bg-green-50 text-green-700 ring-1 ring-green-200' : 'bg-gray-100 text-gray-600 ring-1 ring-gray-200' }}">
                                {{ $s->is_active ? 'aktif' : 'nonaktif' }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex flex-wrap gap-2">
                                <a class="px-3 py-1.5 rounded-lg border text-gray-700 hover:bg-gray-50" href="{{ route('admin.shifts.edit', $s) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.shifts.destroy', $s) }}" onsubmit="return confirm('Hapus shift ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700">Hapus</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $shifts->links() }}</div>
@endsection
