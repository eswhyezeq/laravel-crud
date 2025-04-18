<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Ensure $user is valid before performing actions
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to update your profile.');
        }

        $request->validate([
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_no' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
        ]);

        $user->nickname = $request->nickname;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->city = $request->city;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Optional: delete old avatar
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save(); 

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Ensure user is valid before performing actions
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to delete your account.');
        }

        Auth::logout();

        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        $user->delete(); //

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}