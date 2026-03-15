<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleOneTapController;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

// Publicly accessible feed
Route::get('/', [PostController::class, 'index'])->name('posts.index');

// -----------------------------------------------------------------------------
// Authentication Routes
// -----------------------------------------------------------------------------
Route::post('/auth/google/verify', [GoogleOneTapController::class, 'verify'])->name('auth.google.verify');
Route::view('/login', 'login')->name('login')->middleware('guest');

// Actions that require the user to be logged in
Route::middleware('auth')->group(function () {
    Route::get('/upload', [PostController::class, 'create'])->name('posts.create');
    Route::post('/upload', [PostController::class, 'store'])->name('posts.store');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/posts/{post}/upvote', [PostController::class, 'upvote'])->name('posts.upvote');
    Route::post('/posts/{post}/downvote', [PostController::class, 'downvote'])->name('posts.downvote');
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
