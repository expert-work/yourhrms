<?php

use Carbon\Carbon;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\LandingController;
use App\Http\Controllers\ValidationMessageController;
use App\Http\Controllers\Frontend\NavigatorController;
use App\Http\Controllers\Frontend\Auth\LoginController;

Route::get('/initialize', [DevController::class, 'initialization'])->name('initialization');
Route::get('/initialization', [DevController::class, 'initializationProcess'])->name('initialization_process');

Route::get('/storage-link', function () {
    $exitCode = Artisan::call('storage:link');
    return 'storage-linked Successfully';
});

Route::get('/optimize-clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    return 'cleared Successfully';
});

Route::group(['middleware' => 'MaintenanceMode'], function () {
    Route::get('/', [NavigatorController::class, 'index'])->name('home');
    Route::get('/analytics', [NavigatorController::class, 'analytics'])->name('analytics');
    Route::get('/pricing', [NavigatorController::class, 'pricing'])->name('pricing');
    Route::get('/contact', [NavigatorController::class, 'contact'])->name('contact');
    Route::get('/features', [NavigatorController::class, 'features'])->name('features');
    Route::post('/contact', [NavigatorController::class, 'storeContact'])->name('storeContact');
    Route::get('sign-in', [LoginController::class, 'adminLogin'])->name('adminLogin');
});

// Landing Page Route
Route::get('/landing-page', [LandingController::class, 'index'])->name('landingPage');

Auth::routes();
//admin routes here
include_route_files(__DIR__ . '/admin/');

//frontend routes here
    include_route_files(__DIR__ . '/frontend/');



//====================Validation Message Generate===============================
   Route::get('validation-message-generate', function(){
      return view('validation-message-generate');
   })->name('test');
   Route::POST('validation-message-generate',[ValidationMessageController::class,'messageGenerate'])->name('message_generate');
