<?php

use App\Http\Controllers\Employee\AccountController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\StudentController;
use App\Http\Controllers\Employee\CommonController;
use App\Http\Controllers\Employee\ReportController;
use App\Http\Controllers\Employee\OfferController;
use App\Http\Controllers\Employee\OfferStudentController;
use App\Http\Controllers\Employee\ClickLimitController;
use App\Http\Controllers\Employee\ConversionLimitController;
use App\Http\Controllers\Employee\PostbackController;
use App\Http\Controllers\Employee\ImportConversionController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('report/performance', [ReportController::class, 'performance'])->name('report.performance');
Route::post('report/performance', [ReportController::class, 'performance'])->name('report.performance.post');
Route::get('report/conversion', [ReportController::class, 'conversion'])->name('report.conversion');
Route::post('report/conversion', [ReportController::class, 'conversion'])->name('report.conversion.post');

Route::get('student/studentAll', [StudentController::class, 'index'])->name('student.index');
Route::get('/student/add', [StudentController::class, 'create'])->name('student.create');
Route::post('student/store', [StudentController::class, 'store'])->name('student.store');
Route::get('student/show/{id}', [StudentController::class, 'show'])->name('student.show');
Route::get('student/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
Route::put('student/update/{id}', [StudentController::class, 'update'])->name('student.update');
// Route::match(array('GET', 'POST'), 'student/show/{id}', [StudentController::class, 'show'])->name('student.show');
Route::delete('/student/delete/{id}', [StudentController::class, 'destroy'])->name('student.delete');
Route::post('/student/status/{id}', [StudentController::class, 'status'])->name('student.status');

Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
Route::post('/account/profile-photo', [AccountController::class, 'updateProfilePhoto'])->name('account.profile-photo');

/*
* Common Routes
*/
Route::get('/common/students', [CommonController::class, 'getStudents'])->name('getStudents');
Route::get('/common/offers', [CommonController::class, 'getOffers'])->name('getOffers');

/*
* Offer Routes
*/

Route::get('/offerAll', [OfferController::class, 'index'])->name('offer.index');
Route::get('/offer/show/{id}', [OfferController::class, 'show'])->name('offer.show');

/*
 * Offer Student Goal Routes
 */
Route::get('/offer/add/{id}/student', [OfferStudentController::class, 'create'])->name('offer.student.create');
Route::post('/offer/store/student', [OfferStudentController::class, 'store'])->name('offer.student.store');
Route::get('/offer/edit/{offerid}/student/{studentid}', [OfferStudentController::class, 'edit'])->name('offer.student.edit');
Route::put('/offer/update/{offerid}/student/{studentid}', [OfferStudentController::class, 'update'])->name('offer.student.update');
Route::delete('/offer/delete/student/{id}', [OfferStudentController::class, 'destroy'])->name('offer.student.destroy');

Route::resource('/student/postbacks', PostbackController::class, ['names' => 'postback']);
Route::get('/student/postbacks/logs/{id}', [PostbackController::class, 'logs'])->name('postback.logs');
/*
 * Offer Click Limit Routes
 */
Route::get('/offer/add/{id}/clicklimit', [ClickLimitController::class, 'create'])->name('offer.clicklimit.create');
Route::post('/offer/store/clicklimit', [ClickLimitController::class, 'store'])->name('offer.clicklimit.store');
Route::get('/offer/edit/{offerid}/clicklimit/{clicklimitid}', [ClickLimitController::class, 'edit'])->name('offer.clicklimit.edit');
Route::put('/offer/update/{offerid}/clicklimit/{clicklimitid}', [ClickLimitController::class, 'update'])->name('offer.clicklimit.update');
Route::delete('/offer/delete/clicklimit/{id}', [ClickLimitController::class, 'destroy'])->name('offer.clicklimit.destroy');
/*
 * Offer Conversion Limit Routes
 */
Route::get('/offer/add/{id}/convlimit', [ConversionLimitController::class, 'create'])->name('offer.convlimit.create');
Route::post('/offer/store/convlimit', [ConversionLimitController::class, 'store'])->name('offer.convlimit.store');
Route::get('/offer/edit/{offerid}/convlimit/{convlimitid}', [ConversionLimitController::class, 'edit'])->name('offer.convlimit.edit');
Route::put('/offer/update/{offerid}/convlimit/{convlimitid}', [ConversionLimitController::class, 'update'])->name('offer.convlimit.update');
Route::delete('/offer/delete/convlimit/{id}', [ConversionLimitController::class, 'destroy'])->name('offer.convlimit.destroy');

/* Import Conversion */
Route::get('/conversionImp', [ImportConversionController::class, 'index'])->name('conversion.index');
Route::post('/conversion/import', [ImportConversionController::class, 'import'])->name('conversion.import');

