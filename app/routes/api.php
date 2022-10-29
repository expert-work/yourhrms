<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Visit\VisitController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Backend\Event\EventController;
use App\Http\Controllers\Api\Leave\DailyLeaveController;
use App\Http\Controllers\Backend\Notice\NoticeController;
use App\Http\Controllers\Api\Leave\LeaveRequestController;
use App\Http\Controllers\Api\Report\BreakReportController;
use App\Http\Controllers\Backend\Finance\ExpenseController;
use App\Http\Controllers\Backend\Meeting\MeetingController;
use App\Http\Controllers\Api\Auth\FaceRecognitionController;
use App\Http\Controllers\Api\Employee\AppointmentController;
use App\Http\Controllers\Api\Appreciate\AppreciateController;
use App\Http\Controllers\Api\Attendance\AttendanceController;
use App\Http\Controllers\Api\Core\Settings\SettingController;
use App\Http\Controllers\Backend\Firebase\FirebaseController;
use App\Http\Controllers\Backend\Expense\HrmExpenseController;
use App\Http\Controllers\coreApp\Setting\AppSettingsController;
use App\Http\Controllers\Api\Report\Leave\LeaveReportController;
use App\Http\Controllers\Backend\Support\SupportTicketController;
use App\Http\Controllers\Backend\Expense\ExpenseCategoryController;
use App\Http\Controllers\Api\Core\Settings\ProfileUpdateSettingController;
use App\Http\Controllers\Api\Report\Attendance\AttendanceReportController;
use App\Http\Controllers\LiteApp\FaceRecognition\FaceAttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::get('send-notification',[DevController::class, 'sendNotification']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cc', function () {
    return true;
});


