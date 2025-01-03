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

#PERFIL
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
require __DIR__ . '/auth.php';

#GOOGLE
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

#UTILIZADOR SEM ESTAR LOGADO
Route::get('/spinwheel', [HomeController::class, 'spinwheel'])->name('spinwheel');
Route::get('/events', [HomeController::class, 'events'])->name('events');
Route::get('/field', [HomeController::class, 'field'])->name('field');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/events', [HomeController::class, 'showEvents'])->name('events');
Route::get('/help', [HomeController::class, 'help'])->name('help');

#UTILIZADOR LOGADO APRAEECE PARA DAR LOGIN
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/newmatch', [HomeController::class, 'newmatch'])->name('new.match');
    Route::get('/newmatch/{id}', [HomeController::class, 'newMatchField'])->name('newmatch.field');
    Route::post('/store-event', [HomeController::class, 'storeEvent'])->name('store.event');
    Route::get('/seematch', [HomeController::class, 'seeMatch'])->name('seematch');
    Route::delete('/events/{id}', [HomeController::class, 'destroyEvent'])->name('events.destroy');


    Route::get('/print_pdf/{id}', [HomeController::class, 'print_pdf'])->name('print_pdf');

    Route::post('/sendproblem', [HomeController::class, 'sendProblem'])->name('send.problem');
    Route::get('participate-in-event/{id}', [HomeController::class, 'participateInEvent'])->name('participateInEvent');
    Route::get('/event/cancel/{id}', [HomeController::class, 'cancelParticipation'])->name('cancelParticipation');
    Route::get('/showEvents', action: [HomeController::class, 'showEvents'])->name('showEvents');

    Route::get('/manage-fields', [HomeController::class, 'manageFields'])->name('manage-fields');
    Route::get('/create-field', [HomeController::class, 'createField'])->name('create-field');
    Route::post('/store-fields', [HomeController::class, 'storeFields'])->name('store-fields');

    Route::get('edit-fields/{id}', [HomeController::class, 'editField'])->name('edit-field');
    Route::delete('/field/{id}', [HomeController::class, 'destroyField'])->name('delete-field');
    Route::get('/field/{id}', [HomeController::class, 'showField'])->name('show-field');
    Route::put('/field/{id}', [HomeController::class, 'updateField'])->name('update-field');
});

#ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/chart-data', [AdminController::class, 'getChartData'])->name('admin.chart-data');
    Route::get('/admin/available-years', [AdminController::class, 'availableYears']);
    Route::get('/admin/event-status-data', [AdminController::class, 'getEventStatusData']);


    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user-management');
    Route::get('/users/{id}', [AdminController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/user-management/search', [AdminController::class, 'user_search'])->name('admin.user-search');
    Route::put('/users/{user}/updateProfilePicture', [AdminController::class, 'updateProfilePicture'])->name('users.updateProfilePicture');
    Route::delete('/users/{user}/ProfilePictureDelete', [AdminController::class, 'ProfilePictureDelete'])->name('users.ProfilePictureDelete');



    Route::get('/support', [AdminController::class, 'support'])->name('admin.support');
    Route::post('/store-problem', [AdminController::class, 'storeProblem'])->name('storeProblem');
    Route::get('/problems_history', [AdminController::class, 'problems_history'])->name('admin.problems_history');
    Route::post('/problems/{id}/mark-as-solved', [AdminController::class, 'markAsSolved'])->name('markAsSolved');


    Route::get('/fields-admin', [AdminController::class, 'fieldsAdmin'])->name('admin.fields');
    Route::get('/fields/{field}/edit', [AdminController::class, 'editFields'])->name('admin.fields-edit');
    Route::get('/admin/fields/search', [AdminController::class, 'searchFields'])->name('admin.fields.search');
    Route::put('/fields/{id}', [AdminController::class, 'updateFields'])->name('fields.update');
    Route::delete('/fields/{id}', [AdminController::class, 'destroyFields'])->name('fields.destroy');
});
