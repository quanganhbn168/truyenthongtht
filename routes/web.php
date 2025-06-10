<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IntroController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::group(['prefix'=>'san-pham'], function(){

    Route::get('/san-pham-1', function(){
        return view('frontend.products.detail');
    });
    Route::get('/', [ProductController::class,'allProduct'])->name('frontend.allProduct');
    Route::get('/{categories}', [ProductController::class,'productByCate'])->name('frontend.productByCate');
    Route::get('chi-tiet/{product-slug}', [ProductController::class,'show'])->name('product.show');
});
Route::group(['prefix'=>'danh-muc'], function(){
    Route::get('/', [PostController::class],'allPost')->name('frontend.posts.allPost');
    Route::get('/{slug}', [PostController::class],'postByCate')->name('frontend.postByCate');
    Route::get('chi-tiet/{post-slug}', [PostController::class],'detail')->name('frontend.posts.detail');
});
Route::get('gioi-thieu', [IntroController::class,'show'])->name('intro.show');
Route::get('lien-he',[ContactController::class,'show'])->name('contact.show');
Route::post('lien-he',[ContactController::class,'store'])->name('contact.store');
require __DIR__.'/admin.php';   
require __DIR__.'/auth.php';   