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
            'cropped_image' => ['nullable'],
        ]);

        if ($request->filled('cropped_image')) {
            try {
                $oldPath = $user->foto_profile;
                
                // Handle Base64 Image
                if (preg_match('/^data:image\/(\w+);base64,/', $request->input('cropped_image'), $type)) {
                    $imageContent = substr($request->input('cropped_image'), strpos($request->input('cropped_image'), ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif
                    
                    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                        throw new \Exception('invalid image type');
                    }
                    $imageContent = base64_decode($imageContent);
                    
                    if ($imageContent === false) {
                        throw new \Exception('base64_decode failed');
                    }

                    $dir = 'profile/'.now()->format('Y/m');
                    Storage::disk('public')->makeDirectory($dir);
                    $filename = now()->format('YmdHis').'-'.bin2hex(random_bytes(6)).'.'.$type;
                    $path = $dir.'/'.$filename;
                    
                    Storage::disk('public')->put($path, $imageContent);
                    
                    // Verify file exists
                    if (!Storage::disk('public')->exists($path)) {
                        throw new \Exception('Failed to save file to storage');
                    }

                    $updateData['foto_profile'] = $path; // Use separate array for update

                    // Delete old photo
                    if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                } else {
                     throw new \Exception('did not match data URI with image data');
                }
            } catch (\Exception $e) {
                \Log::error('Profile photo upload error: ' . $e->getMessage());
                return back()->withErrors(['foto_profile' => 'Gagal mengupload foto: ' . $e->getMessage()])->withInput();
            }
        } elseif ($request->hasFile('foto_profile')) {
            $oldPath = $user->foto_profile;
            $updateData['foto_profile'] = $this->storeCompressedImage($request->file('foto_profile'), 'profile', 85, 800);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        
        // Merge updateData into data (excluding foto_profile from validated data if handled above)
        if (isset($updateData['foto_profile'])) {
            $data['foto_profile'] = $updateData['foto_profile'];
        } else {
             // If no new photo, remove key so it doesn't nullify existing
             if (!isset($data['foto_profile'])) {
                 unset($data['foto_profile']);
             }
        }
        
        unset($data['cropped_image']); // Remove from update data

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
