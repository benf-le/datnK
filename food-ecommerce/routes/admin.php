<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Middleware\DefaultAdminData;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->middleware(['auth.custom']);

    Route::middleware(['check.auth.admin'])->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    });

    // Logout dùng POST
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth.custom', DefaultAdminData::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/profile', [AccountController::class, 'index'])->name('admin.profile');
        Route::post('/profile/update', [AccountController::class, 'updateProfile']);
        Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
        Route::post('/notification/update', [NotificationController::class, 'update']);

        Route::middleware(['permission:manage_users'])->group(function () {
            Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
            Route::post('/user/upgrade', [UsersController::class, 'upgrade']);
            Route::post('/user/updateStatus', [UsersController::class, 'updateStatus']);
        });

        Route::middleware(['permission:manage_categories'])->group(function () {
            Route::get('/categories/add', [CategoryController::class, 'showFormAddCate'])->name('admin.categories.add');
            Route::post('/categories/add', [CategoryController::class, 'addCategory'])->name('admin.categories.add');

            Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
            Route::post('/categories/update', [CategoryController::class, 'updatdeCategory']);
            Route::post('/categories/delete', [CategoryController::class, 'deleteCategory']);
        });

        Route::middleware(['permission:manage_products'])->group(function () {
            Route::get('/product/add', [ProductController::class, 'showFormAddProduct'])->name('admin.product.add');
            Route::post('/product/add', [ProductController::class, 'addProduct'])->name('admin.product.add');

            Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
            Route::post('/product/update', [ProductController::class, 'updateProduct']);
            Route::post('/product/delete', [ProductController::class, 'deleteProduct']);
        });

        Route::middleware(['permission:manage_orders'])->group(function () {
            Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
            Route::post('/order/confirm', [OrderController::class, 'confirmOrder']);

            Route::get('/order-detail/{id}', [OrderController::class, 'showOrderDetail'])->name('admin.order-detail');
            Route::post('/order-detail/send-invoice', [OrderController::class, 'sendMailInvoice']);
            Route::post('/order-detail/cancel-order', [OrderController::class, 'cancelOrder']);
        });

        Route::middleware(['permission:manage_contacts'])->group(function () {
            Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
            Route::post('/contact/reply', [ContactController::class, 'replyContact']);
        });
    });
});
