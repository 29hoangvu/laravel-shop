<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\LoginController;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::middleware(['role:staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard'); // Thêm name cho route
    Route::post('/staff/logout', [StaffController::class, 'logout'])->name('staff.logout'); // Ví dụ route logout
});
Route::middleware(['role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard'); // Dòng này quan trọng!
    Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');
});
>>>>>>> Stashed changes

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
});
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
// Cập nhật số lượng
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
// Toggle yêu thích
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{category}', [ProductController::class, 'category'])->name('products.category');

<<<<<<< Updated upstream
=======
Route::get('/admin/index', [DashBoardController::class, 'index'])->name('admindashboard.index');


>>>>>>> Stashed changes
require __DIR__.'/auth.php';
