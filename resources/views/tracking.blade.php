@extends('layouts.app')

@section('content')
<section class="py-20 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Lacak Paket</h1>
                <p class="text-gray-600 mt-2">Pantau status pengiriman barang Anda secara real-time</p>
            </div>

            <div class="bg-white rounded-xl shadow-xl p-8 mb-8">
                <form action="{{ route('tracking') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" 
                           name="resi" 
                           value="{{ request('resi') }}"
                           placeholder="Masukkan Nomor Resi (Contoh: MJE12345678)" 
                           class="flex-grow px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           required>
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold px-8 py-3 rounded-lg transition">
                        Lacak Paket
                    </button>
                </form>
            </div>

            @if(request('resi'))
                <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 animate-fade-in-up">
                    <div class="flex items-center gap-4 mb-6 border-b pb-4">
                        <div class="bg-blue-100 p-3 rounded-full text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Nomor Resi</div>
                            <div class="text-2xl font-bold text-gray-900">{{ request('resi') }}</div>
                        </div>
                    </div>

                    <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                        <!-- Mockup Status Timeline -->
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-emerald-500 text-slate-500 group-[.is-active]:text-emerald-50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="12" height="10">
                                    <path fill-rule="nonzero" d="M10.422 1.257 4.655 7.025 2.553 4.923A.916.916 0 0 0 1.257 6.22l2.75 2.75a.916.916 0 0 0 1.296 0l6.415-6.416a.916.916 0 0 0-1.296-1.296Z" />
                                </svg>
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-4 rounded border border-slate-200 shadow">
                                <div class="flex items-center justify-between space-x-2 mb-1">
                                    <div class="font-bold text-slate-900">Pesanan Dibuat</div>
                                    <time class="font-caveat font-medium text-indigo-500">Baru saja</time>
                                </div>
                                <div class="text-slate-500">Data pesanan telah diterima di sistem kami.</div>
                            </div>
                        </div>
                        
                        <!-- Note: This is a static mockup. In a real app, you'd loop through actual tracking history. -->
                        <div class="text-center text-sm text-gray-500 mt-4">
                            Status tracking real-time akan tersedia saat sistem terintegrasi penuh.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
