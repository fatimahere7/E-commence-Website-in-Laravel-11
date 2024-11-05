<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;








Route::get('/', [ProductController::class, 'index'])->name('welcomeHome');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/add-cart/{id}',[ProductController::class,'add_cart'])->middleware(['auth', 'verified'])->name('addCart');
Route::delete('/cart/remove/{id}', [ProductController::class, 'remove'])->name('cart.remove');
//addedToCart

Route::get('/cart',[ProductController::class,'showCart'])->middleware(['auth', 'verified'])->name('addedToCart');
Route::post('/cart/confirm', [OrderController::class, 'confirmOrder'])->middleware(['auth', 'verified'])->name('confirmOrder');
Route::get('/order/confirmation/{order_id}', [OrderController::class, 'orderConfirmation'])->name('order.confirmation');
Route::get('/search', [ProductController::class, 'searchByCategory'])->name('search.by.category');
Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');
Route::post('/order/{order}/update-payment', [OrderController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');
Route::put('/order/{order}/update-address', [OrderController::class, 'updateAddress'])->name('updateAddress');
// Route::get('/order/{order}/pay-by-card', [PaymentController::class, 'payByCard'])->name('payByCard');
Route::controller(StripePaymentController::class)->group(function(){

    Route::get('stripe', 'stripe');

    Route::post('stripe', 'stripePost')->name('stripe.post');

});
// Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

require __DIR__.'/auth.php';
// require __DIR__.'/admin-auth.php';