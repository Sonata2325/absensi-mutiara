@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Manajemen Shift</h1>
        <p class="text-gray-500 mt-1 text-sm">Kelola jam kerja dan toleransi</p>
    </div>
    <a href="{{ route('admin.shifts.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium shadow-sm hover:bg-gray-800 transition">
        Tambah Shift
    </a>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50/50 text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-medium">Nama Shift</th>
                    <th class="px-6 py-4 font-medium">Jam</th>
                    <th class="px-6 py-4 font-medium">Toleransi (menit)</th>
                    <th class="px-6 py-4 font-medium">Aktif</th>
                    <th class="px-6 py-4 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($shifts as $s)
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $s->nama_shift }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $s->jam_masuk }} - {{ $s->jam_keluar }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $s->toleransi_terlambat }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $s->is_active ? 'bg-green-50 text-green-700 ring-1 ring-green-200/50' : 'bg-gray-100 text-gray-600 ring-1 ring-gray-200/50' }}">
                                {{ $s->is_active ? 'aktif' : 'nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a class="px-3 py-1.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition text-xs font-medium" href="{{ route('admin.shifts.edit', $s) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.shifts.destroy', $s) }}" onsubmit="return confirm('Hapus shift ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition text-xs font-medium">Hapus</button>
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
