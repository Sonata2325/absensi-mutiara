@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Manajemen Posisi</h1>
        <p class="text-gray-500 mt-1 text-sm">Atur struktur dan deskripsi posisi</p>
    </div>
    <a href="{{ route('admin.positions.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium shadow-sm hover:bg-gray-800 transition">
        Tambah Posisi
    </a>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50/50 text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-medium">Kode</th>
                    <th class="px-6 py-4 font-medium">Nama</th>
                    <th class="px-6 py-4 font-medium">Deskripsi</th>
                    <th class="px-6 py-4 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($positions as $p)
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $p->kode_posisi }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $p->nama_posisi }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $p->deskripsi }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a class="px-3 py-1.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition text-xs font-medium" href="{{ route('admin.positions.edit', $p) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.positions.destroy', $p) }}" onsubmit="return confirm('Hapus posisi ini?')">
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

<div class="mt-6">{{ $positions->links() }}</div>
@endsection
