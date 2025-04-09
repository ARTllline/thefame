<?php

use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware(['check.region'])->group(function () {
    Route::get('/', [\App\Http\Controllers\RouteController::class, 'showHome'])->name('home');
    Route::get('/services', [\App\Http\Controllers\RouteController::class, 'showServices'])->name('services');
    Route::get('/services/{service}', [\App\Http\Controllers\RouteController::class, 'showService'])->name('service');
    Route::get('/team', [\App\Http\Controllers\RouteController::class, 'showTeam'])->name('team');
    Route::get('/about', [\App\Http\Controllers\RouteController::class, 'showAbout'])->name('about');
    Route::get('/contact', [\App\Http\Controllers\RouteController::class, 'showContact'])->name('contact');

    Route::get('/special-offer/{offer}', [\App\Http\Controllers\RouteController::class, 'showSpecialOffer'])->name('special-offer');

});



Route::post('/select-locale', [\App\Http\Controllers\LanguageController::class, 'switchLanguage'])->name('locale.set');
Route::post('/select-region', [RegionController::class, 'set'])->name('region.set');
