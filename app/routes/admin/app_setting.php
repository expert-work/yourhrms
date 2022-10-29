<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\coreApp\Setting\IpConfigController;
use App\Http\Controllers\coreApp\Setting\SettingsController;
use App\Http\Controllers\Frontend\Contact\ContactController;
use App\Http\Controllers\coreApp\Setting\AppSettingsController;
use App\Http\Controllers\Frontend\Content\AllContentController;
use App\Http\Controllers\Backend\Company\CompanyConfigController;
use App\Http\Controllers\coreApp\Setting\LanguageSettingController;

Route::group(['prefix' => 'admin/settings', 'middleware' => ['admin']], function () {
    //start settings
    Route::get('list',                            [SettingsController::class, 'index'])->name('manage.settings.view')->middleware('PermissionCheck:general_settings_read');
    Route::post('update',                         [SettingsController::class, 'update'])->name('manage.settings.update')->middleware('PermissionCheck:general_settings_update');
    //Email Setting
    Route::post('/email-setup',                   [SettingsController::class, 'emailSetup'])->name('manage.settings.update.email')->middleware('PermissionCheck:email_settings_update');
    Route::post('/storage-setup',                 [SettingsController::class, 'storageSetup'])->name('manage.settings.update.storage')->middleware('PermissionCheck:storage_settings_update');
    //leave setting
    Route::any('leave',                           [SettingsController::class, 'leaveSettings'])->name('leaveSettings.view')->middleware('PermissionCheck:leave_settings_read');
    Route::any('leave/edit',                      [SettingsController::class, 'leaveSettingsEdit'])->name('leaveSettings.edit')->middleware('PermissionCheck:leave_settings_update');
    Route::patch('leave/update',                  [SettingsController::class, 'leaveSettingsUpdate'])->name('leaveSettings.update')->middleware('PermissionCheck:leave_settings_update');

    //Language Settings
    Route::group(['prefix' => 'language-setup'], function () {
    Route::get('/',                       [LanguageSettingController::class, 'language'])->name('language.index');
    Route::get('/dataTable',              [LanguageSettingController::class, 'dataTable'])->name('dataTable.language');
    Route::post('/add',                   [LanguageSettingController::class, 'store'])->name('language.add');
    Route::get('/setup/{language}',       [LanguageSettingController::class, 'setup'])->name('language.setup');
    Route::post('/get-translate-file',    [LanguageSettingController::class, 'get_translate_file'])->name('language.get_translate_file');
    Route::post('/update-lang-term',      [LanguageSettingController::class, 'updateLangTerm'])->name('language.updateLangTerm');
    Route::get('/make-default/{language}',[LanguageSettingController::class, 'makeDefault'])->name('language.makeDefault');
    Route::get('/delete/{language}',      [LanguageSettingController::class, 'deleteLang'])->name('language.deleteLang');

    });

    //superadmin routes
    Route::group(['middleware'=>'SuperAdminMiddleware'], function () {

        Route::group(['prefix' => 'content'], function () {
            Route::get('/list',                   [AllContentController::class, 'list'])->name('content.list');
            Route::get('data-table',              [AllContentController::class, 'dataTable'])->name('dataTable.content');
            Route::get('/create',                 [AllContentController::class, 'create'])->name('content.create');
            Route::any('edit/{allContent}',       [AllContentController::class, 'edit'])->name('content.edit')->middleware('PermissionCheck:content_update');
            Route::patch('update/{allContent}',   [AllContentController::class, 'update'])->name('content.update')->middleware('PermissionCheck:content_update');
            Route::get('delete/{allContent}',     [AllContentController::class, 'delete'])->name('content.delete');
        });
        //Contact
        Route::group(['prefix' => 'contact'], function () {
            Route::get('/',                       [ContactController::class, 'index'])->name('contact.index');
            Route::get('/dataTable',              [ContactController::class, 'dataTable'])->name('dataTable.contact');

        });

        // App setting
        Route::group(['prefix' => 'app-setting'], function () {
            Route::any('/dashboard',              [AppSettingsController::class, 'appScreenSetup'])->name('appScreenSetup');
            Route::post('/update-icon',           [AppSettingsController::class, 'updateIcon'])->name('appSettingsIcon');
            Route::post('/update-title',          [AppSettingsController::class, 'updateTitle'])->name('appSettingsTitle');
            Route::post('/setup-status',          [AppSettingsController::class, 'appScreenSetupUpdate'])->name('appScreenSetupUpdate');
        });
        
        Route::get('/artisan/{command}',          [AppSettingsController::class, 'artisanCommand'])->name('artisanCommand');
       
    });
});
Route::group(['prefix' => 'company/settings', 'middleware' => 'admin'], function () {
    //start company settings
    Route::get('/',                               [CompanyConfigController::class, 'index'])->name('company.settings.view')->middleware(['PermissionCheck:company_settings_read','MaintenanceMode']);
    Route::post('update',                         [CompanyConfigController::class, 'update'])->name('company.settings.update')->middleware('PermissionCheck:company_settings_update');
    Route::post('currencyInfo',                   [CompanyConfigController::class, 'currencyInfo'])->name('company.settings.currencyInfo')->middleware('PermissionCheck:company_settings_update');
    Route::get('location-api',                    [CompanyConfigController::class, 'locationApi'])->name('company.settings.locationApi')->middleware('PermissionCheck:locationApi');
    Route::post('update-api',                     [CompanyConfigController::class, 'updateApi'])->name('company.settings.updateApi')->middleware('PermissionCheck:locationApi');


});
