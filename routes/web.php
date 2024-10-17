<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home/index');
});

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

######## UTILIZADOR SEM ESTAR LOGADO
Route::get('/', function () {
    return view('home.index');
})->name('index');

Route::get('/match', function () {
    return view('home.match');
})->name('match');

Route::get('/spinwheel', function () {
    return view('home.spinwheel');
})->name('spinwheel');

Route::get('/field', function () {
    return view('home.field');
})->name('field');

Route::get('/profile-complete', [])->name('profile.complete');
