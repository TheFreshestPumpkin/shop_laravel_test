<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/group/{id}', [GroupController::class, 'show'])->name('group');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product');

