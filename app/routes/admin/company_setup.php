<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Company\LocationController;
use App\Http\Controllers\coreApp\Setting\IpConfigController;
use App\Http\Controllers\Backend\Company\CompanyConfigController;

Route::group(['prefix' => 'admin/company-setup', 'middleware' => 'admin'], function () {


    //start company setup
    Route::get('/',                               [CompanyConfigController::class, 'index'])->name('company.settings.view')->middleware(['PermissionCheck:company_settings_read', 'MaintenanceMode']);
    Route::post('update',                         [CompanyConfigController::class, 'update'])->name('company.settings.update')->middleware('PermissionCheck:company_settings_update');
    Route::post('currencyInfo',                   [CompanyConfigController::class, 'currencyInfo'])->name('company.settings.currencyInfo')->middleware('PermissionCheck:company_settings_update');
    Route::get('location-api',                    [CompanyConfigController::class, 'locationApi'])->name('company.settings.locationApi')->middleware('PermissionCheck:locationApi');
    Route::post('update-api',                     [CompanyConfigController::class, 'updateApi'])->name('company.settings.updateApi')->middleware('PermissionCheck:locationApi');

    // activation company setup
    Route::get('activation',[CompanyConfigController::class, 'activation'])->name('company.settings.activation')->middleware('PermissionCheck:company_setup_activation');
    // configure ip address
    Route::get('configuration',[CompanyConfigController::class, 'configuration'])->name('company.settings.configuration')->middleware('PermissionCheck:company_setup_configuration');

    //ip whitelist
    Route::group(['prefix' => 'ip-whitelist', 'middleware' => 'MaintenanceMode'], function () {
        Route::get('/',                           [IpConfigController::class, 'index'])->name('ipConfig.index')->middleware('PermissionCheck:ip_read');
        Route::get('/user-wise',                  [IpConfigController::class, 'UserWise'])->name('ipConfig.UserWise')->middleware('PermissionCheck:user_ip_binding');
        Route::get('create',                      [IpConfigController::class, 'create'])->name('ipConfig.create')->middleware('PermissionCheck:ip_create');
        Route::post('store',                      [IpConfigController::class, 'store'])->name('ipConfig.store')->middleware('PermissionCheck:ip_create');
        Route::get('datatable',                   [IpConfigController::class, 'datatable'])->name('ipConfig.datatable')->middleware('PermissionCheck:ip_read');
        Route::get('user-datatable',              [IpConfigController::class, 'userDatatable'])->name('ipConfig.userDatatable')->middleware('PermissionCheck:ip_read');
        Route::get('show/{id}',                   [IpConfigController::class, 'show'])->name('ipConfig.show')->middleware('PermissionCheck:ip_update');
        Route::post('update/{role}',              [IpConfigController::class, 'update'])->name('ipConfig.update')->middleware('PermissionCheck:ip_update');
        Route::get('delete/{role}',               [IpConfigController::class, 'destroy'])->name('ipConfig.destroy')->middleware('PermissionCheck:ip_delete');
    });

    // location
    Route::group(['prefix' => 'location', 'middleware' => 'MaintenanceMode'], function () {
        Route::get('/',                           [LocationController::class, 'location'])->name('company.settings.location')->middleware('PermissionCheck:location_read');
        Route::get('create',                      [LocationController::class, 'locationCreate'])->name('company.settings.locationCreate')->middleware('PermissionCheck:location_create');
        Route::post('store',                      [LocationController::class, 'locationStore'])->name('company.settings.locationStore')->middleware('PermissionCheck:location_create');
        Route::get('datatable',                   [LocationController::class, 'datatable'])->name('company.settings.locationDatatable')->middleware('PermissionCheck:location_read');
        Route::get('edit/{id}',                   [LocationController::class, 'edit'])->name('company.settings.locationEdit')->middleware('PermissionCheck:location_edit');
        Route::post('update/{id}',              [LocationController::class, 'locationUpdate'])->name('company.settings.locationUpdate')->middleware('PermissionCheck:location_update');
        Route::get('delete/{id}',               [LocationController::class, 'locationDestroy'])->name('company.settings.locationDestroy')->middleware('PermissionCheck:location_delete');
        // location picker modal
        Route::get('location-picker',             [LocationController::class, 'locationPicker'])->name('company.settings.locationPicker')->middleware('PermissionCheck:location_create');
    });

});
