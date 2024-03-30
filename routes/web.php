<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertentieController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContractController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\HomeController;

// Homge Page
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified', 'isBusiness'])->group(function () {
    Route::get('/advertenties/upload', [AdvertisementController::class, 'showUploadForm'])->name('advertenties.upload.show');
    Route::post('/advertenties/upload', [AdvertisementController::class, 'processCsvUpload'])->name('advertenties.upload.process');
    Route::get('/advertenties/upload/overview', [AdvertisementController::class, 'showUploadOverview'])->name('advertenties.upload.overview');
    Route::post('/advertenties/images/upload', [AdvertisementController::class, 'uploadImages'])->name('advertenties.images.upload');
});

// Resource route voor advertenties
Route::resource('advertenties', AdvertisementController::class)
    ->middleware(['auth', 'verified']);

Route::middleware(['auth', 'isStandard'])->group(function () {
    Route::get('/advertenties/create', [AdvertisementController::class, 'create'])->name('advertenties.create');
});
Route::post('/advertenties/{advertisement}/purchase', [AdvertisementController::class, 'purchase'])
    ->name('advertisement.purchase');
Route::get('/advertentie', [AdvertisementController::class, 'index'])
    ->name('advertisements.index');



// Authentication Pages
Route::get('/login', function () {
    return view('/auth/login');
})->name('login');

Route::get('/register', function () {
    return view('/auth/register');
})->name('register');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::post('profile/favorites/{advertisement}', [ProfileController::class, 'addFavorite'])->name('profile.addfavorite');
    Route::delete('profile/favorites/{advertisement}', [ProfileController::class, 'removeFavorite'])->name('profile.removefavorite');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Contracts Routes for Business Users
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.export');
});

Route::get('/contracts', [ContractController::class, 'index'])->middleware('auth')->name('contracts.index');


Route::get('/lang/{lang}', function ($lang, Request $request) {
    Session::put('locale', $lang);
    return back();
})->name('lang.switch');

Route::get('/api/generateToken', [ProfileController::class, 'generateApiToken'])->middleware('auth')->name('profile.generateApiToken');

Route::middleware(['auth:sanctum', 'isBusiness'])->group(function () {
    Route::get('/api/advertenties', [AdvertisementController::class, 'getUserAdvertenties'])->name('api.advertenties');
    Route::get('/api/advertentie/{advertentie}', [AdvertisementController::class, 'GetAdvertentie'])->name('api.advertentie');
});

Route::get('/landingpage-settings/create', [LandingPageController::class, 'create'])
    ->middleware('isBusiness')->name('landingpage-settings.create');
Route::get('/landingpage-settings/edit', [LandingPageController::class, 'edit'])
    ->middleware('isBusiness')->name('landingpage-settings.edit');
Route::post('/landingpage-settings', [LandingPageController::class, 'store'])
    ->middleware('isBusiness')->name('landingpage-settings.store');
Route::patch('/landingpage-settings/{pageSetting}', [LandingPageController::class, 'update'])
    ->middleware('isBusiness')->name('landingpage-settings.update');

Route::get('/landingpage/{url}', [LandingPageController::class, 'show'])->name('landingpage.show');

require __DIR__ . '/auth.php';
