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
    Route::get('/tournament', 'index')->name('tournament.index');
    Route::get('/tournament/{id}', 'show')->name('tournament.show');
    Route::get('/tournament/{id}/edit', 'edit')->name('tournament.edit');
    Route::put('/tournament/{id}', 'update')->name('tournament.update');
    Route::post('/tournament/{tournament}/answers', [AnswerController::class, 'store'])->name('answers.store');
});

// Route::resource('countries', CountryController::class);

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
});

// Route::get('/auth/register', 'register')->name('register');
