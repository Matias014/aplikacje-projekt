<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('index');
})->name('index');

Route::controller(TournamentController::class)->group(function () {
    Route::get('/tournaments', 'index')->name('tournaments.index');
    Route::get('/tournaments/create', 'create')->name('tournaments.create');
    Route::get('/tournaments/{id}', 'show')->name('tournaments.show');
    Route::get('/tournaments/{id}/edit', 'edit')->name('tournaments.edit');
    Route::put('/tournaments/{id}', 'update')->name('tournaments.update');
    Route::delete('/tournaments/{id}', 'destroy')->name('tournaments.destroy');
    Route::post('/tournaments/{tournament}/participants', [TournamentController::class, 'storeParticipant'])->name('tournaments.participants.store');
});

// Route::resource('countries', TournamentController::class);
// Route::resource('countries', CountryController::class);

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

// Route::get('/auth/register', 'register')->name('register');
