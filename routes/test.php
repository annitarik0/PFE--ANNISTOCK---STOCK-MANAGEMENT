<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Models\User;

Route::get('/test-password-reset', function () {
    $user = User::where('email', 'admin@gmail.com')->first();
    
    if (!$user) {
        return 'User not found';
    }
    
    $token = Password::createToken($user);
    
    $user->sendPasswordResetNotification($token);
    
    return 'Password reset email sent to ' . $user->email;
});
