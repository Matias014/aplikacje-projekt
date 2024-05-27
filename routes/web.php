<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('index');
})->name('index');

Route::controller(TournamentController::class)->group(function () {
    Route::get('/tournaments', 'index')->name('tournaments.index');
    Route::get('/tournaments/{id}', 'show')->name('tournaments.show');
    Route::get('/tournaments/{id}/edit', 'edit')->name('tournaments.edit');
    Route::post('/tournaments/{tournament}/participants', [TournamentController::class, 'storeParticipant'])->name('tournaments.participants.store');
    Route::delete('/tournaments/{tournament}/participants', [TournamentController::class, 'destroyParticipant'])->name('tournaments.participants.destroy');
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

// Route::resource('tournaments', TournamentController::class)->middleware('auth');
// Route::resource('users', UserController::class)->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('/admin/users', UserController::class, ['as' => 'admin']);
    Route::resource('/admin/tournaments', TournamentController::class, ['as' => 'admin']);
});
