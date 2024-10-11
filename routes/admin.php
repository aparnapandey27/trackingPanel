<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminEmployeeController;
use App\Http\Controllers\Admin\AdminAdvertiserController;
use App\Http\Controllers\Admin\LoginAsController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OfferRequestController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\ImportConversionController;
use App\Http\Controllers\Admin\IPController;
use App\Http\Controllers\Admin\MailRoomController;
use App\Http\Controllers\Admin\PreferenceController;
use App\Http\Controllers\Admin\PaymentOptionController;
use App\Http\Controllers\Admin\DailyMailController;
use App\Http\Controllers\Admin\OfferGoalController;
use App\Http\Controllers\Admin\OfferStudentController;
use App\Http\Controllers\Admin\ClickLimitController;
use App\Http\Controllers\Admin\ConversionLimitController;
use App\Http\Controllers\Admin\PostbackController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\AccountController;


// Admin Dashboard
Route::match(['GET', 'POST'], '/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');


Route::resource('offers/offerApplication', OfferRequestController::class);
// Route::get('offers/offerAll', [OfferController::class, 'index'])->name('offers.index');
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
Route::post('/offers/store', [OfferController::class, 'store'])->name('offers.store');
Route::get('/offers/edit/{id}', [OfferController::class, 'edit'])->name('offers.edit');
Route::put('/offers/update/{offer}', [OfferController::class, 'update'])->name('offers.update');
Route::get('/offers/show/{id}', [OfferController::class, 'show'])->name('offers.show');
Route::delete('/offers/delete/{id}', [OfferController::class, 'destroy'])->name('offers.destroy');
Route::get('/offers/clone/{id}', [OfferController::class, 'offer_clone'])->name('offers.clone');

Route::get('/offers/add/{id}/goal', [OfferGoalController::class, 'create'])->name('offers.goal.create');
Route::post('/offers/store/goal', [OfferGoalController::class, 'store'])->name('offers.goal.store');
Route::get('/offers/edit/{offer}/goal/{goal}', [OfferGoalController::class, 'edit'])->name('offers.goal.edit');
Route::put('/offers/update/{offer}/goal/{goal}', [OfferGoalController::class, 'update'])->name('offers.goal.update');
Route::delete('/offers/delete/goal/{id}', [OfferGoalController::class, 'destroy'])->name('offers.goal.destroy');

Route::get('/offers/add/{id}/student', [OfferStudentController::class, 'create'])->name('offers.students.create');
Route::post('/offers/store/student', [OfferStudentController::class, 'store'])->name('offers.students.store');
Route::get('/offers/edit/{offerid}/student/{studentid}', [OfferStudentController::class, 'edit'])->name('offers.students.edit');
Route::put('/offers/update/{offerid}/student/{studentid}', [OfferStudentController::class, 'update'])->name('offers.students.update');
Route::delete('/offers/delete/student/{id}', [OfferStudentController::class, 'destroy'])->name('offers.students.destroy');

/*
 * Offer Click Limit Routes
 */
Route::get('/offers/{offer}/clicklimit/create', [ClickLimitController::class, 'create'])->name('offers.clicklimit.create');
Route::post('/offers/store/clicklimit', [ClickLimitController::class, 'store'])->name('offers.clicklimit.store');
Route::get('/offers/edit/{offerid}/clicklimit/{clicklimitid}', [ClickLimitController::class, 'edit'])->name('offers.clicklimit.edit');
Route::put('/offers/update/{offerid}/clicklimit/{clicklimitid}', [ClickLimitController::class, 'update'])->name('offers.clicklimit.update');
Route::delete('/offers/delete/clicklimit/{id}', [ClickLimitController::class, 'destroy'])->name('offers.clicklimit.destroy');
/*
 * Offer Conversion Limit Routes
 */
Route::get('/offers/add/{id}/convlimit', [ConversionLimitController::class, 'create'])->name('offers.convlimit.create');
Route::post('/offers/store/convlimit', [ConversionLimitController::class, 'store'])->name('offers.convlimit.store');
Route::get('/offers/edit/{offerid}/convlimit/{convlimitid}', [ConversionLimitController::class, 'edit'])->name('offers.convlimit.edit');
Route::put('/offers/update/{offerid}/convlimit/{convlimitid}', [ConversionLimitController::class, 'update'])->name('offers.convlimit.update');
Route::delete('/offers/delete/convlimit/{id}', [ConversionLimitController::class, 'destroy'])->name('offers.convlimit.destroy');


