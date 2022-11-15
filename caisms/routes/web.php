<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Vehicle Segment-master
Route::get('admin/vehicle-segment', [App\Http\Controllers\HomeController::class, 'vehiclesegmentmasterPage'])->name('admin.vehicle-segment');
Route::post('allvehiclesegmentMaster', [App\Http\Controllers\HomeController::class, 'allvehiclesegmentMaster'] )->name('allvehiclesegmentMaster');
Route::post('addvehiclesegmentMaster', [App\Http\Controllers\HomeController::class, 'addvehiclesegmentMaster'])->name('addvehiclesegmentMaster');
Route::post('activatedvehicleMaster', [App\Http\Controllers\HomeController::class, 'activatedvehicleMaster'])->name('activatedvehicleMaster');


// Branch
Route::get('admin/branch', [App\Http\Controllers\HomeController::class, 'branchmasterPage'])->name('admin.branch');
Route::post('allbranchMaster', [App\Http\Controllers\HomeController::class, 'allbranchMaster'] )->name('allbranchMaster');
Route::post('addbranchMaster', [App\Http\Controllers\HomeController::class, 'addbranchMaster'])->name('addbranchMaster');
Route::post('activatedbranchMaster', [App\Http\Controllers\HomeController::class, 'activatedbranchMaster'])->name('activatedbranchMaster');

// desigination
Route::get('admin/desigination', [App\Http\Controllers\HomeController::class, 'desiginationmasterPage'])->name('admin.desigination');
Route::post('alldesiginationMaster', [App\Http\Controllers\HomeController::class, 'alldesiginationMaster'] )->name('alldesiginationMaster');
Route::post('adddesiginationMaster', [App\Http\Controllers\HomeController::class, 'adddesiginationMaster'])->name('adddesiginationMaster');
Route::post('activateddesiginationMaster', [App\Http\Controllers\HomeController::class, 'activateddesiginationMaster'])->name('activateddesiginationMaster');

// Employee
Route::get('admin/employee', [App\Http\Controllers\HomeController::class, 'employeemasterPage'])->name('admin.employee');
Route::post('allemployeeMaster', [App\Http\Controllers\HomeController::class, 'allemployeeMaster'] )->name('allemployeeMaster');
Route::post('addemployeeMaster', [App\Http\Controllers\HomeController::class, 'addemployeeMaster'])->name('addemployeeMaster');
Route::post('activatedemployeeMaster', [App\Http\Controllers\HomeController::class, 'activatedemployeeMaster'])->name('activatedemployeeMaster');

// Model
Route::get('admin/model', [App\Http\Controllers\HomeController::class, 'modelmasterPage'])->name('admin.model');
Route::post('allmodelMaster', [App\Http\Controllers\HomeController::class, 'allmodelMaster'] )->name('allmodelMaster');
Route::post('addmodelMaster', [App\Http\Controllers\HomeController::class, 'addmodelMaster'])->name('addmodelMaster');
Route::post('activatedmodelMaster', [App\Http\Controllers\HomeController::class, 'activatedmodelMaster'])->name('activatedmodelMaster');

// Varient
Route::get('admin/varient', [App\Http\Controllers\HomeController::class, 'varientmasterPage'])->name('admin.varient');
Route::post('allvarientMaster', [App\Http\Controllers\HomeController::class, 'allvarientMaster'] )->name('allvarientMaster');
Route::post('addvarientMaster', [App\Http\Controllers\HomeController::class, 'addvarientMaster'])->name('addvarientMaster');
Route::post('activatedvarientMaster', [App\Http\Controllers\HomeController::class, 'activatedvarientMaster'])->name('activatedvarientMaster');

// place
Route::get('admin/place', [App\Http\Controllers\HomeController::class, 'placemasterPage'])->name('admin.place');
Route::post('allplaceMaster', [App\Http\Controllers\HomeController::class, 'allplaceMaster'] )->name('allplaceMaster');
Route::post('addplaceMaster', [App\Http\Controllers\HomeController::class, 'addplaceMaster'])->name('addplaceMaster');
Route::post('activatedplaceMaster', [App\Http\Controllers\HomeController::class, 'activatedplaceMaster'])->name('activatedplaceMaster');

//welcome form
Route::get('admin/welcome', [App\Http\Controllers\HomeController::class, 'welcomePage'])->name('admin.welcome');
Route::post('addcustomer', [App\Http\Controllers\HomeController::class, 'addcustomer'] )->name('addcustomer');
//thank you list
Route::get('admin/thankyou', [App\Http\Controllers\HomeController::class, 'thankyouPage'])->name('admin.thankyou');
Route::post('allthankyou', [App\Http\Controllers\HomeController::class, 'allthankyou'] )->name('allthankyou');
//sendthank you
Route::get('admin/sendthankyou/{id}', [App\Http\Controllers\HomeController::class, 'sendthankyou'])->name('admin.sendthankyou');
Route::post('updatecustomer', [App\Http\Controllers\HomeController::class, 'updatecustomer'] )->name('updatecustomer');

//welcome sms report
Route::get('admin/welcome-report', [App\Http\Controllers\HomeController::class, 'WelcomeReport'])->name('admin.welcome-report');
Route::post('allwelcomesent', [App\Http\Controllers\HomeController::class, 'allwelcomesent'] )->name('allwelcomesent');
Route::post('searchwelcome', [App\Http\Controllers\HomeController::class, 'searchwelcome'] )->name('searchwelcome');
//thank you sent list
Route::get('admin/thankyou-report', [App\Http\Controllers\HomeController::class, 'ThankyouReport'])->name('admin.thankyou-report');
Route::post('allthankyousent', [App\Http\Controllers\HomeController::class, 'allthankyousent'] )->name('allthankyousent');
//thank you pending report
Route::get('admin/thankyou-pending-report', [App\Http\Controllers\HomeController::class, 'ThankyouPendingReport'])->name('admin.thankyou-pending-report');
Route::post('allthankyoupending', [App\Http\Controllers\HomeController::class, 'allthankyoupending'] )->name('allthankyoupending');

//get varient
Route::post('getvarient', [App\Http\Controllers\HomeController::class, 'getvarient'] )->name('getvarient');

//admin reset password
Route::get('admin/reset', [App\Http\Controllers\HomeController::class, 'ResetpasswordPage'])->name('admin.reset');
Route::post('resetpassword', [App\Http\Controllers\HomeController::class, 'UpdatepasswordPage'])->name('resetpassword');

Route::post('changepassword', [App\Http\Controllers\HomeController::class, 'changepassword'])->name('changepassword');

//admin sms campaign
Route::get('admin/smscampaign', [App\Http\Controllers\HomeController::class, 'SMSCampaign'])->name('admin.smscampaign');
Route::post('sendbulksms', [App\Http\Controllers\HomeController::class, 'sendbulksms'])->name('sendbulksms');
