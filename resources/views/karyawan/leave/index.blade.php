@extends('layouts.app')

@section('content')
@if(session('status') === 'Pengajuan Izin anda berhasil terkirim')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('status') }}',
            icon: 'success',
            confirmButtonColor: '#D61600',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pengajuan Izin</h1>
            <p class="text-gray-500 mt-1">Kelola riwayat cuti dan izin Anda</p>
        </div>
        <a href="{{ route('karyawan.leave.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#D61600] text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-red-200 hover:bg-[#b01200] hover:shadow-xl transition-all active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            <span>Ajukan Baru</span>
        </a>
    </div>

    <div class="bg-[#D61600] rounded-2xl border border-[#D61600] shadow-lg p-6 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
            <div>
                <h2 class="text-xl font-bold text-white">Ringkasan Kuota Izin</h2>
                <p class="text-sm text-white/80 mt-1">Sisa kuota berdasarkan jenis izin</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($quota as $info)
                <div class="border border-white/20 rounded-2xl p-5 bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-colors">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-sm font-bold text-white tracking-wide">{{ $info['label'] }}</div>
                        <span class="text-[10px] font-bold uppercase tracking-wider {{ $info['kategori'] === 'paid' ? 'text-[#D61600] bg-white' : 'text-white border border-white/30' }} px-2.5 py-1 rounded-full shadow-sm">
                            {{ $info['kategori'] === 'paid' ? 'Paid' : 'Unpaid' }}
                        </span>
                    </div>
                    <div class="text-3xl font-bold text-white tracking-tight mb-1">
                        @if($info['limit'] === null)
                            <span class="text-xl">∞</span>
                        @else
                            {{ $info['remaining'] }} <span class="text-lg text-white/60 font-medium">/ {{ $info['limit'] }}</span>
                        @endif
                    </div>
                    <div class="text-xs text-white/70 font-medium">
                        @if($info['limit'] !== null)
                            {{ $info['limit'] === null ? '' : 'Hari per ' . ($info['period'] === 'bulan' ? 'Bulan' : ($info['period'] === 'tahun' ? 'Tahun' : 'Kejadian')) }}
                        @else
                            Tanpa batas kuota
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Content Table -->
    @if($leaves->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase tracking-wider font-semibold text-xs">
                            <th class="px-6 py-4">Tipe Izin</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Alasan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($leaves as $l)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider inline-block
                                    {{ $l->tipe === 'sakit' ? 'bg-red-50 text-red-600' : 'bg-purple-50 text-purple-600' }}">
                                    {{ ucwords(str_replace('_', ' ', $l->tipe)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                                {{ $l->tanggal_mulai?->format('d M') }} 
                                <span class="text-gray-400 mx-1">→</span> 
                                {{ $l->tanggal_selesai?->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                {{ $l->alasan ?: '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium border
                                    {{ $l->status === 'approved' ? 'bg-green-50 text-green-700 border-green-100' : 
                                       ($l->status === 'rejected' ? 'bg-red-50 text-red-700 border-red-100' : 'bg-yellow-50 text-yellow-700 border-yellow-100') }}">
                                    @if($l->status === 'approved')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    @elseif($l->status === 'rejected')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    @endif
                                    {{ ucfirst($l->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($l->status === 'pending')
                                    <form action="{{ route('karyawan.leave.destroy', $l) }}" method="POST" onsubmit="return confirm('Yakin hapus pengajuan ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Batalkan
                                        </button>
                                    </form>
                                @elseif($l->status === 'approved')
                                    <form action="{{ route('karyawan.leave.cancel', $l) }}" method="POST" onsubmit="return confirm('Ajukan pembatalan untuk cuti ini?');" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-orange-500 hover:text-orange-700 font-medium text-xs bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Batal Cuti
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-8">
            {{ $leaves->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-gray-200">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-50 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Belum ada pengajuan</h3>
            <p class="text-gray-500 mt-1 max-w-sm mx-auto">Anda belum pernah mengajukan izin atau cuti sebelumnya. Mulai dengan menekan tombol ajukan.</p>
        </div>
    @endif
</div>
@endsection
