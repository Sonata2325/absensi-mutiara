@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<style>
    .cropper-container {
        width: 100%;
        max-height: 400px;
    }
</style>

<div class="max-w-4xl mx-auto space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Form -->
        <div class="lg:col-span-2">
            <form id="profileForm" method="POST" action="{{ route('karyawan.profile.update') }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 relative overflow-hidden">
                @csrf
                
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-bold text-gray-800">Informasi Pribadi</h2>
                    <div class="h-8 w-8 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                </div>

                <!-- Avatar Upload -->
                <div class="flex items-center gap-6 mb-8">
                    <div class="relative group">
                        <div id="preview-container" class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-gray-100 shadow-sm group-hover:border-[#D61600] transition-colors relative">
                            @if($user->foto_profile)
                                <img id="avatar-preview" src="{{ asset('storage/' . $user->foto_profile) }}?v={{ time() }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <div id="avatar-placeholder" class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                <img id="avatar-preview" src="" alt="Profile" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        
                        <label class="absolute -bottom-2 -right-2 bg-white text-gray-600 p-2 rounded-full shadow-md border border-gray-100 cursor-pointer hover:text-[#D61600] transition-colors z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <input type="file" id="foto_input" name="foto_profile" accept="image/*" class="hidden">
                            <!-- Hidden input for cropped result -->
                            <input type="hidden" name="cropped_image" id="cropped_image">
                        </label>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->phone }}</p>
                        <p class="text-xs text-gray-400 mt-1">Klik ikon upload untuk ganti foto</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Nama Lengkap</label>
                            <input name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                            @error('name')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Nomor Telepon</label>
                            <input name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                            @error('phone')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600] resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Kontak Darurat</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <input name="kontak_darurat" value="{{ old('kontak_darurat', $user->kontak_darurat) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 pl-10 transition-colors hover:bg-gray-100 hover:border-[#D61600]" placeholder="Nama - Nomor Telepon">
                        </div>
                        @error('kontak_darurat')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-[#D61600] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-red-200 hover:bg-[#b01200] hover:shadow-xl transition-all active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Password Form -->
        <div class="lg:col-span-1">
            <form method="POST" action="{{ route('karyawan.profile.password') }}" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 h-full">
                @csrf
                
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-bold text-gray-800">Keamanan</h2>
                    <div class="h-8 w-8 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Password Saat Ini</label>
                        <input name="current_password" type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                        @error('current_password')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Password Baru</label>
                        <input name="new_password" type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                        @error('new_password')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Konfirmasi Password</label>
                        <input name="new_password_confirmation" type="password" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                    </div>

                    <div class="pt-4">
                        <button class="w-full bg-[#D61600] text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-red-200 hover:bg-[#b01200] hover:shadow-xl transition-all active:scale-95">
                            Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Crop Image -->
<div id="cropModal" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/75 transition-opacity backdrop-blur-sm"></div>
    
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg mx-4">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="flex flex-col items-center">
                        <h3 class="text-xl font-bold leading-6 text-gray-900 mb-4 w-full text-center" id="modal-title">Sesuaikan Foto</h3>
                        <div class="relative w-full h-[400px] bg-black rounded-xl overflow-hidden shadow-inner">
                            <img id="image-to-crop" src="" alt="Picture" class="block max-w-full">
                        </div>
                        <p class="mt-4 text-sm text-gray-500 text-center">Geser dan zoom untuk menyesuaikan posisi foto</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                    <button type="button" id="cropButton" class="inline-flex w-full justify-center rounded-xl bg-[#D61600] px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-red-200 hover:bg-[#b01200] transition-all sm:w-auto">
                        Terapkan
                    </button>
                    <button type="button" id="cancelButton" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all sm:mt-0 sm:w-auto">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fotoInput = document.getElementById('foto_input');
        const cropModal = document.getElementById('cropModal');
        const imageToCrop = document.getElementById('image-to-crop');
        const cropButton = document.getElementById('cropButton');
        const cancelButton = document.getElementById('cancelButton');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarPlaceholder = document.getElementById('avatar-placeholder');
        const croppedImageInput = document.getElementById('cropped_image');
        
        let cropper;

        fotoInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                
                if (!file.type.match('image.*')) {
                    alert('Mohon pilih file gambar (JPG, PNG, dll)');
                    return;
                }

                // Reset inputs
                croppedImageInput.value = '';

                const reader = new FileReader();
                reader.onload = function(event) {
                    imageToCrop.src = event.target.result;
                    cropModal.classList.remove('hidden');
                    
                    if (cropper) {
                        cropper.destroy();
                    }
                    
                    // Init cropper
                    setTimeout(() => {
                        cropper = new Cropper(imageToCrop, {
                            aspectRatio: 1,
                            viewMode: 1,
                            dragMode: 'move',
                            autoCropArea: 1,
                            restore: false,
                            guides: true,
                            center: true,
                            highlight: false,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            toggleDragModeOnDblclick: false,
                            minContainerHeight: 400,
                            minContainerWidth: 300,
                            background: false,
                        });
                    }, 200);
                };
                reader.readAsDataURL(file);
            }
        });

        cropButton.addEventListener('click', function() {
            if (cropper) {
                // Show loading state
                const originalText = cropButton.innerText;
                cropButton.innerText = 'Memproses...';
                cropButton.disabled = true;

                const canvas = cropper.getCroppedCanvas({
                    width: 600,
                    height: 600,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                const base64Image = canvas.toDataURL('image/jpeg', 0.9);

                // Update preview
                avatarPreview.src = base64Image;
                avatarPreview.classList.remove('hidden');
                if (avatarPlaceholder) avatarPlaceholder.classList.add('hidden');

                // Set hidden input
                croppedImageInput.value = base64Image;
                
                // Clear file input to avoid double submission or validation issues
                // But keep it cleared so if user cancels main form, they have to re-select
                fotoInput.value = ''; 

                // Close modal
                cropModal.classList.add('hidden');
                cropper.destroy();
                cropper = null;

                // Reset button
                cropButton.innerText = originalText;
                cropButton.disabled = false;
            }
        });

        cancelButton.addEventListener('click', function() {
            cropModal.classList.add('hidden');
            fotoInput.value = ''; // Reset file input so change event fires again
            croppedImageInput.value = ''; // Clear any partial data
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });
    });
</script>
@endsection
