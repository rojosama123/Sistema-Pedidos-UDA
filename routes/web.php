<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\MenuController;

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

Route::get('/pedidos/casino/{nombre}', [MenuController::class, 'mostrarMenu'])->name('pedidos.casino');

Route::get('/historial', [PedidoController::class, 'historial'])->name('pedidos.historial');

Route::get('/menu', [MenuItemController::class, 'index'])->name('menu.index');
Route::get('/menu/create_menu', [MenuItemController::class, 'create'])->name('menu.create_menu');
Route::post('/menu/store', [MenuItemController::class, 'store'])->name('menu.store');
Route::get('/menu/{fecha}/edit', [MenuItemController::class, 'edit'])->name('menu.edit');
Route::put('/menu/{fecha}', [MenuItemController::class, 'update'])->name('menu.update');
Route::delete('/menu/{fecha}', [MenuItemController::class, 'destroy'])->name('menu.destroy');

Route::put('/pedidos/{pedido}/cambiar-estado', [PedidoController::class, 'cambiarEstado'])->name('pedidos.cambiarEstado');

Route::middleware(['auth'])->group(function () {
    Route::post('/pedido/guardar', [PedidoController::class, 'guardar'])->name('pedido.guardar');
});

Route::get('/reseñas', [\App\Http\Controllers\ReviewController::class, 'index'])->name('reseñas.index');
