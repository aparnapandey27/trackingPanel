<?php

use App\Http\Controllers\Advertiser\AccountController;
use App\Http\Controllers\Advertiser\DashboardController;
use App\Http\Controllers\Advertiser\IPController;
use App\Http\Controllers\Advertiser\OfferController;
use App\Http\Controllers\Admin\OfferGoalController;
use App\Http\Controllers\Advertiser\CommonController;
use App\Http\Controllers\Advertiser\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertiserController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/offers', [OfferController::class, 'index'])->name('offer.index');
Route::get('/offer/create', [OfferController::class, 'create'])->name('offer.create');
Route::post('/offer/store', [OfferController::class, 'store'])->name('offer.store');
Route::get('/offer/show/{id}', [OfferController::class, 'show'])->name('offer.show');
Route::get('/offer/edit/{id}', [OfferController::class, 'edit'])->name('offer.edit');
Route::put('/offer/{offer}/update', [OfferController::class, 'update'])->name('offer.update');

/*
 * Offer Goal Routes
 */
Route::get('/offer/add/{id}/goal', [OfferGoalController::class, 'create'])->name('offer.goal.create');
Route::post('/offer/store/goal', [OfferGoalController::class, 'store'])->name('offer.goal.store');
Route::get('/offer/edit/{offer}/goal/{goal}', [OfferGoalController::class, 'edit'])->name('offer.goal.edit');
Route::put('/offer/update/{offer}/goal/{goal}', [OfferGoalController::class, 'update'])->name('offer.goal.update');
Route::delete('/offer/delete/goal/{id}', [OfferGoalController::class, 'destroy'])->name('offer.goal.destroy');

Route::get('/report/performance', [ReportController::class, 'performance'])->name('report.performance');
Route::post('/report/performance', [ReportController::class, 'performance'])->name('report.performance.post');
Route::get('/report/conversion', [ReportController::class, 'conversion'])->name('report.conversion');
Route::post('/report/conversion', [ReportController::class, 'conversion'])->name('report.conversion.post');

Route::get('/ipAll', [IPController::class, 'index'])->name('ip.index');
Route::get('/ip/create', [IPController::class, 'create'])->name('ip.create');
Route::post('/ip/store', [IPController::class, 'store'])->name('ip.store');
Route::get('/ip/edit/{id}', [IPController::class, 'edit'])->name('ip.edit');
Route::put('/ip/update/{id}', [IPController::class, 'update'])->name('ip.update');
Route::get('/ip/show/{id}', [IPController::class, 'show'])->name('ip.show');
Route::delete('/ip/delete/{id}', [IPController::class, 'destroy'])->name('ip.destroy');
Route::post('/ip/status/{id}', [IPController::class, 'status'])->name('ip.status');


Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
Route::post('/account/profile-photo', [AccountController::class, 'updateProfilePhoto'])->name('account.profile-photo');
Route::get('/account/security_token/{id}', [AccountController::class, 'security_token'])->name('account.security.token.generate');

/**
 * Common Routes
 */
Route::get('/common/students', [CommonController::class, 'getStudents'])->name('getStudents');
Route::get('/common/offers', [CommonController::class, 'getOffers'])->name('getOffers');
Route::get('/common/categories', [CommonController::class, 'getCategories'])->name('getCategories');
Route::get('/common/countries', [CommonController::class, 'getCountries'])->name('getCountries');
Route::get('/common/devices', [CommonController::class, 'getDevices'])->name('getDevices');
Route::get('/common/browsers', [CommonController::class, 'getBrowsers'])->name('getBrowsers');