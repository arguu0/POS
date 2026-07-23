<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\ProductDatabase;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/products', [ProductController::class, 'get_product_page'])->name('products');

Route::post('/products/create', [ProductController::class, 'create_new_product'])->name('products.create');

Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');

Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/cart', [ProductController::class, 'view_cart'])->name('transaction');

Route::get('/get_products', [ProductController::class, 'return_product_data'])->name('receipt');

Route::post('/cart/transaction', [ProductController::class, 'create_transaction_history']);

Route::get('/receipt/{id}', [ProductController::class, 'view_receipt'])->name('receipt.show');