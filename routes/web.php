<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Página de login en la raíz
Route::get('/', function () {
    return view('welcome');
})->name('login');

// Procesar login
Route::post('/login', [LoginController::class, 'login']);

// Dashboard protegido con auth
Route::get('/dashboard', [PedidoController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Perfil (protegido con auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
