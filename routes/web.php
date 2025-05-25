<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Página de login en la raíz
Route::get('/', function () {
    return view('welcome');
})->name('login');


// Dashboard protegido con auth
Route::get('/dashboard', [PedidoController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/seleccion_casino', function () {
    return view('seleccion_casino');
})->middleware('auth')->name('seleccion_casino');

Route::get('/pedidos/casino/{nombre}', [PedidoController::class, 'mostrar'])->name('pedidos.casino');