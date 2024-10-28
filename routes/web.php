<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Admin;

Route::get('/', function () {
    return view('home/index');
})->name('index');

Route::get('/profile-complete', function () {
    return view('profile-complete');
})->middleware(['auth', 'verified']);

### LOGIN/REGISTOS
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';

Route::get('/admin/index', [HomeController::class, 'index'])->name('admin.index');

#google

Route::get('auth/google', [GoogleAuthController::class,'redirect'])->name('google-auth');

Route::get('auth/google/call-back',[GoogleAuthController::class, 'callbackGoogle']);

######## UTILIZADOR SEM ESTAR LOGADO

Route::get('/spinwheel', function () {
    return view('home.spinwheel');
})->name('spinwheel');

Route::get('/field', function () {
    return view('home.field');
})->name('field');

Route::get('/contact', function () {
    return view('home.contact');
})->name('contact');

Route::get('/newmatch',[HomeController::class, 'newmatch'])->name('new.match');
Route::get('/seematch',[HomeController::class, 'seematch'])->name('see.match');



#ADMIN

Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user-management');
Route::get('/users/{id}', [AdminController::class, 'show'])->name('users.show');    
Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');  
Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy'); 
