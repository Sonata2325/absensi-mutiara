@extends('layouts.app')

@section('content')
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

    <!-- Content Grid -->
    @if($leaves->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($leaves as $l)
                <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all relative overflow-hidden">
                    <!-- Status Indicator Line -->
                    <div class="absolute left-0 top-0 bottom-0 w-1 
                        {{ $l->status === 'approved' ? 'bg-green-500' : ($l->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-400') }}">
                    </div>

                    <div class="flex justify-between items-start mb-4 pl-2">
                        <!-- Type Badge -->
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            {{ $l->tipe === 'sakit' ? 'bg-red-50 text-red-600' : ($l->tipe === 'cuti' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600') }}">
                            {{ $l->tipe }}
                        </span>
                        
                        <!-- Status Badge -->
                        <span class="flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-lg border
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
                    </div>

                    <div class="space-y-3 pl-2">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold">Tanggal</p>
                            <div class="font-bold text-gray-800 flex items-center gap-2 mt-0.5">
                                <span>{{ $l->tanggal_mulai?->format('d M') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" class="text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                <span>{{ $l->tanggal_selesai?->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold">Alasan</p>
                            <p class="text-sm text-gray-600 line-clamp-2 mt-0.5 leading-relaxed">
                                {{ $l->alasan ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    @if($l->status === 'pending' || $l->status === 'approved')
                        <div class="mt-6 pt-4 border-t border-gray-50 flex justify-end pl-2">
                            @if($l->status === 'pending')
                                <form action="{{ route('karyawan.leave.destroy', $l) }}" method="POST" onsubmit="return confirm('Yakin hapus pengajuan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        Batalkan Pengajuan
                                    </button>
                                </form>
                            @elseif($l->status === 'approved')
                                <form action="{{ route('karyawan.leave.cancel', $l) }}" method="POST" onsubmit="return confirm('Ajukan pembatalan untuk cuti ini?');">
                                    @csrf
                                    <button type="submit" class="text-sm text-orange-500 hover:text-orange-700 font-medium flex items-center gap-1 hover:bg-orange-50 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18.37 2.63 2.63 18.37"/><path d="M2.63 2.63 18.37 18.37"/></svg>
                                        Batalkan Cuti
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
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
