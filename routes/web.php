<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [MainController::class, 'view_dashboard'])->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/products', [MainController::class, 'get_product_page'])->name('products');

Route::post('/products/create', [MainController::class, 'create_new_product'])->name('products.create');

Route::put('/products/{id}/update', [MainController::class, 'update'])->name('products.update');

Route::delete('/products/{id}/delete', [MainController::class, 'destroy'])->name('products.destroy');

Route::get('/checkout', [MainController::class, 'view_checkout_page'])->name('checkout');

Route::post('/post', [MainController::class, 'get_localstorage_data']);

Route::post('/make_receipt', [MainController::class, 'make_receipt']);

Route::get('/transactions', [MainController::class, 'view_transactions_history'])->name('transactions');

Route::get('/transaction/{id}', [MainController::class, 'view_transaction']);

