<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Routing\RouteUrlGenerator;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/create', [ProductController::class, 'create']);

Route::post('/products/create', [ProductController::class, 'store']);

Route::get('/products/{id}/update', [ProductController::class, 'edit']);

Route::put('/products/{id}/update', [ProductController::class, 'update']);

Route::delete('/products/{id}/delete', [ProductController::class, 'destroy']);
