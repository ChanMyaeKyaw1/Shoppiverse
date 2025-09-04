<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ProfileController;

require_once __DIR__.'/admin.php';
require_once __DIR__.'/user.php';

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', 'login');

Route::get('/dashboard', function () {
    // return to_route('admin#dashboard');
    // return view('admin#dashboard');
    return view('authentication.login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// for social login
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\SocialLoginController;

Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('socialLogin');

Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('socialCallback');

Route::get('/editProfile', [AdminController::class, 'editProfile'])->name('profile#editProfile');
