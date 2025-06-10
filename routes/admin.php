<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IntroController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ToggleController;


Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/toggle', [ToggleController::class, 'toggle'])->name('admin.toggle');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('post-categories', PostCategoryController::class);
    Route::resource('posts', PostController::class);
    Route::resource('intro', IntroController::class);
    Route::resource('slides', SlideController::class);
    Route::resource('services',ServiceController::class);
    Route::resource('contacts', ContactController::class);
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
      ->name('categories.toggle-status');
    Route::post('/slides/{slide}/toggle-status', [SlideController::class, 'toggleStatus'])
      ->name('slides.toggle-status');
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
  
});

Route::post('admin/upload', [UploadController::class,'upload'])->name('admin.upload');
Route::delete('/filepond/delete', [UploadController::class, 'delete'])->name('filepond.delete');
