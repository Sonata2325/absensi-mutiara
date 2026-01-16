@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manajemen Department</h1>
    <a href="{{ route('admin.departments.create') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm">Tambah</a>
</div>

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $d)
                    <tr class="border-t">
                        <td class="p-3">{{ $d->kode_department }}</td>
                        <td class="p-3">{{ $d->nama_department }}</td>
                        <td class="p-3">{{ $d->deskripsi }}</td>
                        <td class="p-3 flex gap-2">
                            <a class="px-3 py-1 rounded-lg border" href="{{ route('admin.departments.edit', $d) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.departments.destroy', $d) }}" onsubmit="return confirm('Hapus department ini?')">
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

<div class="mt-6">{{ $departments->links() }}</div>
@endsection

