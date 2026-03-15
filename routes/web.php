<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleOneTapController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

Route::get('/test-redis', function () {
    // Check if the cache exists
    if (Cache::has('browser_test')) {
        return "Loaded from Redis Cache: " . Cache::get('browser_test');
    }

    // If not, set it for 1 minute (60 seconds)
    $message = "This is fresh data created at " . now();
    Cache::put('browser_test', $message, 60);

    return "Saved to Redis. Refresh the page! Data: " . $message;
});

// Publicly accessible feed
Route::get('/', [PostController::class, 'index'])->name('posts.index');

// -----------------------------------------------------------------------------
// Sitemap Route (MUST go above the wildcard)
// -----------------------------------------------------------------------------
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// -----------------------------------------------------------------------------
// Authentication Routes
// -----------------------------------------------------------------------------
Route::post('/auth/google/verify', [GoogleOneTapController::class, 'verify'])->name('auth.google.verify');
Route::view('/login', 'login')->name('login')->middleware('guest');

// Actions that require the user to be logged in
Route::middleware('auth')->group(function () {
    Route::get('/upload', [PostController::class, 'create'])->name('posts.create');
    Route::post('/upload', [PostController::class, 'store'])->name('posts.store');

    Route::post('/posts/{post}/upvote', [PostController::class, 'upvote'])->name('posts.upvote');
    Route::post('/posts/{post}/downvote', [PostController::class, 'downvote'])->name('posts.downvote');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/logout', [GoogleOneTapController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Posts Management
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts.index');
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');

    // Categories Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleAdmin'])->name('users.toggle');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
