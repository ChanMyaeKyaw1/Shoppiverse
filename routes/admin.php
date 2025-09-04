<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\OrderController;

Route::group( [ 'prefix' => 'admin', 'middleware' => 'adminMiddleware'], function() {

    // Route::get('home', [AdminController::class, 'adminHome'])->name('adminHome');

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin#dashboard');

    Route::group( ['prefix' => 'category'], function() {
        Route::get('list', [CategoryController::class, 'list'])->name('category#list');
        Route::post('create', [CategoryController::class, 'create'])->name('category#create');
        Route::post('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('category#update');
    });

    Route::group( ['prefix' => 'product'], function() {
        Route::get('createPage', [ProductController::class, 'createPage'])->name('product#createPage');
        Route::post('create', [ProductController::class, 'create'])->name('product#create');
        Route::get('list/{action?}', [ProductController::class, 'list'])->name('product#list');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product#delete');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product#edit');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('product#update');
    });

    Route::group( ['prefix' => 'profile'], function() {
        Route::get('change/password', [ProfileController::class, 'changePasswordPage'])->name('profile#changePasswordPage');
        Route::post('change/password', [ProfileController::class, 'changePassword'])->name('profile#changePassword'); // can be same name bcoz methods aren't same

        Route::get('edit', [ProfileController::class, 'editProfile'])->name('profile#edit');
        Route::post('update', [ProfileController::class, 'updateProfile'])->name('profile#update');

    } );

    Route::group( ['middleware' => 'superAdminMiddleware'], function() {

        Route::group( ['prefix' => 'payment'], function() {
            Route::get('list', [PaymentController::class, 'list'])->name('payment#list');
            Route::post('store', [PaymentController::class, 'store'])->name('payment#store');
            Route::get('edit/{id}', [PaymentController::class, 'edit'])->name('payment#edit');
            Route::post('update/{id}', [PaymentController::class, 'update'])->name('payment#update');
            // using POST for delete (safer than GET)
            Route::post('delete/{id}', [PaymentController::class, 'delete'])->name('payment#delete');
        });

        Route::group( ['prefix' => 'account'], function() {
            Route::get('create/newAdmin', [AdminController::class, 'createAdminPage'])->name('account#newAccountPage');
            Route::post('create/newAdmin', [AdminController::class, 'createAdmin'])->name('account#createNewAdmin');

            Route::get('admin/list', [AdminController::class, 'adminList'])->name('account#adminList');
            Route::get('admin/delete/{id}', [AdminController::class, 'adminDelete'])->name('account#adminDelete');

            Route::get('user/list', [AdminController::class, 'userList'])->name('account#userList');
            Route::get('user/delete/{id}', [AdminController::class, 'userDelete'])->name('account#userDelete');

        });

    } );


    Route::group( ['prefix' => 'order'], function() {
        Route::get('list', [OrderController::class, 'orderList'])->name('admin#orderList');
        Route::get('details/{orderCode}', [OrderController::class, 'orderDetails'])->name('admin#orderDetails');

        Route::get('reject', [OrderController::class, 'orderReject'])->name('admin#orderReject');
        Route::get('confirm', [OrderController::class, 'orderConfirm'])->name('admin#orderConfirm');

        Route::get('statusChange', [OrderController::class, 'orderStatusChange'])->name('admin#orderStatusChange');

    } );

} );
