<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('aboutus');
})->name('about');

Route::resource('contact', ContactController::class)->only('store');
Route::resource('contact', ContactController::class)->middleware(['auth', 'verified', 'admin'])->only('index', 'show', 'destroy');

Route::resource('product', ProductController::class)->middleware(['auth', 'verified'])->except('show');
Route::resource('product', ProductController::class)->only('show');

Route::resource('auction', AuctionController::class)->middleware(['auth', 'verified'])->except('create', 'show', 'edit');
Route::resource('product.auction', AuctionController::class)->middleware(['auth', 'verified'])->only('create');
Route::resource('auction', AuctionController::class)->only('show');

Route::get('/auctions', function(){
    return view('auction');
})->name('auction.view');

Route::get('/pay/{id}', [PaymentController::class, 'pay'])->middleware(['auth', 'verified'])->name('payment.pay');
Route::get('/withdraw/{id}', [PaymentController::class, 'withdraw'])->middleware(['auth', 'verified'])->name('payment.withdraw');
Route::put('/review/{id}', [PaymentController::class, 'review'])->middleware(['auth', 'verified'])->name('payment.review');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified', 'admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/requests', [AdminController::class, 'auction'])->name('admin.auction');
    Route::get('/add-admin', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/add-admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/request/{id}', [AdminController::class, 'accept'])->name('admin.accept');
    Route::patch('/deny/{id}', [AdminController::class, 'deny'])->name('admin.deny');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'fund'])->name('profile.fund');
    Route::put('/profile', [ProfileController::class, 'contact'])->name('profile.contact');
    Route::get('/user/{id}', [ProfileController::class, 'view'])->name('profile.view');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
