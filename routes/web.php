<?php

use App\Http\Controllers\Admin\CarritoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FundacionController;
use App\Http\Controllers\Admin\OrdenController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FoundationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SupplierController;
use App\Http\Controllers\Fundacion\DashboardController as FundacionDashboardController;
use App\Http\Controllers\Proveedor\DashboardController as ProveedorDashboardController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{producto}', [ProductController::class, 'show'])->name('products.show');
Route::get('/fundaciones', [FoundationController::class, 'index'])->name('foundations.index');
Route::get('/fundaciones/{fundacion}', [FoundationController::class, 'show'])->name('foundations.show');
Route::get('/proveedores', [SupplierController::class, 'index'])->name('suppliers.index');
Route::get('/proveedores/{proveedor}', [SupplierController::class, 'show'])->name('suppliers.show');

// Cart Routes
Route::middleware('auth')->group(function (): void {
    Route::post('/cart/add/{producto}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
});

// Checkout Routes
Route::middleware('auth')->group(function (): void {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{orden}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Profile Routes
Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [App\Http\Controllers\Frontend\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\Frontend\ProfileController::class, 'update'])->name('profile.update');

    // Buyer Dashboard
    Route::get('/dashboard/buyer', [App\Http\Controllers\Frontend\BuyerDashboardController::class, 'index'])
        ->name('buyer.dashboard');
        
    // Foundation Voting
    Route::post('/foundations/{fundacion}/vote', [App\Http\Controllers\Frontend\FoundationVoteController::class, 'toggle'])
        ->name('foundations.vote');
});

// Orders Routes
Route::middleware('auth')->group(function (): void {
    Route::get('/orders', [App\Http\Controllers\Frontend\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orden}', [App\Http\Controllers\Frontend\OrderController::class, 'show'])->name('orders.show');
});

// Event Routes
Route::middleware('auth')->group(function (): void {
    Route::get('/events', [App\Http\Controllers\Frontend\EventController::class, 'index'])->name('events.index');
    Route::get('/events/{evento}', [App\Http\Controllers\Frontend\EventController::class, 'show'])->name('events.show');
    Route::post('/events/{evento}/register', [App\Http\Controllers\Frontend\EventController::class, 'register'])->name('events.register');
    Route::delete('/events/{evento}/cancel', [App\Http\Controllers\Frontend\EventController::class, 'cancel'])->name('events.cancel');
});

// Report Routes
Route::get('/reportes', [App\Http\Controllers\Frontend\ReportController::class, 'index'])->name('reportes.index');

// Fundación Dashboard Routes
Route::middleware(['auth', 'can:access-fundacion'])->prefix('fundacion')->name('fundacion.')->group(function (): void {
    Route::get('/dashboard', [FundacionDashboardController::class, 'index'])->name('dashboard');
    Route::resource('proveedores', App\Http\Controllers\Fundacion\ProveedorController::class)
        ->parameters(['proveedores' => 'proveedor']);
});

// Proveedor Dashboard Routes
Route::middleware(['auth', 'can:access-proveedor'])->prefix('proveedor')->name('proveedor.')->group(function (): void {
    Route::get('/dashboard', [ProveedorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('productos', App\Http\Controllers\Proveedor\ProductoController::class)
        ->parameters(['productos' => 'producto']);
});

// Authentication Routes
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
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
        Route::post('usuarios/{usuario}/approve', [UsuarioController::class, 'approve'])->name('usuarios.approve');
        Route::post('usuarios/{usuario}/reject', [UsuarioController::class, 'reject'])->name('usuarios.reject');
        Route::resource('carritos', CarritoController::class)
            ->parameters(['carritos' => 'carrito'])
            ->except(['create', 'store']);
        Route::resource('ordenes', OrdenController::class)
            ->parameters(['ordenes' => 'orden'])
            ->except(['create', 'store']);
        Route::resource('payments', PaymentController::class)
            ->parameters(['payments' => 'payment']);
        Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::post('reportes/exportar/excel', [ReporteController::class, 'exportarExcel'])->name('reportes.exportar.excel');
        Route::post('reportes/exportar/pdf', [ReporteController::class, 'exportarPdf'])->name('reportes.exportar.pdf');
    });

