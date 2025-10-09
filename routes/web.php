<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin routes here
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/', [FrontendController::class, 'index'])->name('home');
// Route::get('/shop', [ProductController::class, 'index'])->name('shop');
// Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
// Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
// Route::get('/offers', [OfferController::class, 'index'])->name('offers');
// Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');
// Route::get('/contact', [ContactController::class, 'index'])->name('contact');
// Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/shop', 'shop')->name('shop');
    Route::get('/product/{slug}', 'product')->name('product');
    Route::get('/offers', 'offers')->name('offers');
    Route::get('/testimonials', 'testimonials')->name('testimonials');
    Route::get('/contact', 'contact')->name('contact');
});


require __DIR__ . '/auth.php';
