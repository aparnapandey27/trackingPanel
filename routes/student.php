<?php

use App\Http\Controllers\Student\CommonController;
use App\Http\Controllers\Student\OfferController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\AccountController;
use App\Http\Controllers\Student\OfferFeedController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\PostbackController;
use App\Http\Controllers\Student\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\OfferSharePayoutController;
use App\Http\Controllers\StudentController;


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/offerAll', [OfferController::class, 'index'])->name('offer.index');
Route::get('/offer/my', [OfferController::class, 'my'])->name('offer.my');
Route::get('/offer/view/{id}', [OfferController::class, 'show'])->name('offer.show');
Route::get('/offer/apply/{id}', [OfferController::class, 'apply'])->name('offer.apply');

Route::get('/report/performance', [ReportController::class, 'performance'])->name('report.performance');
Route::get('/report/conversion', [ReportController::class, 'conversion'])->name('report.conversion');

Route::resource('/settings/postback', PostbackController::class, ['names' => 'postback']);
Route::get('/settings/postbacks/logs/{id}', [PostbackController::class, 'logs'])->name('postback.logs');
Route::get('/payments', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment-profile/store', [PaymentController::class, 'store'])->name('payment.store');

Route::get('/settings/account', [AccountController::class, 'index'])->name('account.index');
Route::put('/settings/account/update', [AccountController::class, 'update'])->name('account.update');
Route::post('/settings/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
Route::post('/settings/account/profile-photo', [AccountController::class, 'updateProfilePhoto'])->name('account.profile-photo');

Route::get('/settings/offer-feed', [OfferFeedController::class, 'index'])->name('offer-feed.index');
Route::get('/settings/offer-feed/security_token/{id}', [OfferFeedController::class, 'security_token'])->name('offer-feed.security.token.generate');
/**
 * Affiliate Common Routes
 */
Route::get('/common/offers', [CommonController::class, 'getOffers'])->name('getOffers');
Route::get('/common/categries', [CommonController::class, 'getCategories'])->name('getCategories');
Route::get('/common/countries', [CommonController::class, 'getCountries'])->name('getCountries');
Route::get('/getGoalsForOffer/{offerId}', [PostbackController::class, 'getGoalsForOffer'])->name('getGoalsForOffer');

/*
 * Offer Share Payout Routes
 */
Route::post('/offer/store/share_payout', [OfferSharePayoutController::class, 'store'])->name('offer.sharepay.store');
Route::post('/signup', [StudentController::class, 'signupSubmit'])->name('signup.submit');





// // Guest Routes (for public access, such as signup)
// Route::middleware('guest')->group(function () {
//     // Signup Route
//     Route::post('/signup', [StudentController::class, 'submit'])->name('signup.submit');
// });