// Student Management Routes
Route::prefix('students')->group(function () {
    Route::get('/', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/create', [AdminStudentController::class, 'create'])->name('students.create');
    Route::post('/', [AdminStudentController::class, 'store'])->name('students.store');
    Route::get('/manage', [AdminStudentController::class, 'manage'])->name('students.manage');
    Route::get('/{id}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
    Route::put('/{id}', [AdminStudentController::class, 'update'])->name('students.update');
    Route::delete('/{id}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/disable/{id}', [AdminStudentController::class, 'disable'])->name('students.disable');
    Route::post('/confirm/{id}', [AdminStudentController::class, 'confirm'])->name('students.confirm');
    Route::post('/reject/{id}', [AdminStudentController::class, 'reject'])->name('students.reject');
    Route::post('/status/{id}', [AdminStudentController::class, 'status'])->name('affiliate.status');
    Route::post('/manager/{id}', [AdminStudentController::class, 'manager'])->name('affiliate.manager');
    Route::post('/{id}/assign-manager', [AdminStudentController::class, 'storeManagerAssignment'])->name('store.manager.assignment');
    Route::put('/{id}/update-manager', [AdminStudentController::class, 'updateManager'])->name('update.manager');
    Route::resource('/postbacks', PostbackController::class, ['names' => 'postback']);
    Route::get('/postbacks/logs/{id}', [PostbackController::class, 'logs'])->name('postback.logs');
    Route::resource('/payments', PaymentController::class, ['names' => 'payment']);
    Route::post('/payment/generate', [PaymentController::class, 'generatePayment'])->name('payment.generate');
    Route::post('/payments/paid/{id}', [PaymentController::class, 'paid'])->name('payment.paid');
    Route::post('/payments/adjust/{id}', [PaymentController::class, 'adjust'])->name('payment.adjust');
    Route::get('/getGoalsForOffer/{offerId}', [PostbackController::class, 'getGoalsForOffer'])->name('getGoalsForOffer');
    Route::post('/signup', [AdminStudentController::class, 'signup'])->name('signup.submit');
    Route::get('/show/{id}', [AdminStudentController::class, 'show'])->name('show');
    
});


// Employee Management Routes
Route::prefix('employees')->group(function () {
    Route::get('/', [AdminEmployeeController::class, 'index'])->name('employees.index');
    Route::get('/create', [AdminEmployeeController::class, 'create'])->name('employees.create');
    Route::post('/', [AdminEmployeeController::class, 'store'])->name('employees.store');
    Route::get('/show/{id}', [AdminEmployeeController::class, 'show'])->name('employees.show');
    Route::get('/manage', [AdminEmployeeController::class, 'manage'])->name('employees.manage');
    Route::get('/{id}/edit', [AdminEmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/{id}', [AdminEmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/{id}', [AdminEmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::post('/confirm/{id}', [AdminEmployeeController::class, 'confirm'])->name('employees.confirm');
    Route::post('/disable/{id}', [AdminEmployeeController::class, 'disable'])->name('employees.disable');
    Route::post('/{id}/reject', [AdminEmployeeController::class, 'reject'])->name('employees.reject');
});

// Advertiser Management Routes
Route::prefix('advertisers')->group(function () {
    Route::get('/', [AdminAdvertiserController::class, 'index'])->name('advertisers.index');
    Route::get('/create', [AdminAdvertiserController::class, 'create'])->name('advertisers.create');
    Route::post('/', [AdminAdvertiserController::class, 'store'])->name('advertisers.store');
    Route::get('/manage', [AdminAdvertiserController::class, 'manage'])->name('advertisers.manage');
    Route::get('/{id}/edit', [AdminAdvertiserController::class, 'edit'])->name('advertisers.edit');
    Route::put('/{id}', [AdminAdvertiserController::class, 'update'])->name('advertisers.update');
    Route::delete('/{id}', [AdminAdvertiserController::class, 'destroy'])->name('advertisers.destroy');
    Route::post('/disable/{id}', [AdminAdvertiserController::class, 'disable'])->name('advertisers.disable');
    Route::post('/reject/{id}', [AdminAdvertiserController::class, 'reject'])->name('advertisers.reject');
    Route::post('/confirm/{id}', [AdminAdvertiserController::class, 'confirm'])->name('advertisers.confirm');
    Route::get('/{id}', [AdminAdvertiserController::class, 'show'])->name('advertisers.show');

});

/*
 * User Profile Routes
 */
Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
Route::post('/account/profile-photo', [AccountController::class, 'updateProfilePhoto'])->name('account.profile-photo');


// Admin Login Route
Route::get('/admin_login/{user}', [LoginAsController::class, 'loginAs'])->name('loginAs');


Route::resource('offer/categories', categoryController::class);





Route::get('report/performance', [ReportController::class, 'performance'])->name('report.performance');
Route::get('report/conversion', [ReportController::class, 'conversion'])->name('report.conversion');
Route::get('/report/log/conversion', [ReportController::class, 'conversion_log'])->name('report.conversion.log');
Route::get('/report/log/click', [ReportController::class, 'click_log'])->name('report.click.log');
Route::post('/conversion/update/{id}', [ReportController::class, 'conversion_update'])->name('report.conversion.update');
Route::post('/click/convert/{id}', [ReportController::class, 'click_to_conversion'])->name('report.click.conversion');


Route::get('/common/students', [CommonController::class, 'getStudents'])->name('getStudents');
Route::get('/common/offers', [CommonController::class, 'getOffers'])->name('getOffers');
Route::get('/common/get-featured-offers', [CommonController::class, 'getFeaturedOffers'])->name('getFeaturedOffers');
Route::post('/common/featured-offers', [CommonController::class, 'featuredOfferUpdate'])->name('featuredOfferUpdate');
Route::get('/common/categories', [CommonController::class, 'getCategories'])->name('getCategories');
Route::get('/common/countries', [CommonController::class, 'getCountries'])->name('getCountries');
Route::get('/common/states', [CommonController::class, 'getStates'])->name('getStates');
Route::get('/common/devices', [CommonController::class, 'getDevices'])->name('getDevices');
Route::get('/common/browsers', [CommonController::class, 'getBrowsers'])->name('getBrowsers');
Route::get('/common/users', [CommonController::class, 'getUsers'])->name('getUsers');
Route::get('/common/managers', [CommonController::class, 'getManagers'])->name('getManagers');

Route::get('/conversionImp', [ImportConversionController::class, 'index'])->name('conversion.index');
Route::post('/conversion/import', [ImportConversionController::class, 'import'])->name('conversion.import');

Route::get('ip/ipAll', [IPController::class, 'index'])->name('ip.index');
Route::get('/ip/create', [IPController::class, 'create'])->name('ip.create');
Route::post('/ip/store', [IPController::class, 'store'])->name('ip.store');
Route::get('/ip/edit/{id}', [IPController::class, 'edit'])->name('ip.edit');
Route::put('/ip/update/{id}', [IPController::class, 'update'])->name('ip.update');
Route::get('/ip/show/{id}', [IPController::class, 'show'])->name('ip.show');
Route::delete('/ip/delete/{id}', [IPController::class, 'destroy'])->name('ip.destroy');
Route::post('/ip/status/{id}', [IPController::class, 'updateStatus'])->name('ip.status');


Route::get('/mailroom', [MailRoomController::class, 'index'])->name('mailroom.index');
Route::post('/mailroom/send', [MailRoomController::class, 'send'])->name('mailroom.send');

Route::get('/preference/company', [PreferenceController::class, 'company'])->name('preference.company');
Route::post('/preference/company/update', [PreferenceController::class, 'companyUpdate'])->name('preference.company.update');
Route::get('/preference/mail', [PreferenceController::class, 'mail'])->name('preference.mail');
Route::resource('/preference/payment-options', PaymentOptionController::class, ['names' => 'preference.paymentOption']);
Route::get('/preference/payment-options', [PaymentOptionController::class, 'index'])->name('preference.paymentOption.index');

Route::get('/preference/additional-question', [PreferenceController::class, 'additional_question'])->name('preference.additional_question');
Route::post('/preference/additional_question_store', [PreferenceController::class, 'additional_question_store'])->name('preference.additional_question_store');
Route::delete('/preference/additional_question_delete/{id}', [PreferenceController::class, 'additional_question_delete'])->name('preference.additional_question_delete');

Route::post('/send-daily-reports', [DailyMailController::class, 'sendConversionReportToStudents'])->name('send.daily');
Route::get('/send-reports', [DailyMailController::class, 'index'])->name('send.daily.mail');
Route::post('/logs/clear', [DailyMailController::class, 'clearLogs'])->name('clearLogs');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
