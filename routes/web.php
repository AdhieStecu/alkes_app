<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
Route::resource('alat', AlatController::class);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth API endpoints
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated User & Profile endpoints
Route::middleware('auth')->group(function () {
    Route::get('/api/current-user', [AuthController::class, 'user'])->name('user.current');
    Route::post('/api/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/api/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::delete('/api/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

// Single Page Application (SPA) frontend views handled by Vue
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', function () {
    return view('welcome');
})->name('register');

Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/profile', function () {
    return view('welcome');
})->name('profile');

Route::fallback(function () {
    return view('welcome');
});
