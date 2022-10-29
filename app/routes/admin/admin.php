<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\Sms\SmsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Team\TeamController;
use App\Http\Controllers\Accounts\SubscriptionController;
use App\Http\Controllers\Backend\Notice\NoticeController;
use App\Http\Controllers\Backend\Company\CompanyController;
use App\Http\Controllers\Backend\Payroll\AdvanceController;
use App\Http\Controllers\coreApp\Setting\SettingsController;
use App\Http\Controllers\Backend\CustomUi\CustomUiController;
use App\Http\Controllers\Backend\Database\DatabaseController;
use App\Http\Controllers\Backend\Filter\SearchFilterController;
use App\Http\Controllers\Backend\Attendance\AttendanceController;
use App\Http\Controllers\Backend\Superadmin\SuperadminController;
use App\Http\Controllers\coreApp\Setting\LanguageSettingController;
use App\Http\Controllers\Backend\VirtualMeeting\VirtualMeetingController;
use App\Http\Controllers\Api\Core\Settings\ProfileUpdateSettingController;


Route::group(['middleware' => ['admin', 'TimeZone'], 'prefix' => 'dashboard'], function () {
    Route::any('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('profileWiseDashboard', [DashboardController::class, 'profileWiseDashboard'])->name('dashboard.profileWiseDashboard');
    Route::get('logout', [DashboardController::class, 'logout'])->name('dashboard.logout');
    Route::any('profile/info', [UserController::class, 'profile'])->name('admin.profile_info')->middleware('MaintenanceMode');
    Route::post('profile/update', [UserController::class, 'updateProfile'])->name('admin.profile_update')->middleware('MaintenanceMode');
    // check in ajax
    // Route::get('ajax-checkin', [AttendanceController::class, 'dashboardAjaxCheckin'])->name('admin.ajaxDashboardCheckin')->middleware('MaintenanceMode');
    // Route::get('ajax-checkout', [AttendanceController::class, 'ajaxDashboardCheckOut'])->name('admin.ajaxDashboardCheckOut')->middleware('MaintenanceMode');
    // // check in ajax
    Route::get('checkin', [AttendanceController::class, 'dashboardCheckin'])->name('admin.dashboardCheckin')->middleware('MaintenanceMode');
    Route::get('checkout', [AttendanceController::class, 'dashboardCheckOut'])->name('admin.dashboardCheckOut')->middleware('MaintenanceMode');
    Route::get('break-back/{slug}', [AttendanceController::class, 'dashboardBreakBack'])->name('admin.dashboardBreakBack')->middleware('MaintenanceMode');
    Route::post('break-start', [AttendanceController::class, 'dashboardBreakStart'])->name('admin.dashboardBreakStart')->middleware('MaintenanceMode');
    //pie chart methods current-month-pie-chart
    Route::get('current-month-pie-chart', [DashboardController::class, 'currentMonthPieChart'])->middleware('MaintenanceMode');
    //Get user information
    Route::post('user-search', [SearchFilterController::class, 'searchFilter'])->name('user.search');

    //Change User Lang
    Route::post('/ajax-lang-change',      [LanguageSettingController::class, 'ajaxLangChange'])->name('language.ajaxLangChange');

    // user list
    Route::group(['prefix' => 'user'], function () {
        Route::get('/',                             [UserController::class, 'index'])->name('user.index')->middleware('PermissionCheck:user_read');
        Route::get('create',                        [UserController::class, 'create'])->name('user.create')->middleware('PermissionCheck:user_create');
        Route::post('store',                        [UserController::class, 'store'])->name('user.store')->middleware('PermissionCheck:user_create');
        Route::get('show/{id}',                     [UserController::class, 'show'])->name('user.show')->middleware('PermissionCheck:user_read');
        Route::get('show/{user}/{slug}',            [UserController::class, 'profileView'])->name('user.profile')->middleware('PermissionCheck:user_read');
        Route::get('edit/{user}/{slug}',            [UserController::class, 'profileEditView'])->name('user.edit.profile')->middleware('PermissionCheck:user_read');
        // salary set up
        Route::get('setup/{user}/{slug}',           [UserController::class, 'profileSetUp'])->name('user.edit.profile_setup')->middleware('PermissionCheck:view_payroll_set');
        // salary set up
        Route::post('update/{user}/{slug}',         [UserController::class, 'profileUpdate'])->name('user.update.profile')->middleware('PermissionCheck:user_update');
        Route::get('edit/{user}',                   [UserController::class, 'edit'])->name('user.edit')->middleware('PermissionCheck:user_update');
        Route::patch('update/{user}',               [UserController::class, 'update'])->name('user.update')->middleware('PermissionCheck:user_update');
        Route::get('data-table',                    [UserController::class, 'data_table'])->name('user.data_table')->middleware('PermissionCheck:user_read');
        Route::get('delete/{user}',                 [UserController::class, 'delete'])->name('user.delete')->middleware('PermissionCheck:user_delete');
        Route::get('change-status/{user}/{status}', [UserController::class, 'changeStatus'])->name('user.changeStatus')->middleware('PermissionCheck:user_update');
        Route::get('{id}/support', [UserController::class, 'support'])->name('user.support');
        Route::any('{id}/attendance', [UserController::class, 'attendance'])->name('user.attendance');
        Route::get('{id}/expense', [UserController::class, 'expense'])->name('user.expense');
        Route::get('supportTickets', [UserController::class, 'supportTicketsDataTable'])->name('user.supportTickets');
        Route::get('attendanceTable/{id}', [UserController::class, 'attendanceListDataTable'])->name('user.attendanceTable');
        Route::post('get-users', [UserController::class, 'getUsers'])->name('user.getUser')->middleware('PermissionCheck:user_read');
        Route::post('get-all-user-by-dep-des', [ProfileUpdateSettingController::class, 'getDesignationWiseUsers'])->name('user.getByDeptDesWiseUsers');
        Route::post('update-user-pin',[UserController::class, 'updateUserPin'])->name('updateUserPin');
        Route::get('update-user-ip',[UserController::class, 'updateUserIp'])->name('updateUserIp');
        //Leave
        Route::get('{id}/leave-request', [UserController::class, 'leaveRequest'])->name('user.leaveRequest');
        Route::get('{id}/leave-request-approved', [UserController::class, 'leaveRequestApproved'])->name('user.leaveRequestApproved');

        //make hr
        Route::get('make-hr/{user_id}', [UserController::class, 'makeHR'])->name('user.make_hr');

        //Notice
        Route::get('{id}/notice', [UserController::class, 'notice'])->name('user.notice');
        Route::get('notice-datatable', [UserController::class, 'noticeDatatable'])->name('user.noticeDatatable');
        Route::get('notice/clear', [UserController::class, 'clearNotice'])->name('user.clearNotice');
        //Phonebook
        Route::get('{id}/phonebook', [UserController::class, 'phonebook'])->name('user.phonebook');
        Route::get('phonebook-datatable', [UserController::class, 'phonebookDatatable'])->name('user.phonebookDatatable');

        //start auth user profile 
        Route::get('profile/{type}',                 [UserController::class, 'profile'])->name('staff.profile');
        Route::get('edit-profile/{type}',            [UserController::class, 'staffProfileEditView'])->name('staff.staffProfileEditView');
        Route::get('/{type}',                        [UserController::class, 'staffInfo'])->name('staff.profile.info');
        Route::get('/profile/{user_id}/{type}',      [UserController::class, 'userInfo'])->name('userProfile.info');
        Route::get('datatable/{user_id}/{type}',     [UserController::class, 'userDataTable'])->name('user.profileDataTable');

        // data table for user profile
        Route::group(['prefix' => 'auth-user'], function () {
            Route::get('datatable/{type}', [UserController::class, 'authUserDataTable'])->name('staff.authUserTable');
        });
        //end auth user profile 

        //Appointment
        Route::get('{id}/appointment', [UserController::class, 'appointment'])->name('user.appointment');

        Route::get('{id}/advance-loan', [AdvanceController::class, 'advanceLoan'])->name('user.advanceLoan');
    });
    // End user list


    //company routes start
    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', [CompanyController::class, 'index'])->name('company.index')->middleware('PermissionCheck:company_read');
        Route::get('create', [CompanyController::class, 'create'])->name('company.create')->middleware('PermissionCheck:company_create');
        Route::post('store', [CompanyController::class, 'store'])->name('company.store')->middleware('PermissionCheck:company_create');
        Route::get('data-table', [CompanyController::class, 'dataTable'])->name('company.dataTable')->middleware('PermissionCheck:company_read');
        Route::get('show/{company}', [CompanyController::class, 'show'])->name('company.show')->middleware('PermissionCheck:company_update');
        Route::patch('update/{company}', [CompanyController::class, 'update'])->name('company.update')->middleware('PermissionCheck:company_update');
        Route::get('delete/{company}', [CompanyController::class, 'delete'])->name('company.delete')->middleware('PermissionCheck:company_delete');
        Route::get('change-status/{company}/{status}', [CompanyController::class, 'changeStatus'])->name('company.changeStatus')->middleware('PermissionCheck:company_update');
    });
    //company routes end

    //subscriptions routes start
    Route::group(['prefix' => 'subscriptions'], function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index')->middleware('PermissionCheck:subscriptions_read');
        Route::get('create', [CompanyController::class, 'create'])->name('company.create')->middleware('PermissionCheck:company_create');
        Route::post('store', [CompanyController::class, 'store'])->name('company.store')->middleware('PermissionCheck:company_create');
        Route::get('data-table', [CompanyController::class, 'dataTable'])->name('company.dataTable')->middleware('PermissionCheck:company_read');
        Route::get('show/{company}', [CompanyController::class, 'show'])->name('company.show')->middleware('PermissionCheck:company_update');
        Route::patch('update/{company}', [CompanyController::class, 'update'])->name('company.update')->middleware('PermissionCheck:company_update');
        Route::get('delete/{company}', [CompanyController::class, 'delete'])->name('company.delete')->middleware('PermissionCheck:company_delete');
        Route::get('change-status/{company}/{status}', [CompanyController::class, 'changeStatus'])->name('company.changeStatus')->middleware('PermissionCheck:company_update');
    });
    //company routes end

    // Teams
    Route::group(['prefix' => 'teams', 'middleware' => ['MaintenanceMode']], function () {
        Route::get('/', [TeamController::class, 'index'])->name('team.index');
        Route::get('create', [TeamController::class, 'create'])->name('team.create')->middleware('PermissionCheck:team_create');
        Route::post('store', [TeamController::class, 'store'])->name('team.store')->middleware('PermissionCheck:team_create');
        Route::get('data-table', [TeamController::class, 'dataTable'])->name('team.dataTable');
        Route::get('show/{team}', [TeamController::class, 'show'])->name('team.show')->middleware('PermissionCheck:team_update');
        Route::patch('update/{team}', [TeamController::class, 'update'])->name('team.update')->middleware('PermissionCheck:team_update');
        Route::get('delete/{team}', [TeamController::class, 'delete'])->name('team.delete')->middleware('PermissionCheck:team_delete');
        Route::get('change-status/{team}/{status}', [TeamController::class, 'changeStatus'])->name('team.changeStatus')->middleware('PermissionCheck:team_update');

        Route::get('leave/list', [TeamController::class, 'leaveList'])->name('team.leave.list')->middleware('PermissionCheck:team_update');
        Route::get('leave-datatable', [TeamController::class, 'leaveDatatable'])->name('team_member_leave_datatable')->middleware('PermissionCheck:team_update');
    });

    // Announcement routes
    Route::group(['prefix' => 'announcement', 'middleware' => ['MaintenanceMode']], function () {
        Route::group(['prefix' => 'notice'], function () {
            Route::get('/', [NoticeController::class, 'index'])->name('notice.index')->middleware('PermissionCheck:notice_list');
            Route::get('show/{id}', [NoticeController::class, 'show'])->name('notice.show')->middleware('PermissionCheck:notice_update');
            Route::get('dataTable', [NoticeController::class, 'dataTable'])->name('notice.dataTable');
            Route::get('create', [NoticeController::class, 'create'])->name('notice.create')->middleware('PermissionCheck:notice_create');
            Route::post('store', [NoticeController::class, 'store'])->name('notice.store')->middleware('PermissionCheck:notice_create');
            Route::get('edit/{notice}', [NoticeController::class, 'edit'])->name('notice.edit')->middleware('PermissionCheck:notice_update');
            Route::patch('update/{notice}', [NoticeController::class, 'update'])->name('notice.update')->middleware('PermissionCheck:notice_update');
            Route::get('delete/{notice}', [NoticeController::class, 'delete'])->name('notice.delete')->middleware('PermissionCheck:notice_delete');
            Route::get('push-notification', [NoticeController::class, 'pushNotification'])->name('notice.pushNotification')->middleware('PermissionCheck:pushNotification');
            Route::post('push-notification', [NoticeController::class, 'sendPushNotification'])->name('notice.sendPushNotification')->middleware('PermissionCheck:pushNotification');
        });
        Route::group(['prefix' => 'sms', 'middleware' => ['MaintenanceMode']], function () {
            Route::get('/', [SmsController::class, 'index'])->name('sms.index')->middleware('PermissionCheck:send_sms_list');
            Route::get('show/{id}', [SmsController::class, 'show'])->name('sms.show')->middleware('PermissionCheck:send_sms_update');
            Route::get('dataTable', [SmsController::class, 'dataTable'])->name('sms.dataTable');
            Route::get('create', [SmsController::class, 'create'])->name('sms.create')->middleware('PermissionCheck:send_sms_create');
            Route::post('store', [SmsController::class, 'store'])->name('sms.store')->middleware('PermissionCheck:send_sms_create');
            Route::get('edit/{sms}', [SmsController::class, 'edit'])->name('sms.edit')->middleware('PermissionCheck:send_sms_update');
            Route::patch('update/{sms}', [SmsController::class, 'update'])->name('sms.update')->middleware('PermissionCheck:send_sms_update');
            Route::get('delete/{sms}', [SmsController::class, 'delete'])->name('notice.delete')->middleware('PermissionCheck:send_sms_delete');
        });
    });
    //Virtual Meeting routes
    Route::controller(VirtualMeetingController::class)->prefix('virtual-meeting')->middleware('MaintenanceMode')->group(function () {
        Route::get('/', 'index')                ->name('virtual_meeting.index');
        Route::get('/setup', 'setup')           ->name('virtual_meeting.setup');
        Route::get('/datatable', 'datatable')   ->name('virtual_meeting.datatable');
        Route::get('create', 'create')          ->name('virtual_meeting.create');
        Route::post('store', 'store')           ->name('virtual_meeting.store');
        Route::get('edit/{id}', 'edit')         ->name('virtual_meeting.edit');
        Route::post('update/{id}', 'update')    ->name('virtual_meeting.update');
        Route::get('delete/{id}', 'delete')     ->name('virtual_meeting.delete');
        Route::get('show/{id}', 'show')         ->name('virtual_meeting.show');
     });
     
     Route::get('permission-update', [SettingsController::class, 'permissionUpdate'])->name('permission.update')->middleware('PermissionCheck:company_settings_update');
     Route::get('/ajax/change-status', [SettingsController::class, 'chengeStatus'])->name('ajax.chengeStatus');
});
Route::get('/custom-ui',                            [CustomUiController::class, 'index'])->name('custom_ui.index');
Route::get('assets/download/{id}',                  [AssetsController::class, 'download'])->name('assets.download');

Route::get('assets/download/{id}', [AssetsController::class, 'download'])->name('assets.download')->middleware('MaintenanceMode');


Route::group(['prefix' => 'database'], function () {
    // Database Backup=
    Route::get('export', [DatabaseController::class, 'export'])->name('database.export');
    Route::get('backup/download/{id}', [DatabaseController::class, 'download'])->name('database.download');
    Route::get('destroy/{id}', [DatabaseController::class, 'destroy'])->name('database.destroy');
});
