<?php

use App\Http\Controllers\AdventureController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\LocationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(AdventureController::class)->group(function () {
        Route::get('/abenteuer', 'index')->name('adventures.index');
        Route::get('/abenteuer/{adventure}', 'show')->name('adventures.show');
        Route::post('/abenteuer', 'store')->name('adventures.store');
        Route::put('/abenteuer/{adventure}/bearbeiten', 'update')->name('adventures.update');
        Route::delete('/abenteuer/{adventure}', 'destroy')->name('adventures.destroy');
    });

    Route::controller(ChapterController::class)->group(function () {
        Route::get('abenteuer/{adventure}/kapitel/{chapter}', 'show')->name('adventures.chapters.show');
        Route::post('/abenteuer/{adventure}/kapitel', 'store')->name('adventures.chapters.store');
        Route::put('abenteuer/{adventure}/kapitel/{chapter}/bearbeiten', 'update')->name('adventures.chapters.update');
        Route::delete('abenteuer/{adventure}/kapitel/{chapter}', 'destroy')->name('adventures.chapters.destroy');
    });

    Route::controller(LocationController::class)->group(function () {
//        Route::get('/orte', 'index')->name('locations.index');
//        Route::get('ort/{location}', 'show')->name('locations.show');
        Route::get('abenteuer/{adventure}/ort/{location}', 'showInAdventure')->name('adventures.locations.show');
        Route::post('/ort', 'store')->name('locations.store');
        Route::post('abenteuer/{adventure}/ort', 'storeAndAttachToAdventure')->name('adventures.locations.store');
        Route::put('/ort/{location}/bearbeiten', 'update')->name('locations.update');
        Route::put('abenteuer/{adventure}/ort/{location}/bearbeiten', 'updateInAdventure')->name('adventures.locations.update');
        Route::put('abenteuer/{adventure}/ort/{location}', 'detachFromAdventure')->name('adventures.locations.detach');
        Route::delete('/ort/{location}', 'destroy')->name('locations.destroy');
        Route::delete('abenteuer/{adventure}/ort/{location}', 'destroy')->name('adventures.locations.destroy');
    });
});

