<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['check.region'])->group(function () {
    Route::get('/', [\App\Http\Controllers\RouteController::class, 'showHome'])->name('home');
    Route::get('/services', [\App\Http\Controllers\RouteController::class, 'showServices'])->name('services');
    Route::get('/services/{service}', [\App\Http\Controllers\RouteController::class, 'showService'])->name('service');
    Route::get('/team', [\App\Http\Controllers\RouteController::class, 'showTeam'])->name('team');
    Route::get('/about', [\App\Http\Controllers\RouteController::class, 'showAbout'])->name('about');
    Route::get('/contact', [\App\Http\Controllers\RouteController::class, 'showContact'])->name('contact');
    Route::get('/devices', [\App\Http\Controllers\RouteController::class, 'showDevices'])->name('devices');
    Route::get('/gallery', [\App\Http\Controllers\RouteController::class, 'showGallery'])->name('gallery');
    Route::get('/special-offer/{offer}', [\App\Http\Controllers\RouteController::class, 'showSpecialOffer'])->name('special-offer');
    Route::view('/promo', 'promo')->name('promo');
    Route::view('/promo-face-test', 'promo-face-t')->name('promo-face-t');
    Route::view('/promo-face', 'promo-face')->name('promo-face');

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'showCartPage'])->name('cart');
   // Route::get('/checkout-result', [\App\Http\Controllers\CartController::class, 'showCartResultPage'])->name('cart-result');
    Route::get('/checkout/success', [CartController::class, 'showOrderResult'])->name('checkout.success');

    Route::get('/load-more/services', [\App\Http\Controllers\DataController::class, 'loadMoreServices'])->name('services.load_more');


    Route::get('/catalogue/{path?}', [ProductController::class, 'resolve'])
        ->where('path', '.*')
        ->name('catalogue.resolve');

    Route::get('/product/{slug}', [ProductController::class, 'showProduct'])->name('product.resolve');

});


Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/checkout', [AppointmentController::class, 'checkout'])->name('checkout.promo');

Route::post('/select-locale', [\App\Http\Controllers\LanguageController::class, 'switchLanguage'])->name('locale.set');
Route::post('/select-region', [RegionController::class, 'set'])->name('region.set');
