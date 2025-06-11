<?php

use App\Http\Controllers\Admin\ConsoleController;
use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SectionController;
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

Route::prefix('admin')
    ->name('admin.')
    // ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::resource('games', GameController::class);

        Route::prefix('games/{game}')->group(function () {
            Route::get('sections/create', [SectionController::class, 'create'])->name('sections.create');
            Route::post('sections', [SectionController::class, 'store'])->name('sections.store');

            Route::post('images', [ImageController::class, 'store'])->name('images.store');
        });

        Route::resource('sections', SectionController::class)->except(['index', 'create', 'store']);
        Route::post('/sections/update-order', [SectionController::class, 'updateOrder'])->name('sections.update-order');


        Route::resource('developers', DeveloperController::class);
        Route::resource('consoles', ConsoleController::class);
        Route::resource('genres', GenreController::class);

        Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');
    });


require __DIR__ . '/auth.php';
