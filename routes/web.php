<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Admin;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/index', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home.index');

### LOGIN/REGISTOS
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
require __DIR__ . '/auth.php';

#google
Route::get('auth/google', [GoogleAuthController::class,'redirect'])->name('google-auth');
Route::get('auth/google/call-back',[GoogleAuthController::class, 'callbackGoogle']);

#UTILIZADOR SEM ESTAR LOGADO
Route::get('/spinwheel', [HomeController::class, 'spinwheel'])->name('spinwheel');
Route::get('/field', [HomeController::class, 'field'])->name('field');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/help', [HomeController::class, 'help'])->name('help');
Route::get('/chat', [HomeController::class, 'chat'])->name('chat')->middleware('auth');


#UTILIZADOR LOGADO APRAEECE PARA DAR LOGIN
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/newmatch', [HomeController::class, 'newmatch'])->name('new.match');
    Route::get('/seematch', [HomeController::class, 'seematch'])->name('see.match');
    Route::post('/sendproblem', [HomeController::class, 'sendProblem'])->name('send.problem');

    Route::get('/manage-fields', [HomeController::class, 'manageFields'])->name('manage-fields');
    Route::get('/create-field', [HomeController::class, 'createField'])->name('create-fields');
    Route::post('/field', [HomeController::class, 'storeFields'])->name('store-fields');
    Route::get('edit-fields/{id}', [HomeController::class, 'editFields'])->name('edit-fields');
    Route::put('/field/{id}', [HomeController::class, 'updateFields'])->name('update-fields');
    Route::get('/field/{id}', [HomeController::class, 'showFields'])->name('show-fields');


    Route::get('/get-messages/{receiverId}', [HomeController::class, 'getMessages']);
    Route::post('/send-message', [HomeController::class, 'sendMessage'])->name('send.message');
    Route::get('/conversations', [HomeController::class, 'conversations'])->name('conversations');

});

#ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user-management');
    Route::get('/users/{id}', [AdminController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/user-management/search', [AdminController::class, 'user_search'])->name('admin.user-search');
    Route::get('/support', [AdminController::class, 'support'])->name('admin.support');
    Route::post('/store-problem', [AdminController::class, 'storeProblem'])->name('storeProblem');
    Route::get('/problems_history', [AdminController::class, 'problems_history'])->name('admin.problems_history');
    Route::post('/problems/{id}/mark-as-solved', [AdminController::class, 'markAsSolved'])->name('markAsSolved');
    Route::get('/maintenance', [AdminController::class, 'maintenance'])->name('admin.maintenance');
});