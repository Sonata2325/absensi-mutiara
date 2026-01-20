@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Karyawan</h1>
        <p class="text-gray-500 mt-1 text-sm">Kelola data karyawan dan status aktif</p>
    </div>
    <a href="{{ route('admin.karyawan.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-[#D61600] text-white text-sm font-semibold shadow-sm hover:bg-[#b01200] transition">
        Tambah Karyawan
    </a>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-3">NIP</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Nomor Telepon</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Shift</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $e)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $e->nip }}</td>
                        <td class="p-3">{{ $e->name }}</td>
                        <td class="p-3">{{ $e->phone }}</td>
                        <td class="p-3">{{ $e->department?->nama_department }}</td>
                        <td class="p-3">{{ $e->shift?->nama_shift }}</td>
                        <td class="p-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $e->status === 'aktif' ? 'bg-green-50 text-green-700 ring-1 ring-green-200' : 'bg-gray-100 text-gray-600 ring-1 ring-gray-200' }}">
                                {{ $e->status }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex flex-wrap gap-2">
                                <a class="px-3 py-1.5 rounded-lg border text-gray-700 hover:bg-gray-50" href="{{ route('admin.karyawan.show', $e) }}">Detail</a>
                                <a class="px-3 py-1.5 rounded-lg border text-gray-700 hover:bg-gray-50" href="{{ route('admin.karyawan.edit', $e) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.karyawan.destroy', $e) }}" onsubmit="return confirm('Hapus karyawan ini?')">
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

<div class="mt-6">{{ $employees->links() }}</div>
@endsection
