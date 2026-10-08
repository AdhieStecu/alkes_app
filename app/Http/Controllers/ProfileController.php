<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Update user profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
        ]);

        $user->name = $request->name;
        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user->fresh(),
        ]);
    }

    /**
     * Upload and update user profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ], [
            'photo.required' => 'Pilih file gambar untuk foto profil.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, webp.',
            'photo.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $user = Auth::user();

        // Delete previous profile photo if stored
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Store new photo in public disk
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diunggah!',
            'user' => $user->fresh(),
            'photo_url' => $user->fresh()->profile_photo_url,
        ]);
    }

    /**
     * Delete user profile photo.
     */
    public function deletePhoto(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->profile_photo_path = null;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil dihapus.',
            'user' => $user->fresh(),
            'photo_url' => $user->fresh()->profile_photo_url,
        ]);
    }
}
