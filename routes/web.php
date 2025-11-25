<?php

use App\Http\Controllers\Admin\CarritoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FundacionController;
use App\Http\Controllers\Admin\OrdenController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard.demo');

// Authentication Routes
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('admin')
    ->middleware(['web', 'auth', 'can:access-admin'])
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('fundaciones', FundacionController::class)
            ->parameters(['fundaciones' => 'fundacion'])
            ->except('show');
        Route::resource('proveedores', ProveedorController::class)
            ->parameters(['proveedores' => 'proveedor'])
            ->except('show');
        Route::resource('productos', ProductoController::class)
            ->parameters(['productos' => 'producto'])
            ->except('show');
        Route::resource('categories', CategoryController::class)
            ->parameters(['categories' => 'category'])
            ->except('show');
        Route::resource('usuarios', UsuarioController::class)
            ->parameters(['usuarios' => 'usuario']);
        Route::resource('carritos', CarritoController::class)
            ->parameters(['carritos' => 'carrito'])
            ->except(['create', 'store']);
        Route::resource('ordenes', OrdenController::class)
            ->parameters(['ordenes' => 'orden'])
            ->except(['create', 'store']);
        Route::resource('payments', PaymentController::class)
            ->parameters(['payments' => 'payment']);
    });

