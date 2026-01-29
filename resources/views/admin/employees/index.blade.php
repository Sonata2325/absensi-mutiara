@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Manajemen Karyawan</h1>
    <a href="{{ route('admin.karyawan.create') }}" class="px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium shadow-sm hover:bg-gray-800 transition">Tambah Karyawan</a>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50/50 text-left border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs">Nama</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs">Nomor Telepon</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs">Posisi</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs">Shift</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs">Status</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-xs">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($employees as $e)
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4 text-gray-900 font-medium">{{ $e->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $e->phone }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $e->position?->nama_posisi }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $e->shift?->nama_shift }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $e->status === 'aktif' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ $e->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a class="px-3 py-1.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition text-xs font-medium" href="{{ route('admin.karyawan.show', $e) }}">Detail</a>
                            <a class="px-3 py-1.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition text-xs font-medium" href="{{ route('admin.karyawan.edit', $e) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.karyawan.destroy', $e) }}" onsubmit="return confirm('Hapus karyawan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition text-xs font-medium">Hapus</button>
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
