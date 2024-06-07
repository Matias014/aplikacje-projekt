<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\UserController;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [TournamentController::class, 'statistics'])->name('index');

Route::controller(TournamentController::class)->group(function () {
    Route::get('/tournaments/create', 'create')->name('tournaments.create');
    Route::get('/tournaments', 'index')->name('tournaments.index');
    Route::get('/tournaments/{tournament}', 'show')->name('tournaments.show');
    Route::post('/tournaments', 'store')->name('tournaments.store');
    Route::get('/tournaments/{tournament}/edit', 'edit')->name('tournaments.edit');
    Route::put('/tournaments/{tournament}/update', 'update')->name('tournaments.update');
    Route::delete('/tournaments/{tournament}/destroy', 'destroy')->name('tournaments.destroy');
});

Route::controller(ParticipantController::class)->group(function () {
    Route::post('/tournaments/{tournament}/participants', 'store')->name('participants.store');
    Route::delete('/tournaments/{tournament}/participants/{participant}', 'destroy')->name('participants.destroy');
});

Route::controller(AnswerController::class)->group(function () {
    Route::post('/tournaments/{tournament}/answers', 'store')->name('answers.store');
    Route::put('/answers/{answer}', 'update')->name('answers.update');
    Route::delete('/answers/{answer}', 'destroy')->name('answers.destroy');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('/users', UserController::class);
});
