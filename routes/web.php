<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SlugController;
use App\Settings\WebsiteSettings;
use App\Support\Branding\FaviconService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/favicon.ico', function (WebsiteSettings $website, FaviconService $favicons) {
    try {
        $path = $favicons->primaryPath($website->site_favicon);
    } catch (\RuntimeException) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => $favicons->primaryMimeType($website->site_favicon),
        'Cache-Control' => 'public, max-age=604800',
    ]);
})->name('favicon');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Sitemap
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

// Listing pages
Route::get('/tin-tuc.html',   [PostController::class,    'index'])->name('posts.index');
Route::permanentRedirect('/tin-tuc', '/tin-tuc.html');
Route::get('/dich-vu.html', [ServiceController::class, 'index'])->name('services.index');
Route::permanentRedirect('/dich-vu', '/dich-vu.html');
Route::get('/san-pham.html',  [ProductController::class, 'index'])->name('products.index');
Route::permanentRedirect('/san-pham', '/san-pham.html');
Route::get('/du-an.html', [ProjectController::class, 'index'])->name('projects.index');
Route::permanentRedirect('/du-an', '/du-an.html');

// Static pages (định nghĩa trước catch-all)
Route::get('/gioi-thieu.html', [AboutController::class, 'index'])->name('about');
Route::permanentRedirect('/gioi-thieu', '/gioi-thieu.html');

// Contact & Quote forms
Route::get('/lien-he.html', [ContactController::class, 'index'])->name('contact.index');
Route::permanentRedirect('/lien-he', '/lien-he.html');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

Route::get('/bao-gia.html', [QuoteController::class, 'index'])->name('quote.index');
Route::permanentRedirect('/bao-gia', '/bao-gia.html');
Route::post('/bao-gia', [QuoteController::class, 'store'])->name('quote.store');

// Legacy course landing URLs → canonical, human-readable URLs.
Route::permanentRedirect('/khoa-hoc-chup-anh-.html', '/khoa-hoc-chup-anh.html');
Route::permanentRedirect('/khoa-hoc-chup-anh-', '/khoa-hoc-chup-anh.html');
Route::permanentRedirect('/khoa-hoc-chup-anh--1.html', '/khoa-hoc-chup-anh.html');
Route::permanentRedirect('/khoa-hoc-chup-anh--1', '/khoa-hoc-chup-anh.html');
Route::permanentRedirect('/khoa-hoc-chup-anh-bang-dien-thoai-1.html', '/khoa-hoc-chup-anh-bang-dien-thoai.html');
Route::permanentRedirect('/khoa-hoc-chup-anh-bang-dien-thoai-1', '/khoa-hoc-chup-anh-bang-dien-thoai.html');

/*
|--------------------------------------------------------------------------
| Catch-all slug route — MUST be last
| Handles: /slug, /slug.html, /category/slug, etc.
|--------------------------------------------------------------------------
*/
Route::get('{slug}', [SlugController::class, 'show'])
    ->where('slug', '.*')
    ->name('slug.show');
