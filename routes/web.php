<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;

//Admin Controllers
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware([])->prefix('')->name('')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.layouts.dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

require __DIR__ . '/auth.php';
