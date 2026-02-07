<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
// Controllers Espaces dédiés
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\OrderController as CustomerOrder;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\CategoryController;

/* --- BOUTIQUE PUBLIQUE --- */
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/produit/{product:slug}', [ShopController::class, 'show'])->name('products.show');
Route::get('/panier', function () { return Inertia::render('Cart'); })->name('cart.index');

/* --- AUTHENTIFICATION --- */
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

/* --- WEBHOOK STRIPE (Sécurisé hors CSRF) --- */
Route::post('/stripe/webhook', [WebhookController::class, 'handle'])->name('stripe.webhook');

/* --- ESPACE CONNECTÉ (CLIENT & ADMIN) --- */
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Tunnel d'achat
    Route::post('/checkout', [PaymentController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [PaymentController::class, 'success'])->name('checkout.success');

    /* --- MON COMPTE CLIENT --- */
    Route::prefix('mon-compte')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
        Route::get('/commandes', [CustomerOrder::class, 'index'])->name('orders.index');
        Route::get('/commandes/{order}', [CustomerOrder::class, 'show'])->name('orders.show');
        Route::get('/facture/{order}', [CustomerOrder::class, 'download'])->name('orders.download');
    });

    /* --- ADMINISTRATION --- */
    Route::prefix('admin')->name('admin.')->group(function () {
        // Stats et Analyses
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/analyses', [AdminDashboard::class, 'financials'])->name('financials');

        // Catalogue & Catégories
        Route::post('/categories-quick', [CategoryController::class, 'storeQuick'])->name('categories.storeQuick');
        Route::resource('products', ProductController::class);

        // Commandes & Logistique
        Route::get('/orders', [AdminOrder::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrder::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.status');

        //Gestion utilisateur 
        Route::resource('users', UserController::class);
    });

    // Redirection automatique après login selon le rôle
    Route::get('/dashboard', function () {
        return auth()->user()->is_admin 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('customer.dashboard');
    })->name('dashboard');
});