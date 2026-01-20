@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Department</h1>
        <p class="text-gray-500 mt-1 text-sm">Atur struktur dan deskripsi department</p>
    </div>
    <a href="{{ route('admin.departments.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-[#D61600] text-white text-sm font-semibold shadow-sm hover:bg-[#b01200] transition">
        Tambah Department
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
                @foreach($departments as $d)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $d->kode_department }}</td>
                        <td class="p-3">{{ $d->nama_department }}</td>
                        <td class="p-3">{{ $d->deskripsi }}</td>
                        <td class="p-3">
                            <div class="flex flex-wrap gap-2">
                                <a class="px-3 py-1.5 rounded-lg border text-gray-700 hover:bg-gray-50" href="{{ route('admin.departments.edit', $d) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.departments.destroy', $d) }}" onsubmit="return confirm('Hapus department ini?')">
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

<div class="mt-6">{{ $departments->links() }}</div>
@endsection
