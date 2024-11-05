<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;





Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    // Admin specific routes (if necessary)
    Route::prefix('admin')->middleware('role:seller')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'viewSellerOrders'])->name('admin.dashboard');
        
        Route::get('/view_category', [CategoryController::class, 'view_category'])->name('admin.category');
        Route::post('add_category', [CategoryController::class, 'add_category'])->name('admin.addCategory');
        Route::get('delete_category/{id}', [CategoryController::class, 'delete_category'])->name('admin.deleteCategory');

        Route::get('add_product', [ProductController::class, 'add_product'])->name('admin.addProduct');
        Route::post('upload_product', [ProductController::class, 'upload_product'])->name('admin.uploadProduct');
        Route::get('show_product', [ProductController::class, 'show_product'])->name('admin.showProduct');
        Route::delete('delete_product/{id}', [ProductController::class, 'delete_product'])->name('admin.deleteProduct');
        Route::get('show_product/{id}/edit', [ProductController::class, 'edit_product'])->name('admin.editProduct');
        Route::put('update_product/{id}/update', [ProductController::class, 'update_product'])->name('admin.updateProduct');
        Route::put('/admin/orders/{id}/update-status', [OrderController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    });
    
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
