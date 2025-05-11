<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\Admin\UrlController as AdminUrlController;
use App\Http\Controllers\RedirectController;

Route::get('{short}', [RedirectController::class, 'go'])
     ->name('redirect')
     ->where('short', '[A-Za-z0-9]{6}');

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});
Route::middleware('guest')->group(function () {
    Route::get('login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('login',   [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register',[AuthController::class, 'register']);
});
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('data', UrlController::class);
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('urls', AdminUrlController::class);
});