Route::group(['middleware' => ['api', 'cors', 'TimeZone', 'MaintenanceMode'], 'prefix' => 'V10'], function () {
    
    Route::post('login', [AuthController::class, 'login']);
    Route::post('reset-password', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    
    Route::group(['middleware' => ['auth:api', 'cors']], function () {
        Route::post('topicPushNotification', [NoticeController::class, 'topicPushNotification']);

        Route::post('check-token', [AuthController::class, 'checkDeviceToken']);

        Route::group(['prefix' => 'user'], function () {
            Route::post('firebase-token', [FirebaseController::class, 'firebaseToken']);
            Route::post('profile/{slug}', [ProfileController::class, 'profile']);
            Route::get('details/{id}', [ProfileController::class, 'details']);
            Route::post('profile/update/{slug}', [ProfileController::class, 'profileUpdate']);
            Route::post('password-update', [ProfileController::class, 'passwordUpdate']);
            Route::post('avatar-update', [ProfileController::class, 'avatarImageUpdate']);
            Route::get('notification', [ProfileController::class, 'notification']);
            Route::get('read-notification', [ProfileController::class, 'readNotification']);
            Route::get('notification/clear', [ProfileController::class, 'notificationClear']);
            Route::get('search/{keywords?}', [ProfileController::class, 'getUserList']);
            Route::POST('send-notification', [FirebaseController::class, 'SendNotification']);

            //face recognition
            Route::post('face-recognition', [FaceRecognitionController::class, 'faceRecognition']);
            Route::get('get-face-data', [FaceRecognitionController::class, 'getFaceData']);

            Route::post('face-recognition-update', [FaceRecognitionController::class, 'faceRecognitionUpdate']);
            Route::post('face-recognition-delete', [FaceRecognitionController::class, 'faceRecognitionDelete']);

            

            Route::group(['prefix' => 'leave'], function () {
                Route::post('summary', [LeaveRequestController::class, 'leaveSummary']);
                Route::post('available', [LeaveRequestController::class, 'getAvailableLeave']);
                Route::post('list/view', [LeaveRequestController::class, 'leaveListView']);
                Route::post('request', [LeaveRequestController::class, 'store']);
                Route::post('details/{id}', [LeaveRequestController::class, 'leaveDetails']);
                Route::post('request/edit/{id}', [LeaveRequestController::class, 'leaveDetails']);
                Route::post('request/update/{id}', [LeaveRequestController::class, 'update']);
                Route::get('request/cancel/{id}', [LeaveRequestController::class, 'cancelLeaveRequest']);

                Route::group(['prefix' => 'approval'], function () {
                    Route::post('list/view', [LeaveRequestController::class, 'approvalLeaveList']);
                    Route::get('status-change/{id}/{status}', [LeaveRequestController::class, 'approveOrRejectLeaveRequest']);
                });

                //team member leaves
                Route::group(['prefix' => 'team-member'], function () {
                    Route::post('/', [LeaveRequestController::class, 'teamMemberLeaveList']);
                    Route::get('leave-request-approval/{leave_id}/{status_id}', [LeaveRequestController::class, 'statusChange']);
                });

            });
            Route::group(['prefix' => 'attendance'], function () {
                Route::post('break-back/list/view', [AttendanceController::class, 'breakBackListView']);
                Route::post('break-back/{slug}', [AttendanceController::class, 'breakBack']);
                Route::any('break-status', [AttendanceController::class, 'breakBackHistory']);
                Route::post('break-history', [AttendanceController::class, 'breakBackHistory']);
                Route::post('user-break-history', [AttendanceController::class, 'userBreakHistory']);
                Route::post('get-checkin-checkout-status', [AttendanceController::class, 'checkInCheckoutStatus']);
                Route::post('check-in', [AttendanceController::class, 'checkIn']);
                Route::post('live-location-store', [AttendanceController::class, 'liveLocationStore']);
                Route::patch('check-out/{attendance_id}', [AttendanceController::class, 'checkOut']);
                Route::post('late-in-reason/{attendance_id}', [AttendanceController::class, 'lateInOutReason']);
                Route::post('/attendance-from-device', [AttendanceController::class, 'attendanceFromDevice'])->withoutMiddleware('auth:api');
            });


        });


        Route::group(['prefix' => 'app'], function () {
            Route::get('get-all-users/{designation}', [ProfileUpdateSettingController::class, 'getDesignationWiseUsers']);
            Route::get('get-department', [ProfileUpdateSettingController::class, 'getDepartment']);
            Route::get('get-designation', [ProfileUpdateSettingController::class, 'getDesignation']);
            Route::get('get-employment-type', [ProfileUpdateSettingController::class, 'getEmployment']);
            Route::get('get-blood-group', [ProfileUpdateSettingController::class, 'getBloodGroup']);
            Route::post('get-users', [ProfileUpdateSettingController::class, 'getUsers'])->name('getUsers');
            Route::get('base-settings', [AppSettingsController::class, 'baseSettings']);
            Route::get('home-screen', [AppSettingsController::class, 'homeScreen']);
            Route::get('new-teammate', [AppSettingsController::class, 'newTeamMate']);
            Route::get('get-ip-address', [AppSettingsController::class, 'getIpAddress']);
            Route::get('all-contents/{slug}', [AppSettingsController::class, 'allContents']);
        });

        Route::group(['prefix' => 'expense'], function () {
            Route::get('category', [ExpenseCategoryController::class, 'getExpenseCategory']);
            Route::post('list', [HrmExpenseController::class, 'expenseList']);
            Route::get('single-expense/{expense}', [HrmExpenseController::class, 'show']);
            Route::post('add', [HrmExpenseController::class, 'store']);
            Route::post('update/{expense_id}', [HrmExpenseController::class, 'expenseUpdate']);
            Route::delete('delete/{expense}', [HrmExpenseController::class, 'delete']);
            Route::post('show/{expense}', [ExpenseCategoryController::class, 'getExpenseCategory']);
            Route::post('send-claim', [HrmExpenseController::class, 'claimSend']);
            Route::post('claim-history', [HrmExpenseController::class, 'claimHistory']);
            Route::post('claim-details/{id}', [HrmExpenseController::class, 'claimDetails']);
            Route::post('payment-history', [HrmExpenseController::class, 'paymentHistory']);
        });

        Route::group(['prefix' => 'accounts'], function () {
            
            Route::group(['prefix' => 'expense'], function () {
                Route::get('category-list',     [ExpenseController::class, 'CategoryList']);
                Route::post('add',              [ExpenseController::class, 'UserExpenseStore']);
                Route::post('list',             [ExpenseController::class, 'UserExpenseList']);
                Route::get('view/{expense_id}', [ExpenseController::class, 'UserExpenseView']);
            });
        });


        Route::prefix('visit')->group(function () {
            Route::get('/list', [VisitController::class, 'getVisitList']);
            Route::post('/history', [VisitController::class, 'getVisitHistory']);
            Route::post('/create', [VisitController::class, 'createVisit']);
            Route::get('/show/{visit_id}', [VisitController::class, 'getVisitById']);
            Route::post('/update', [VisitController::class, 'updateVisit']);
            Route::post('/image-upload', [VisitController::class, 'uploadImage']);
            Route::get('/images/{visit_id}', [VisitController::class, 'visitImages']);
            Route::get('/remove-image/{visit_id}/{image_id}', [VisitController::class, 'removeVisitImage']);
            Route::post('/change-status', [VisitController::class, 'changeVisitStatus']);
            Route::post('/create-note', [VisitController::class, 'createNote']);
            Route::post('/create-schedule', [VisitController::class, 'createSchedule']);
        });

        Route::prefix('appreciate')->group(function () {
            Route::get('/list', [AppreciateController::class, 'index']);
            Route::post('/create', [AppreciateController::class, 'store']);
        });

        Route::prefix('dashboard')->group(function () {
            Route::get('/statistics', [DashboardController::class, 'statistics']);
        });

        Route::group(['prefix' => 'support-ticket'], function () {
            Route::post('add', [SupportTicketController::class, 'store']);
            Route::post('list', [SupportTicketController::class, 'listView']);
            Route::get('show/{id}', [SupportTicketController::class, 'show']);
        });

        Route::group(['prefix' => 'notice'], function () {
            Route::post('add', [NoticeController::class, 'storeNotice']);
            Route::post('list', [NoticeController::class, 'listView']);
            Route::get('show/{id}', [NoticeController::class, 'show']);
            Route::get('clear', [NoticeController::class, 'clear']);
        });

        Route::prefix('appoinment')->group(function () {
            Route::post('/get-list', [AppointmentController::class, 'index']);
            Route::get('/details/{id}', [AppointmentController::class, 'getDetails']);
            Route::post('/create', [AppointmentController::class, 'store']);
            Route::post('/change-status', [AppointmentController::class, 'appoinmentChangeStatus']);
            Route::post('/update', [AppointmentController::class, 'update']);
            Route::get('/delete', [AppointmentController::class, 'delete']);
        });

        Route::prefix('upcoming-events')->group(function () {
            Route::post('/get-list', [EventController::class, 'index']);
        });

        Route::group(['prefix' => 'meeting'], function () {
            Route::post('/', [MeetingController::class, 'meetingList']);
            Route::post('create', [MeetingController::class, 'store']);
            Route::get('show/{meeting_id}', [MeetingController::class, 'show']);
            Route::post('add/participants', [MeetingController::class, 'addParticipants']);
            Route::get('participants/{meeting_id}', [MeetingController::class, 'participants']);
        });

        Route::group(['prefix' => 'report'], function () {
            //Attendance Report
            Route::group(['prefix' => 'attendance'], function () {
                Route::post('particular-month/{user}', [AttendanceReportController::class, 'userMonthlyAttendanceReport']);
                Route::post('particular-date', [AttendanceReportController::class, 'userDailyAttendanceReport']);
                Route::post('date-summary', [AttendanceReportController::class, 'dateSummary'])->middleware('PermissionCheck:attendance_report_read');
                Route::post('summary-to-list', [AttendanceReportController::class, 'summaryToList'])->middleware('PermissionCheck:attendance_report_read');
            });
            //Break Route group
            Route::group(['prefix' => 'break'], function () {
                Route::post('date-summary', [BreakReportController::class, 'dateSummary'])->middleware('PermissionCheck:attendance_report_read');
                Route::post('user-break-history', [BreakReportController::class, 'userBreakHistory'])->middleware('PermissionCheck:attendance_report_read');
            });
            //Leave Route group
            Route::group(['prefix' => 'leave'], function () {
                Route::post('date-summary', [LeaveReportController::class, 'dateSummary']);
                Route::post('date-wise-leave', [LeaveReportController::class, 'dateSummaryList'])->middleware('PermissionCheck:leave_request_read');
                Route::post('user-wise-list', [LeaveReportController::class, 'dateUserLeaveList'])->middleware('PermissionCheck:leave_request_read');
            });

        });

        Route::prefix('daily-leave')->group(function () {
            Route::post('/leave-list', [DailyLeaveController::class, 'monthlySummeryView'])->name('daily-leave.monthlySummeryView');
            // Route::any('/list', [DailyLeaveController::class, 'staffListView'])->name('daily-leave.list');
            Route::post('/store', [DailyLeaveController::class, 'store'])->name('daily-leave.store');
            Route::any('/list', [DailyLeaveController::class, 'listView'])->name('daily-leave.list');
            Route::post('/staff-list-view', [DailyLeaveController::class, 'staffListView'])->name('daily-leave.staffListView');
            Route::post('/approve-reject', [DailyLeaveController::class, 'approveRejectLeave'])->name('daily-leave.approveReject');
            Route::post('/single-view', [DailyLeaveController::class, 'LeaveView'])->name('daily-leave.LeaveView');

        });
        
    });

    Route::prefix('fr')->group(function () {
        Route::controller(FaceAttendanceController::class)->group(function () {
            Route::post('/pin-verify', 'verifyPin')->name('verifyPin');
        });

        Route::group(['middleware' => ['auth:api', 'cors'],'prefix' => 'attendance'], function () {
            Route::post('/check-distance', [FaceAttendanceController::class, 'distanceCheck']);
            Route::post('/check-in', [FaceAttendanceController::class, 'checkIn']);
            Route::post('/check-out', [FaceAttendanceController::class, 'checkOut']);
        });
    });
});
