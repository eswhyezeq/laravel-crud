<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'salt',
    ];

    // Automatically generate salt and hash password with salt
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->salt = Str::random(16); // random alphanumeric salt
            $user->password = Hash::make($user->password . $user->salt);
        });

        static::updating(function ($user) {
            // Optional: Only change password if it was modified
            if ($user->isDirty('password')) {
                $user->salt = Str::random(16);
                $user->password = Hash::make($user->password . $user->salt);
            }
        });
    }
}
