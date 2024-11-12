<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
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
    Route::get('/spatie-permission', [TestController::class, 'index'])->name('spatie-permission')->middleware('can:spatie-permission');
    Route::post('/create', [TestController::class, 'create'])->name('create')->middleware('can:create');
    Route::put('/update{role}', [TestController::class, 'update'])->name('update')->middleware('can:update');
    Route::delete('/delete{role}', [TestController::class, 'delete'])->name('delete')->middleware('can:delete');
});

require __DIR__.'/auth.php';
