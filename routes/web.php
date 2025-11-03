<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostCntroller;

Route::get('/', [PostCntroller::class,'index'] )->name('posts.index');

Route::get('/posts/create', [PostCntroller::class, 'create'])->name('posts.create');
Route::post('/posts', [PostCntroller::class, 'store'])->name('posts.store');
Route::get('/posts/{post}/edit', [PostCntroller::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostCntroller::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostCntroller::class, 'destroy'])->name('posts.destroy');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
