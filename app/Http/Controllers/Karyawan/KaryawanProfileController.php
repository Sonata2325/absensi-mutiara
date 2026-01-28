<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;

class KaryawanProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('karyawan.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50', Rule::unique('users', 'phone')->ignore($user->id)],
            'alamat' => ['nullable', 'string'],
            'kontak_darurat' => ['nullable', 'string', 'max:255'],
            'foto_profile' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        if ($request->hasFile('foto_profile')) {
            $oldPath = $user->foto_profile;
            $data['foto_profile'] = $this->storeCompressedImage($request->file('foto_profile'), 'profile', 85, 800);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        } else {
            unset($data['foto_profile']);
        }

        $user->update($data);

        return back()->with('status', 'Profile berhasil diupdate.');
    }

    private function storeCompressedImage($file, string $folder, int $quality, int $maxWidth): ?string
    {
        if (! function_exists('imagecreatefromjpeg')) {
            return $file->store($folder, 'public');
        }

        $mime = (string) $file->getMimeType();
        if (! in_array($mime, ['image/jpeg', 'image/png'], true)) {
            return $file->store($folder, 'public');
        }

        $sourcePath = $file->getRealPath();
        if (! $sourcePath) {
            return $file->store($folder, 'public');
        }

        $image = $mime === 'image/png'
            ? @imagecreatefrompng($sourcePath)
            : @imagecreatefromjpeg($sourcePath);

        if (! $image) {
            return $file->store($folder, 'public');
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $newWidth = $width;
        $newHeight = $height;

        if ($width > $maxWidth) {
            $ratio = $maxWidth / $width;
            $newWidth = $maxWidth;
            $newHeight = (int) round($height * $ratio);
        }

        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $dir = $folder.'/'.now()->format('Y/m');
        Storage::disk('public')->makeDirectory($dir);
        $filename = now()->format('YmdHis').'-'.bin2hex(random_bytes(6)).'.jpg';
        $path = $dir.'/'.$filename;
        $fullPath = Storage::disk('public')->path($path);

        imagejpeg($canvas, $fullPath, $quality);
        imagedestroy($canvas);
        imagedestroy($image);

        return $path;
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (! Hash::check($data['current_password'], $user->getAuthPassword())) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => $data['new_password']]);

        return back()->with('status', 'Password berhasil diubah.');
    }
}
