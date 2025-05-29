<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffRegisterController;

// Các route mới thêm từ nhánh PjTT-VNPT
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// ✅ Nhóm route staff (có auth + role:staff)
// 🚫 KHÔNG CÓ middleware => ai cũng vào được /staff/dashboard
Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
Route::post('/staff/logout', [StaffController::class, 'logout'])->name('staff.logout');


// ✅ Nhóm route user (có auth + role:user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');
});

// Đăng nhập
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Yêu cầu auth
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
});

// Trang chính
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Toggle yêu thích
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

// Sản phẩm
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{category}', [ProductController::class, 'category'])->name('products.category');

// Auth routes
require __DIR__.'/auth.php';

// Staff register
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('register', [StaffRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [StaffRegisterController::class, 'register']);
});

