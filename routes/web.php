<?php

use App\Http\Controllers\AdventureController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\EnemyController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NonPlayerCharacterController;
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
//        Route::post('/ort', 'store')->name('locations.store');
        Route::post('abenteuer/{adventure}/ort', 'storeAndAttachToAdventure')->name('adventures.locations.store');
//        Route::put('/ort/{location}/bearbeiten', 'update')->name('locations.update');
        Route::put('abenteuer/{adventure}/ort/{location}/bearbeiten', 'updateInAdventure')->name('adventures.locations.update');
        Route::put('abenteuer/{adventure}/ort/{location}', 'detachFromAdventure')->name('adventures.locations.detach');
        Route::delete('/ort/{location}', 'destroy')->name('locations.destroy');
        Route::delete('abenteuer/{adventure}/ort/{location}', 'destroy')->name('adventures.locations.destroy');
    });

    Route::controller(NonPlayerCharacterController::class)->group(function () {
//        Route::get('/nscs', 'index')->name('nonplayercharacters.index');
//        Route::get('nsc/{nonPlayerCharacter}', 'show')->name('nonplayercharacters.show');
        Route::get('abenteuer/{adventure}/nsc/{nonPlayerCharacter}', 'showInAdventure')->name('adventures.nonplayercharacters.show');
//        Route::post('/nsc', 'store')->name('nonPlayerCharacter.store');
        Route::post('abenteuer/{adventure}/nsc', 'storeAndAttachToAdventure')->name('adventures.nonplayercharacters.store');
//        Route::put('/nsc/{nonPlayerCharacter}/bearbeiten', 'update')->name('nonplayercharacters.update');
        Route::put('abenteuer/{adventure}/nsc/{nonPlayerCharacter}/bearbeiten', 'updateInAdventure')->name('adventures.nonplayercharacters.update');
        Route::put('abenteuer/{adventure}/nsc/{nonPlayerCharacter}', 'detachFromAdventure')->name('adventures.nonplayercharacters.detach');
        Route::delete('/nsc/{nonPlayerCharacter}', 'destroy')->name('nonplayercharacters.destroy');
        Route::delete('abenteuer/{adventure}/nsc/{nonPlayerCharacter}', 'destroy')->name('adventures.nonplayercharacters.destroy');
    });

    Route::controller(EnemyController::class)->group(function () {
//        Route::get('/gegner', 'index')->name('enemies.index');
//        Route::get('gegner/{enemy}', 'show')->name('enemies.show');
        Route::get('abenteuer/{adventure}/gegner/{enemy}', 'showInAdventure')->name('adventures.enemies.show');
//        Route::post('/gegner', 'store')->name('enemies.store');
        Route::post('abenteuer/{adventure}/gegner', 'storeAndAttachToAdventure')->name('adventures.enemies.store');
//        Route::put('/gegner/{enemy}/bearbeiten', 'update')->name('enemies.update');
        Route::put('abenteuer/{adventure}/gegner/{enemy}/bearbeiten', 'updateInAdventure')->name('adventures.enemies.update');
        Route::put('abenteuer/{adventure}/gegner/{enemy}', 'detachFromAdventure')->name('adventures.enemies.detach');
        Route::delete('/gegner/{enemy}', 'destroy')->name('enemies.destroy');
        Route::delete('abenteuer/{adventure}/gegner/{enemy}', 'destroy')->name('adventures.enemies.destroy');
    });
});

