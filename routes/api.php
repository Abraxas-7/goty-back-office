<?php

use App\Http\Controllers\Api\ConsoleController;
use App\Http\Controllers\Api\DeveloperController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('games')->group(function () {
    Route::get('/', [GameController::class, 'index']);
    Route::get('/{id}', [GameController::class, 'show']);
    Route::get('/slug/{slug}', [GameController::class, 'showBySlug']);

    Route::get('{game}/images', [GameController::class, 'images']);
    Route::get('{game}/sections', [GameController::class, 'sections']);
});

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/consoles', [ConsoleController::class, 'index']);
Route::get('/developers', [DeveloperController::class, 'index']);
