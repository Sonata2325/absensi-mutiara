@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Posisi</h1>
        <p class="text-gray-500 mt-1 text-sm">Atur struktur dan deskripsi posisi</p>
    </div>
    <a href="{{ route('admin.positions.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-[#D61600] text-white text-sm font-semibold shadow-sm hover:bg-[#b01200] transition">
        Tambah Posisi
    </a>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($positions as $p)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $p->kode_posisi }}</td>
                        <td class="p-3">{{ $p->nama_posisi }}</td>
                        <td class="p-3">{{ $p->deskripsi }}</td>
                        <td class="p-3">
                            <div class="flex flex-wrap gap-2">
                                <a class="px-3 py-1.5 rounded-lg border text-gray-700 hover:bg-gray-50" href="{{ route('admin.positions.edit', $p) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.positions.destroy', $p) }}" onsubmit="return confirm('Hapus posisi ini?')">
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

<div class="mt-6">{{ $positions->links() }}</div>
@endsection
