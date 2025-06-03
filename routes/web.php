<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\customer\NewsController;
use App\Http\Controllers\customer\TagController;
use App\Http\Controllers\ProfileController;
use App\Models\News;
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


Route::get('/s/{code}', function ($code) {
    $news = News::where('short_link', $code)->firstOrFail();
    return redirect()->route('customer.news.show', $news);
})->name('short.redirect');

// tags
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('customer.tags.show');

require __DIR__.'/auth.php';
