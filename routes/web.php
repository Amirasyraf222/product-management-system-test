<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('products.index'));

Route::resource('products', ProductController::class);
Route::get('/preview', [ProductController::class, 'preview'])->name('products.preview');
Route::resource('categories', CategoryController::class)->except(['show']);

