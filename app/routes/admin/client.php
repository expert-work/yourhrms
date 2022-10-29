<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Client\ClientController;

Route::group(['middleware' => ['admin', 'TimeZone'], 'prefix' => 'admin/client'], function () {

    // Projects route
    Route::controller(ClientController::class)->group(function () {
        Route::any('/', 'index')->name('client.index')->middleware('PermissionCheck:client_list');
        Route::get('/datatable', 'datatable')->name('client.datatable')->middleware('PermissionCheck:client_list');
        Route::get('create', 'create')->name('client.create')->middleware('PermissionCheck:client_create');
        Route::post('store', 'store')->name('client.store')->middleware('PermissionCheck:client_store');
        Route::get('edit/{id}', 'edit')->name('client.edit')->middleware('PermissionCheck:client_edit');
        Route::post('update', 'update')->name('client.update')->middleware('PermissionCheck:client_update');
        Route::get('delete/{id}', 'delete')->name('client.delete')->middleware('PermissionCheck:client_delete');
        Route::get('show/{id}', 'show')->name('client.show')->middleware('PermissionCheck:client_view');
    });


});