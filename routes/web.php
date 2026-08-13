<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'view_dashboard'])->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/products', [ProductController::class, 'get_product_page'])->name('products');

Route::post('/products/create', [ProductController::class, 'create_new_product'])->name('products.create');

Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');

Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/checkout', [ProductController::class, 'view_checkout_page'])->name('checkout');

Route::post('/post', [ProductController::class, 'get_localstorage_data']);

Route::post('/make_receipt', [ProductController::class, 'make_receipt']);

Route::get('/transactions', [ProductController::class, 'view_transactions_history'])->name('transaction');

Route::get('/transaction/{id}', [ProductController::class, 'view_transaction']);


