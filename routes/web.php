<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ImportConversionController;
use App\Http\Controllers\Admin\IPController;
use App\Http\Controllers\Admin\PreferenceController;
use App\Http\Controllers\Admin\MailRoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\EmployeeController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('admin/sidebar', SidebarController::class);


// Dashboard route (common for all roles)
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

// Reports routes for admin
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/reports/performance', [ReportController::class, 'performance'])->name('reports.performance');
    Route::get('/reports/conversion', [ReportController::class, 'conversion'])->name('reports.conversion');
    Route::get('/reports/conversion-logs', [ReportController::class, 'conversionLogs'])->name('reports.conversionLogs');
    Route::get('/reports/click-logs', [ReportController::class, 'clickLogs'])->name('reports.clickLogs');
});

// Offers routes for admin
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
    Route::get('/offers/manage', [OfferController::class, 'manage'])->name('offers.manage');
    Route::get('/offers/categories', [OfferController::class, 'categories'])->name('offers.categories');
    Route::get('/offers/application', [OfferController::class, 'application'])->name('offers.application');
});

// Student routes
Route::group(['middleware' => ['role:student']], function () {
    Route::get('/students/add', [StudentController::class, 'add'])->name('students.add');
    Route::get('/students/manage', [StudentController::class, 'manage'])->name('students.manage');
    Route::get('/students/postback', [StudentController::class, 'postback'])->name('students.postback');
    Route::get('/students/payment', [StudentController::class, 'payment'])->name('students.payment');
});

// Advertiser routes
Route::group(['middleware' => ['role:advertiser']], function () {
    Route::get('/advertiser/add', [AdvertiserController::class, 'add'])->name('advertiser.add');
    Route::get('/advertiser/manage', [AdvertiserController::class, 'manage'])->name('advertiser.manage');
});

// Employee routes
Route::group(['middleware' => ['role:employee']], function () {
    Route::get('/employee/add', [EmployeeController::class, 'add'])->name('employee.add');
    Route::get('/employee/manage', [EmployeeController::class, 'manage'])->name('employee.manage');
});

// Custom routes
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/custom/import-conversion', [ImportConversionController::class, 'importConversion'])->name('custom.importConversion');
    Route::get('/ip-whitelisting/add', [IpController::class, 'add'])->name('ipWhitelisting.add');
    Route::get('/ip-whitelisting/manage', [IpController::class, 'manage'])->name('ipWhitelisting.manage');
});

// Mail Room route for admin
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/mail-room', [MailRoomController::class, 'index'])->name('mailRoom.index');
});

// Preferences routes for admin
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/preferences/company', [PreferenceController::class, 'company'])->name('preferences.company');
    Route::get('/preferences/email', [PreferenceController::class, 'email'])->name('preferences.email');
    Route::get('/preferences/payment-methods', [PreferenceController::class, 'paymentMethods'])->name('preferences.paymentMethods');
    Route::get('/preferences/signup-questions', [PreferenceController::class, 'signupQuestions'])->name('preferences.signupQuestions');
});

// Send Report route for admin
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/send-report', [ReportController::class, 'send'])->name('send.report');
});

// Signout route for all roles
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');



require __DIR__.'/auth.php';
// Load additional route files

