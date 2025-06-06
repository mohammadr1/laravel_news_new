<?php

use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\TagController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\NewsController;
use App\Http\Controllers\Customer\SearchController;
use App\Http\Controllers\Customer\CategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;



// صفحه اصلی سایت
Route::get('/', [HomeController::class, 'home'])->name('customer.home');

// صفحه یک دسته‌بندی خاص
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('customer.category.show');

// صفحه یک خبر خاص
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('customer.news.show');

// صفحه تگ خاص
Route::get('/tags/{tags:name}', [TagController::class, 'show'])->name('customer.news.tags');

// Route::prefix('admin')->namespace('Admin')->group(function(){
//     Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.home');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/search', [SearchController::class, 'index'])->name('customer.search');


Route::get('/s/{code}', function ($code) {
    $news = News::where('short_link', $code)->firstOrFail();
    return redirect()->route('customer.news.show', $news);
})->name('short.redirect');


require __DIR__.'/auth.php';
