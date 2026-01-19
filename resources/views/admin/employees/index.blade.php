@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manajemen Karyawan</h1>
    <a href="{{ route('admin.karyawan.create') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm">Tambah</a>
</div>

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left">
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
                    <tr class="border-t">
                        <td class="p-3">{{ $e->nip }}</td>
                        <td class="p-3">{{ $e->name }}</td>
                        <td class="p-3">{{ $e->phone }}</td>
                        <td class="p-3">{{ $e->department?->nama_department }}</td>
                        <td class="p-3">{{ $e->shift?->nama_shift }}</td>
                        <td class="p-3">{{ $e->status }}</td>
                        <td class="p-3 flex gap-2">
                            <a class="px-3 py-1 rounded-lg border" href="{{ route('admin.karyawan.show', $e) }}">Detail</a>
                            <a class="px-3 py-1 rounded-lg border" href="{{ route('admin.karyawan.edit', $e) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.karyawan.destroy', $e) }}" onsubmit="return confirm('Hapus karyawan ini?')">
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

<div class="mt-6">{{ $employees->links() }}</div>
@endsection

