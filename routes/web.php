<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SlugController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Sitemap
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Listing pages
Route::get('/tin-tuc.html',   [PostController::class,    'index'])->name('posts.index');
Route::get('/tin-tuc',   [PostController::class,    'index']);
Route::get('/dich-vu.html', [ServiceController::class, 'index'])->name('services.index');
Route::get('/dich-vu',   [ServiceController::class, 'index']);
Route::get('/san-pham.html',  [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham',  [ProductController::class, 'index']);
Route::get('/du-an.html', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/du-an',     [ProjectController::class, 'index']);

// Static pages (định nghĩa trước catch-all)
Route::get('/gioi-thieu.html', [AboutController::class, 'index'])->name('about');
Route::get('/gioi-thieu',      [AboutController::class, 'index']);

// Contact form
Route::get('/lien-he.html', [ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Catch-all slug route — MUST be last
| Handles: /slug, /slug.html, /category/slug, etc.
|--------------------------------------------------------------------------
*/
Route::get('{slug}', [SlugController::class, 'show'])
    ->where('slug', '.*')
    ->name('slug.show');
