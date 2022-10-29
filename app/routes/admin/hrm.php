<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\Visit\VisitController;
use App\Http\Controllers\Backend\Leave\LeaveTypeController;
use App\Http\Controllers\Backend\Support\SupportController;
use App\Http\Controllers\Backend\Attendance\ShiftController;
use App\Http\Controllers\Backend\Attendance\QrCodeController;
use App\Http\Controllers\Backend\Leave\AssignLeaveController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Backend\Attendance\HolidayController;
use App\Http\Controllers\Backend\Expense\HrmExpenseController;
use App\Http\Controllers\Backend\Leave\LeaveRequestController;
use App\Http\Controllers\Backend\Report\BreakReportController;
use App\Http\Controllers\Backend\Attendance\WeekendsController;
use App\Http\Controllers\Backend\Employee\AppointmentController;
use App\Http\Controllers\Backend\Attendance\AttendanceController;
use App\Http\Controllers\Backend\Department\DepartmentController;
use App\Http\Controllers\Backend\Attendance\DutyScheduleController;
use App\Http\Controllers\Backend\Designation\DesignationController;
use App\Http\Controllers\Backend\Report\AttendanceReportController;

Route::group(['prefix' => 'hrm', 'middleware' => ['admin','MaintenanceMode']], function () {
    Route::group(['prefix' => 'leave'], function () {
        //leave type routes start
        Route::get('/',                           [LeaveTypeController::class, 'index'])->name('leave.index')->middleware('PermissionCheck:leave_type_read');
        Route::get('data-table',                  [LeaveTypeController::class, 'dataTable'])->name('leave.dataTable')->middleware('PermissionCheck:leave_type_read');
        Route::get('create',                      [LeaveTypeController::class, 'create'])->name('leave.create')->middleware('PermissionCheck:leave_type_create');
        Route::post('store',                      [LeaveTypeController::class, 'store'])->name('leave.store')->middleware('PermissionCheck:leave_type_create');
        Route::get('show/{leaveType}',            [LeaveTypeController::class, 'show'])->name('leave.show')->middleware('PermissionCheck:leave_type_read');
        Route::get('edit/{leaveType}',            [LeaveTypeController::class, 'edit'])->name('leave.edit')->middleware('PermissionCheck:leave_type_update');
        Route::patch('update/{leaveType}',        [LeaveTypeController::class, 'update'])->name('leave.update')->middleware('PermissionCheck:leave_type_update');
        Route::get('delete/{leaveType}',          [LeaveTypeController::class, 'delete'])->name('leave.delete')->middleware('PermissionCheck:leave_type_delete');
        //leave type routes end

        //assign leave routes start
        Route::group(['prefix' => 'assign'], function () {
            Route::get('/',                       [AssignLeaveController::class, 'index'])->name('assignLeave.index')->middleware('PermissionCheck:leave_assign_read');
            Route::get('create',                  [AssignLeaveController::class, 'create'])->name('assignLeave.create')->middleware('PermissionCheck:leave_assign_create');
            Route::post('store',                  [AssignLeaveController::class, 'store'])->name('assignLeave.store')->middleware('PermissionCheck:leave_assign_create');
            Route::get('show/{assignLeave}',      [AssignLeaveController::class, 'show'])->name('assignLeave.show')->middleware('PermissionCheck:leave_assign_read');
            Route::get('edit/{assignLeave}',      [AssignLeaveController::class, 'edit'])->name('assignLeave.edit')->middleware('PermissionCheck:leave_assign_update');
            Route::patch('update/{assignLeave}',  [AssignLeaveController::class, 'update'])->name('assignLeave.update')->middleware('PermissionCheck:leave_assign_update');
            Route::get('data-table',              [AssignLeaveController::class, 'dataTable'])->name('assignLeave.dataTable')->middleware('PermissionCheck:leave_assign_read');
            Route::get('delete/{assignLeave}',    [AssignLeaveController::class, 'delete'])->name('assignLeave.delete')->middleware('PermissionCheck:leave_assign_delete');
            //assign leave routes end
        });

        //apply for leave routes start
        Route::group(['prefix' => 'request'], function () {
            Route::get('/',                       [LeaveRequestController::class, 'index'])->name('leaveRequest.index')->middleware('PermissionCheck:leave_request_read');
            Route::get('create',                  [LeaveRequestController::class, 'create'])->name('leaveRequest.create');
            Route::post('store',                  [LeaveRequestController::class, 'store'])->name('leaveRequest.store');
            Route::patch('update',                [LeaveRequestController::class, 'update'])->name('leaveRequest.update');
            Route::get('data-table',              [LeaveRequestController::class, 'dataTable'])->name('leaveRequest.dataTable')->middleware('PermissionCheck:leave_request_read');
            Route::get('profile-data-table',      [LeaveRequestController::class, 'profileDataTable'])->name('leaveRequest.profileDataTable')->middleware('PermissionCheck:leave_request_read');
            Route::get('show/{leaveRequest}',     [LeaveRequestController::class, 'show'])->name('leaveRequest.show')->middleware('PermissionCheck:leave_request_read');
            Route::get('view/{leaveRequest}',     [LeaveRequestController::class, 'pdfView'])->name('leaveRequest.view')->middleware('PermissionCheck:leave_request_read');
            Route::get('delete/{leaveRequest}',   [LeaveRequestController::class, 'delete'])->name('leaveRequest.delete')->middleware('PermissionCheck:leave_request_delete');
            Route::get('approve-or-reject/{leaveRequest}/{status_id}', [LeaveRequestController::class, 'requestApproveOrReject'])->name('leaveRequest.approveOrReject')->middleware('PermissionCheck:leave_request_approve');
            //assign leave routes end
        });
    });

    //weekend setup start
    Route::group(['prefix' => 'weekend/setup'], function () {
        Route::get('/',                          [WeekendsController::class, 'index'])->name('weekendSetup.index')->middleware('PermissionCheck:weekend_read');
        Route::get('show/{weekend}',             [WeekendsController::class, 'show'])->name('weekendSetup.show')->middleware('PermissionCheck:weekend_read');
        Route::patch('update',                   [WeekendsController::class, 'update'])->name('weekendSetup.update')->middleware('PermissionCheck:weekend_update');
    });
    //weekend setup end

    //holiday setup start
    Route::group(['prefix' => 'holiday/setup'], function () {
        Route::get('/',                         [HolidayController::class, 'index'])->name('holidaySetup.index')->middleware('PermissionCheck:holiday_read');
        Route::get('/create',                   [HolidayController::class, 'create'])->name('holidaySetup.create')->middleware('PermissionCheck:holiday_create');
        Route::post('store',                    [HolidayController::class, 'store'])->name('holidaySetup.store')->middleware('PermissionCheck:holiday_create');
        Route::get('show/{holiday}',            [HolidayController::class, 'show'])->name('holidaySetup.show')->middleware('PermissionCheck:holiday_update');
        Route::patch('update/{holiday}',        [HolidayController::class, 'update'])->name('holidaySetup.update')->middleware('PermissionCheck:holiday_update');
        Route::get('delete/{holiday_id}',       [HolidayController::class, 'delete'])->name('holidaySetup.delete')->middleware('PermissionCheck:holiday_delete');
    });
    //holiday setup end

    //duty schedule start
    Route::group(['prefix' => 'duty/schedule'], function () {
        Route::get('/',                        [DutyScheduleController::class, 'index'])->name('dutySchedule.index')->middleware('PermissionCheck:schedule_read');
        Route::get('create',                   [DutyScheduleController::class, 'create'])->name('dutySchedule.create')->middleware('PermissionCheck:schedule_create');
        Route::post('store',                   [DutyScheduleController::class, 'store'])->name('dutySchedule.store')->middleware('PermissionCheck:schedule_create');
        Route::get('show/{schedule}',          [DutyScheduleController::class, 'show'])->name('dutySchedule.show')->middleware('PermissionCheck:schedule_update');
        Route::patch('update/{schedule}',      [DutyScheduleController::class, 'update'])->name('dutySchedule.update')->middleware('PermissionCheck:schedule_update');
        Route::get('delete/{schedule}',        [DutyScheduleController::class, 'delete'])->name('dutySchedule.delete')->middleware('PermissionCheck:schedule_delete');
        Route::get('list-data',                [DutyScheduleController::class, 'dutyScheduleDataTable'])->name('dutySchedule.dataTable');
    });
    //duty schedule end

    //attendance start
    Route::group(['prefix' => 'attendance'], function () {
        Route::get('/',                          [AttendanceController::class, 'index'])->name('attendance.index')->middleware('PermissionCheck:attendance_read');
        Route::get('add',                        [AttendanceController::class, 'checkIn'])->name('attendance.check-in')->middleware('PermissionCheck:attendance_create');
        Route::get('edit/check-in/{attendance}', [AttendanceController::class, 'checkInEdit'])->name('attendance.checkInEdit')->middleware('PermissionCheck:attendance_update');

        Route::get('check-out/{attendance_id}',  [AttendanceController::class, 'checkOut'])->name('attendance.checkout')->middleware('PermissionCheck:attendance_update');
        Route::post('store',                     [AttendanceController::class, 'store'])->name('attendance.store')->middleware('PermissionCheck:attendance_create');
        Route::get('edit/{attendance_id}',       [AttendanceController::class, 'show'])->name('attendance.edit')->middleware('PermissionCheck:attendance_update');
        Route::patch('update/{attendance_id}',   [AttendanceController::class, 'update'])->name('attendance.update')->middleware('PermissionCheck:attendance_update');
        Route::get('delete/{attendance_id}',     [AttendanceController::class, 'delete'])->name('attendance.delete')->middleware('PermissionCheck:attendance_delete');
    });
    //attendance end

    //designation start
    Route::group(['prefix' => 'designation'], function () {
        Route::get('/',                         [DesignationController::class, 'index'])->name('designation.index')->middleware('PermissionCheck:designation_read');
        Route::get('create',                    [DesignationController::class, 'create'])->name('designation.create')->middleware('PermissionCheck:designation_create');
        Route::get('data-table',                [DesignationController::class, 'dataTable'])->name('designation.dataTable')->middleware('PermissionCheck:designation_read');
        Route::post('store',                    [DesignationController::class, 'store'])->name('designation.store')->middleware('PermissionCheck:designation_create');
        Route::get('show/{designation}',        [DesignationController::class, 'show'])->name('designation.show')->middleware('PermissionCheck:designation_read');
        Route::get('edit/{designation}',        [DesignationController::class, 'edit'])->name('designation.edit')->middleware('PermissionCheck:designation_update');
        Route::patch('update/{designation}',    [DesignationController::class, 'update'])->name('designation.update')->middleware('PermissionCheck:designation_update');
        Route::get('delete/{designation}',      [DesignationController::class, 'delete'])->name('designation.delete')->middleware('PermissionCheck:designation_delete');
    });
    //designation end

    //shift start
      Route::group(['prefix' => 'shift'], function () {
        Route::get('/',                         [ShiftController::class, 'index'])->name('shift.index')->middleware('PermissionCheck:shift_read');
        Route::get('create',                    [ShiftController::class, 'create'])->name('shift.create')->middleware('PermissionCheck:shift_create');
        Route::get('data-table',                [ShiftController::class, 'dataTable'])->name('shift.dataTable')->middleware('PermissionCheck:shift_read');
        Route::post('store',                    [ShiftController::class, 'store'])->name('shift.store')->middleware('PermissionCheck:shift_create');
        Route::get('show/{shift}',        [ShiftController::class, 'show'])->name('shift.show')->middleware('PermissionCheck:shift_read');
        Route::get('edit/{shift}',        [ShiftController::class, 'edit'])->name('shift.edit')->middleware('PermissionCheck:shift_update');
        Route::patch('update/{shift}',    [ShiftController::class, 'update'])->name('shift.update')->middleware('PermissionCheck:shift_update');
        Route::get('delete/{shift}',      [ShiftController::class, 'delete'])->name('shift.delete')->middleware('PermissionCheck:shift_delete');
    });

    //QR code route
    Route::controller(QrCodeController::class)->prefix('qr-code')->group(function(){
        Route::any('/', 'qrCode')->name('hrm.qr.index')->middleware('PermissionCheck:generate_qr_code');
    });

    //shift end

    //department start
    Route::group(['prefix' => 'department'], function () {
        Route::get('/',                        [DepartmentController::class, 'index'])->name('department.index')->middleware('PermissionCheck:department_read');
        Route::get('create',                   [DepartmentController::class, 'create'])->name('department.create')->middleware('PermissionCheck:department_create');
        Route::get('data-table',               [DepartmentController::class, 'dataTable'])->name('department.dataTable')->middleware('PermissionCheck:department_read');
        Route::post('store',                   [DepartmentController::class, 'store'])->name('department.store')->middleware('PermissionCheck:department_create');
        Route::get('show/{department}',        [DepartmentController::class, 'show'])->name('department.show')->middleware('PermissionCheck:department_read');
        Route::get('edit/{department}',        [DepartmentController::class, 'edit'])->name('department.edit')->middleware('PermissionCheck:department_update');
        Route::patch('update/{department}',    [DepartmentController::class, 'update'])->name('department.update')->middleware('PermissionCheck:department_update');
        Route::get('delete/{department}',      [DepartmentController::class, 'delete'])->name('department.delete')->middleware('PermissionCheck:department_delete');
    });
    //department end

    //roles start
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/',                        [RoleController::class, 'index'])->name('roles.index')->middleware('PermissionCheck:role_read');
        Route::get('create',                   [RoleController::class, 'create'])->name('roles.create')->middleware('PermissionCheck:role_create');
        Route::post('store',                   [RoleController::class, 'store'])->name('roles.store')->middleware('PermissionCheck:role_create');
        Route::get('show/{role}',              [RoleController::class, 'show'])->name('roles.show')->middleware('PermissionCheck:role_read');
        Route::get('edit/{role}',              [RoleController::class, 'edit'])->name('roles.edit')->middleware('PermissionCheck:role_update');
        Route::patch('update/{role}',          [RoleController::class, 'update'])->name('roles.update')->middleware('PermissionCheck:role_update');
        Route::get('delete/{role}',            [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('PermissionCheck:role_delete');
        Route::get('data-table',               [RoleController::class, 'dataTable'])->name('roles.dataTable')->middleware('PermissionCheck:role_read');
        Route::post('change-role',             [RoleController::class, 'changeRole'])->name('roles.change')->middleware('PermissionCheck:role_update');
    });
    //roles end

    //expense start
    Route::group(['prefix' => 'expense'], function () {
        Route::get('/',                                    [HrmExpenseController::class, 'index'])->name('expense.index')->middleware('PermissionCheck:expense_read');
        Route::get('edit/{expense}',                       [HrmExpenseController::class, 'show'])->name('expense.edit')->middleware('PermissionCheck:expense_update');
        Route::get('approve-or-reject/{expense}/{status}', [HrmExpenseController::class, 'approveOrReject'])->name('expense.approveOrReject')->middleware('PermissionCheck:expense_approve_or_reject');
        Route::get('data-table',                           [HrmExpenseController::class, 'expenseDatatable'])->name('expense.dataTable')->middleware('PermissionCheck:expense_read');
        //expense end

        //claim start
        Route::group(['prefix' => 'claim'], function () {
            Route::get('/',                                    [HrmExpenseController::class, 'claimIndex'])->name('claim.index')->middleware('PermissionCheck:claim_read');
            Route::get('edit/{expense}',                       [HrmExpenseController::class, 'show'])->name('claim.edit')->middleware('PermissionCheck:claim_update');
            Route::get('get-payment-info/{expenseClaim}',      [HrmExpenseController::class, 'showExpenseClaim'])->name('expenseClaim.show');
            Route::post('claim-amount-payment/{expenseClaim}', [HrmExpenseController::class, 'claimAmountPay'])->name('claim.amount.pay');
            Route::post('get-payment-info',                    [HrmExpenseController::class, 'showExpenseClaim'])->name('claim.payNow');
            Route::get('data-table',                           [HrmExpenseController::class, 'claimDatatable'])->name('claim.dataTable');
        });
        //claim end

        //payment start
        Route::group(['prefix' => 'payment'], function () {
            Route::get('/',                                   [HrmExpenseController::class, 'index'])->name('payment.index')->middleware('PermissionCheck:payment_read');
            Route::get('edit/{expense}',                      [HrmExpenseController::class, 'show'])->name('payment.edit')->middleware('PermissionCheck:payment_update');
            Route::get('data-table',                          [HrmExpenseController::class, 'expenseDatatable'])->name('payment.dataTable')->middleware('PermissionCheck:payment_read');
        });
        //payment start
    });

     //appointment start
     Route::group(['prefix' => 'appointment'], function () {
        Route::get('/',                                      [AppointmentController::class, 'list'])->name('appointment.index');
        Route::get('create',                                 [AppointmentController::class, 'create'])->name('appointment.create');
        Route::get('edit/{appointment_id}',                  [AppointmentController::class, 'edit'])->name('appointment.edit');
        Route::post('store',                                 [AppointmentController::class, 'store'])->name('appointment.store');
        Route::post('update',                               [AppointmentController::class, 'update'])->name('appointment.update');
        Route::get('data-table',                             [AppointmentController::class, 'dataTable'])->name('appointment.dataTable');
        Route::get('profile-data-table',                     [AppointmentController::class, 'profileDataTable'])->name('appointment.profileDataTable');
        Route::get('show/{appointment}',                     [AppointmentController::class, 'show'])->name('appointment.show')->middleware('PermissionCheck:appointment_read');
        Route::get('view/{appointment}',                     [AppointmentController::class, 'pdfView'])->name('appointment.view')->middleware('PermissionCheck:appointment_read');
        Route::get('delete/{appointment}',                   [AppointmentController::class, 'delete'])->name('appointment.delete')->middleware('PermissionCheck:appointment_delete');
     //appointment request
    });

    //report start
    Route::group(['prefix' => 'report'], function () {
        Route::get('attendance',                               [AttendanceReportController::class, 'index'])->name('attendanceReport.index')->middleware('PermissionCheck:attendance_report_read');
        // attendance details start
        Route::get('check-in-details',                         [AttendanceReportController::class, 'checkInDetails'])->name('attendance.checkInDetails')->middleware('PermissionCheck:attendance_update');
        // attendance details end
        // Start live tracking
        Route::get('live-tracking',                            [AttendanceReportController::class, 'liveTracking'])->name('live_trackingReport.index')->middleware('PermissionCheck:attendance_report_read');
        Route::get('live-tracking-employee',                   [AttendanceReportController::class, 'liveTrackingEmployee'])->name('live_trackingReportEmployee.index')->middleware('PermissionCheck:attendance_report_read');
        Route::get('location-history',                         [AttendanceReportController::class, 'locationHistory'])->name('live_trackingReportHistory.index')->middleware('PermissionCheck:attendance_report_read');
        Route::get('employee-location-history',                [AttendanceReportController::class, 'employeeLocationHistory'])->name('locationReportHistory.index')->middleware('PermissionCheck:attendance_report_read');
        //End live tracking
        Route::get('attendance-history/{user}',                [AttendanceReportController::class, 'employeeAttendanceHistory'])->name('employeeAttendance');
        Route::get('list-data',                                [AttendanceReportController::class, 'reportDataTable'])->name('attendanceReport.dataTable');
        Route::get('single-attendance-list-data/{user}',       [AttendanceReportController::class, 'singleReportDataTable'])->name('singleAttendanceReport.dataTable');
        Route::post('single-attendance-summary-report/{user}', [AttendanceReportController::class, 'singleAttendanceSummaryReport'])->name('singleAttendanceSummaryReport');
    });
    //report end

    //break start
    Route::group(['prefix' => 'break'], function () {
        Route::get('list',                                     [BreakReportController::class, 'index'])->name('breakReport.index')->middleware('PermissionCheck:attendance_report_read');
        Route::get('data-table',                               [BreakReportController::class, 'dataTable'])->name('breakReport.dataTable')->middleware('PermissionCheck:attendance_report_read');
    });
    //break end

    //support routes start
    Route::group(['prefix' => 'support'], function () {
        Route::get('ticket/list',                              [SupportController::class, 'index'])->name('supportTicket.index')->middleware('PermissionCheck:support_read');
        Route::get('ticket/create',                            [SupportController::class, 'create'])->name('supportTicket.create')->middleware('PermissionCheck:support_create');
        Route::post('ticket/store',                            [SupportController::class, 'store'])->name('supportTicket.store')->middleware('PermissionCheck:support_create');
        Route::get('user/ticket',                              [SupportController::class, 'staffTicket'])->name('user.supportTicket')->middleware('PermissionCheck:support_read');
        Route::get('ticket/reply/{ticket}/{code}',             [SupportController::class, 'ticketReply'])->name('supportTicket.reply')->middleware('PermissionCheck:support_read');
        Route::post('ticket/reply/{ticket}',                   [SupportController::class, 'ticketReplyStore'])->name('supportTicket.reply.store')->middleware('PermissionCheck:support_read');
        Route::get('data-table',                               [SupportController::class, 'dataTable'])->name('supportTicket.dataTable')->middleware('PermissionCheck:support_read');
        Route::get('data-table/{id}',                          [SupportController::class, 'userTicketDatatable'])->name('user.supportTicket.dataTable')->middleware('PermissionCheck:support_read');
        Route::get('ticket/delete/{id}',                       [SupportController::class, 'delete'])->name('supportTicket.delete')->middleware('PermissionCheck:support_delete');
    });
    //support routes end

    //Visit start
    Route::group(['prefix' => 'user'], function () {
        //Visit
        Route::get('{id}/visit',                               [VisitController::class, 'visit'])->name('visit.user');
        Route::get('{id}/visit-history',                       [VisitController::class, 'visitHistory'])->name('visit.history');
        Route::get('visit-datatable/{user_id}',                [VisitController::class, 'visitDatatable'])->name('user.visit.dataTable');
        Route::get('visit-history-datatable',                  [VisitController::class, 'visitHistoryDatatable'])->name('visit.history.dataTable');
        Route::get('visit-details/{id}',                       [VisitController::class, 'visitDetails'])->name('visit.details');
    });

    Route::group(['prefix' => 'visit'], function () {
        Route::get('/',                                        [VisitController::class, 'index'])->name('visit.index');
    });
    //Visit end

    //expense start
    Route::group(['prefix' => 'notification'], function () {
        Route::get('/',                                        [NotificationController::class, 'index'])->name('notification.index');
        Route::post('read',                                    [NotificationController::class, 'readNotification'])->name('notification.readNotification');
    });

});
