<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', fn() => view('welcome'));

Route::get('/', [TournamentController::class, 'statistics'])->name('index');

Route::controller(TournamentController::class)->group(function () {
    Route::get('/tournaments', 'index')->name('tournaments.index');
    Route::get('/tournaments/{tournament}', 'show')->name('tournaments.show');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::post('/auth/logout', 'logout')->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(TournamentController::class)->group(function () {
        Route::get('/tournaments/create', 'create')->name('tournaments.create');
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

    Route::controller(ReportController::class)->group(function () {
        Route::get('/account/reports/statistics', 'statisticsPage')->name('account.reports.statistics');

        Route::get('/reports/statistics/pdf', 'statisticsPdf')->name('reports.statistics.pdf');
        Route::post('/reports/statistics/image', 'statisticsImage')->name('reports.statistics.image');
        Route::get('/reports/tournaments/{tournament}/pdf', 'tournamentPdf')->name('reports.tournament.pdf');
    });

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/logs', [ActivityLogController::class, 'index'])->name('admin.logs.index');
    Route::resource('/users', UserController::class);
});
