<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\customer\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'home'])->name('customer.home');
// Route::get('/news/{slug}', [NewsController::class, 'show'])->name('customer.news.show');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('customer.news.show');

Route::get('/{category:slug}', [HomeController::class, 'home'])->name('customer.home');

// Route::prefix('admin')->namespace('Admin')->group(function(){
//     Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.home');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
