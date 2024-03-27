<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertentieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\HomeController;

// Homge Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Advertenties Routes
Route::resource('advertenties', AdvertentieController::class)
    ->middleware(['auth', 'verified']);

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Contracts Routes for Business Users
Route::middleware(['auth', 'isBusiness'])->group(function () {
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.export');
});

Route::get('/contracts', [ContractController::class, 'index'])->middleware('auth')->name('contracts.index');


Route::get('/api/generateToken', [ProfileController::class, 'generateApiToken'])->middleware('auth')->name('profile.generateApiToken');

Route::middleware(['auth:sanctum', 'isBusiness'])->group(function () {
    Route::get('/api/advertenties', [AdvertentieController::class, 'getUserAdvertenties']);
    Route::get('/api/advertentie/{advertentie}', [AdvertentieController::class, 'GetAdvertentie']);
});

Route::get('/landingpage-settings/create', [LandingPageController::class, 'create'])
    ->middleware('isBusiness')->name('landingpage-settings.create');
Route::post('/landingpage-settings', [LandingPageController::class, 'store'])
    ->middleware('isBusiness')->name('landingpage-settings.store');

Route::get('/landingpage/{url}', [LandingPageController::class, 'show'])->name('landingpage.show');

require __DIR__ . '/auth.php';
