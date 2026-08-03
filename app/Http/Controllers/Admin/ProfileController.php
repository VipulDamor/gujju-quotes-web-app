<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showChangePassword()
    {
        return view('admin.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'The current password you entered is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Securely update the session to match the new password hash
        $request->session()->put([
            'password_hash_' . Auth::getDefaultDriver() => $user->getAuthPassword(),
        ]);

        return back()->with('success', 'Your password has been updated successfully!');
    }
}
