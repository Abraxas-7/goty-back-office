<?php

use App\Http\Controllers\Admin\ConsoleController;
use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('games', GameController::class);
    // ->middleware('auth', 'verified');
    Route::resource('developers', DeveloperController::class);
    // ->middleware('auth', 'verified');
    Route::resource('consoles', ConsoleController::class);
    // ->middleware('auth', 'verified');
    Route::resource('genres', GenreController::class);
    // ->middleware('auth', 'verified');
});


require __DIR__ . '/auth.php';
