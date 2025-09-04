<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;

Route::group( [ 'prefix' => 'user', 'middleware' => 'userMiddleware'], function() {

    Route::get('home', [UserController::class, 'home'])->name('user#homePage');

    Route::group( ['prefix' => 'profile'], function() {
        // Route::get('change/password', [ProfileController::class, 'changePasswordPage'])->name('profile#changePasswordPage');
        // Route::post('change/password', [ProfileController::class, 'changePassword'])->name('profile#changePassword'); // can be same name bcoz methods aren't same

        // Route::get('edit', [ProfileController::class, 'editProfile'])->name('profile#edit');
        // Route::post('update', [ProfileController::class, 'updateProfile'])->name('profile#update');

    } );

    Route::get('product/details/{id}', [UserController::class, 'productDetails'])->name('user#productDetails');

    Route::post('comment', [UserController::class, 'comment'])->name('user#comment');
    Route::get('comment/delete/{id}', [UserController::class, 'commentDelete'])->name('user#commentDelete');

    Route::post('rating', [UserController::class, 'rating'])->name('user#rating');

    Route::get('cart', [UserController::class, 'cart'])->name('user#cart');
    Route::post('addToCart', [UserController::class, 'addToCart'])->name('user#addToCart');

    // api
    Route::get('cartDelete', [UserController::class, 'cartDelete'])->name('user#cartDelete');

    Route::get('paymentPage', [UserController::class, 'paymentPage'])->name('user#paymentPage');

    Route::get('tempStorage', [UserController::class, 'tempStorage'])->name('user#paymentPage');

    Route::post('order', [UserController::class, 'order'])->name('user#order');
    Route::get('orderList', [UserController::class, 'orderList'])->name('user#orderList');

} );
