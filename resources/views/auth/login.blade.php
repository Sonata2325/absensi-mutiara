@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-cover bg-center relative" 
     style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
    
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>

    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <img src="{{ asset('logo_pt_mutiara.png') }}" alt="Logo" class="mx-auto h-32 w-auto">
            <h2 class="mt-2 text-2xl font-bold text-black">PT Mutiara Jaya Express</h2>
        </div>

        <form class="space-y-6" action="{{ route('login.submit') }}" method="POST">
            @csrf

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">
                    Nomor Telepon
                </label>
                <div class="mt-1">
                    <input id="phone" name="phone" type="text" autocomplete="tel" required 
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#D61600] focus:border-[#D61600] sm:text-sm"
                        value="{{ old('phone') }}">
                </div>
                @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#D61600] focus:border-[#D61600] sm:text-sm">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" value="1" 
                        class="h-4 w-4 text-[#D61600] focus:ring-[#D61600] border-gray-300 rounded accent-[#D61600]">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#D61600] hover:bg-[#b01200] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#D61600] transition-colors">
                    Masuk
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Mutiara HR System
        </div>
    </div>
</div>
@endsection

