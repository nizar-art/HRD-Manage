<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AccountSettingsAccount extends Controller
{
    public function index()
    {
        return view('content.pages.pages-account-settings-account');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'sometimes|string|max:15',
            'address' => 'sometimes|string|max:255',
            'province' => 'sometimes|string|max:255',
            'country' => 'sometimes|string|max:255',
            'zip_code' => 'sometimes|string|max:10',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $changedFields = []; // Untuk mencatat field yang berubah

            // Handle avatar upload if provided
            if ($request->hasFile('avatar')) {
                $this->handleAvatarUpload($request, $user);
                $changedFields[] = 'avatar'; // Catat perubahan avatar
            }

            // Update user data and detect changes
            $user->fill($request->except(['avatar', '_token']));
            $changes = $user->getDirty(); // Get only the changed fields
            unset($changes['updated_at']); // Abaikan updated_at otomatis

            if (!empty($changes)) {
                $changedFields = array_merge($changedFields, array_keys($changes));
                $user->save(); // Simpan semua perubahan, termasuk avatar

                // Log user activity for profile update
                UserActivity::create([
                    'user_id' => $user->id,
                    'activity' => 'Updated profile information',
                    'type' => 'update',
                    'description' => 'Updated profile fields: ' . implode(', ', array_unique($changedFields)),
                    'activity_date' => now(),
                ]);
            }

            return redirect()->route('pages-profile-user')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Profile Update Error: ' . $e->getMessage());
            return redirect()->route('pages-account-settings-account')->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function deactivate(Request $request)
    {
        $user = Auth::user();
        $user->update(['is_active' => false]);

        // Log user activity for account deactivation
        UserActivity::create([
            'user_id' => $user->id,
            'activity' => 'Deactivated their account',
            'type' => 'deactivate',
            'description' => 'User has deactivated their account.',
            'activity_date' => now(),
        ]);

        Auth::logout();
        return redirect()->route('login')->with('success', 'Your account has been deactivated.');
    }

    private function handleAvatarUpload(Request $request, $user)
    {
        $avatarPath = 'assets/img/avatars/';
        $defaultAvatar = $avatarPath . '1.png'; // Gambar default

        // Pastikan direktori avatar ada
        if (!File::exists(public_path($avatarPath))) {
            File::makeDirectory(public_path($avatarPath), 0755, true);
        }

        // Hapus avatar lama jika bukan avatar default
        if ($user->avatar && $user->avatar !== $defaultAvatar && File::exists(public_path($user->avatar))) {
            File::delete(public_path($user->avatar));
        }

        // Generate nama unik untuk avatar baru
        $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
        $request->file('avatar')->move(public_path($avatarPath), $fileName);

        // Set nilai avatar, tapi jangan langsung simpan di sini
        $user->avatar = $avatarPath . $fileName;
    }
}
