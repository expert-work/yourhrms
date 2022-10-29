<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Visit\Visit;
use App\Enums\AttendanceStatus;
use App\Models\Company\Company;
use App\Models\Hrm\Meeting\Meeting;
use App\Models\Hrm\Task\EmployeeTask;
use App\Models\Accounts\IncomeExpense;
use App\Models\Hrm\Attendance\Holiday;
use App\Models\Hrm\Attendance\Weekend;
use App\Models\Hrm\Leave\LeaveRequest;
use App\Models\Expenses\PaymentHistory;
use App\Models\Hrm\AppSetting\AppScreen;
use App\Models\Hrm\Appoinment\Appoinment;
use App\Models\Hrm\Attendance\Attendance;
use App\Models\Hrm\Support\SupportTicket;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Report\AttendanceReportRepository;
use App\Repositories\Hrm\Attendance\AttendanceRepository;

class DashboardRepository
{

    use ApiReturnFormatTrait, DateHandler, RelationshipTrait, TimeDurationTrait;

    protected $attendanceReportRepository;
    protected $attendance;
    protected $attendanceRepository;

    public function __construct(AttendanceReportRepository $attendanceReportRepository, Attendance $attendance, AttendanceRepository $attendanceRepository)
    {
        $this->attendanceReportRepository = $attendanceReportRepository;
        $this->attendance = $attendance;
        $this->attendanceRepository = $attendanceRepository;
    }

    public function getIncomeExpenseGraph($request)
    {
        if (!empty($request->time)) {
            $year = $request->time;
        } else {
            $year = date("Y");
        }
        $months = [];
        $income = [];
        $expense = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = date("m", mktime(0, 0, 0, $i, 1, $year));
            $total_income = IncomeExpense::where('type', 1)->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('amount');
            $total_expense = IncomeExpense::where('type', 2)->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('amount');
            if (empty($total_income)) {
                $total_income = 0;
            }
            $months[] = date('M', strtotime($i . '-' . $month . '-' . $year));
            $income[] = $total_income;
            $expense[] = $total_expense;

        }
        $data['label'] = $months;
        $data['income'] = $income;
        $data['expense'] = $expense;

        return $data;


    }

    public function getStatisticsImage($level)
    {
        $app_dashboard = config()->get('hrm.dashboard_images');
        return $app_dashboard[$level]['path'];
    }

    public function getDashboardStatistics($request)
    {
        try {

            $date = date('Y-m-d');
            $time = explode('-', $date);
            $year = $time[0];
            $month = $time[1];
            // $date = $time[2];

            $screen_data=  AppScreen::where('status_id', 1)->pluck('slug')->toArray();
            if (in_array('appointments', $screen_data)) {
                $data['today'][] = [
                    'image' => asset($this->getStatisticsImage('appoinment')),
                    'title' => 'Appointments',
                    'slug' => 'appointment',
                    'number' => Appoinment::where('date',$date)
                                ->where(function($query){
                                    $query->where('created_by', auth()->user()->id)
                                    ->orWhere('appoinment_with', auth()->user()->id);
                                })
                                ->count(),
                ];
            }
            if (in_array('meeting', $screen_data)) {
                $data['today'][] = [
                    'image' => asset($this->getStatisticsImage('meeting')),
                    'title' => 'Meetings',
                    'slug' => 'meeting',
                    'number' => Meeting::where('date',$date)->where('user_id', auth()->user()->id)->count(),
                ];
            }
            if (in_array('visit', $screen_data)) {
                $data['today'][] = [
                    'image' => asset($this->getStatisticsImage('visit')),
                    'title' => 'Visit',
                    'slug' => 'visit',
                    'number' => Visit::where('date',$date)->where('user_id', auth()->user()->id)->count(),
                ];
            }
            // $data['today'][] = [
            //     'image' => asset($this->getStatisticsImage('task')),
            //     'title' => 'Tasks',
            //     'slug' => 'task',
            //     'number' => EmployeeTask::where('created_at', 'LIKE', '%' . $date . '%')->where('assigned_id', auth()->user()->id)->count(),
            // ];
            if (in_array('support', $screen_data)) {
                $data['today'][] = [
                    'image' => asset($this->getStatisticsImage('support')),
                    'title' => 'Support Tickets',
                    'slug' => 'support_ticket',
                    'number' => SupportTicket::where('date',$date)
                        ->where(function ($query) {
                            $query->where('assigned_id',auth()->user()->id)
                            ->orWhere('user_id',auth()->user()->id);
                        })
                        ->where('status_id', 1)
                        ->where('type_id', 12)
                        ->count(),
                ];
            }
            //Current Month
            $request['month'] = null;
            $attendance_data = $this->attendanceReportRepository->singleAttendanceSummary(auth()->user(), $request);

            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('late')),
                'title' => 'Late In',
                'slug' => 'late_in',
                'number' => str_replace(' days', '', $attendance_data['total_late_in']),
            ];
            if (in_array('leave', $screen_data)) {
                $data['current_month'][] = [
                    'image' => asset($this->getStatisticsImage('leave')),
                    'title' => 'Leave',
                    'slug' => 'leave',
                    'number' => str_replace(' days', '', $attendance_data['total_leave']),
                ];
            }
            if (in_array('daily-leave', $screen_data)) {
                $data['current_month'][] = [
                    'image' => asset($this->getStatisticsImage('early-leave')),
                    'title' => 'Early Leave',
                    'slug' => 'early_leave',
                    'number' => str_replace(' days', '', $attendance_data['total_left_early']),
                ];
            }
            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('absent')),
                'title' => 'Absent',
                'slug' => 'absent',
                'number' => str_replace(' days', '', $attendance_data['absent']),
            ];
            if (in_array('visit', $screen_data)) {

                $data['current_month'][] = [
                    'image' => asset($this->getStatisticsImage('visit')),
                    'title' => 'Visits',
                    'slug' => 'visits',
                    'number' => Visit::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                        ->where('user_id', auth()->user()->id)
                        ->count(),
                ];
            }

            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('rewards')),
                'title' => 'Rewards',
                'slug' => 'rewards',
                'number' => "0"
            ];

            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getSuperadminDashboardStatistic($request)
    {
        try {

            $date = date('Y-m');

            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('employee')),
                'title' => 'Total Company',
                'slug' => 'total_company',
                'number' => Company::where('id','!=',1)->count(),
            ];

            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }

    }

    public function getCompanyDashboardStatistics($request)
    {
        try {

            $date = date('Y-m-d');
            $time = explode('-', $date);
            $year = $time[0];
            $month = $time[1];
            // $date = $time[2];



            // $data['today'][] = [
            //     'image' => asset($this->getStatisticsImage('appoinment')),
            //     'title' => 'Appointments',
            //     'number' => Appoinment::where('created_at', 'LIKE', '%' . $date . '%')->count(),
            // ];
            $data['today'][] = [
                'image' => asset($this->getStatisticsImage('employee')),
                'title' => 'Total Employees',
                'number' => number_format(User::where('company_id', auth()->user()->company->id)->count()),
            ];
            $data['today'][] = [
                'image' => asset($this->getStatisticsImage('expense')),
                'title' => 'Total Expenses',
                'number' => number_format(PaymentHistory::where('company_id', auth()->user()->company->id)->count()),
            ];
            $data['today'][] = [
                'image' => asset($this->getStatisticsImage('meeting')),
                'title' => 'Total Meetings',
                'number' => number_format(Meeting::where('company_id', auth()->user()->company->id)->count()),
            ];
            // $data['today'][] = [
            //     'image' => asset($this->getStatisticsImage('visit')),
            //     'title' => 'Total Visit',
            //     'number' => Visit::where('date', 'LIKE', '%' . $date . '%')->count(),
            // ];
            // $data['today'][] = [
            //     'image' => asset($this->getStatisticsImage('birthday')),
            //     'title' => 'Birthday',
            //     'number' => User::where('birth_date', 'LIKE', '%' . $month . '-' . $date . '%')->where('company_id',auth()->user()->company_id)->count(),
            // ];
            // $data['today'][] = [
            //     'image' => asset($this->getStatisticsImage('task')),
            //     'title' => 'Tasks',
            //     'number' => EmployeeTask::where('created_at', 'LIKE', '%' . $date . '%')->where('assigned_id', auth()->user()->id)->count(),
            // ];
            $data['today'][] = [
                'image' => asset($this->getStatisticsImage('support')),
                'title' => 'Support Tickets',
                'number' => number_format(SupportTicket::where('status_id', 1)
                    ->where('company_id', auth()->user()->company->id)
                    ->count()),
            ];

             //Current Month
             $request['month'] = null;
             $attendance_data = $this->attendanceReportRepository->monthlyAttendanceSummary(auth()->user(), $request);

             $data['current_month'][] = [
                 'image' => asset($this->getStatisticsImage('late')),
                 'title' => 'Late In',
                 'slug' => 'late_in',
                 'number' => str_replace(' days', '', $attendance_data['total_late_in']),
             ];
             $data['current_month'][] = [
                 'image' => asset($this->getStatisticsImage('leave')),
                 'title' => 'Leave',
                 'slug' => 'leave',
                 'number' => str_replace(' days', '', $attendance_data['total_leave']),
             ];
             $data['current_month'][] = [
                 'image' => asset($this->getStatisticsImage('early-leave')),
                 'title' => 'Early Leave',
                 'slug' => 'early_leave',
                 'number' => str_replace(' days', '', $attendance_data['total_left_early']),
             ];
             $data['current_month'][] = [
                 'image' => asset($this->getStatisticsImage('absent')),
                 'title' => 'Absent',
                 'slug' => 'absent',
                 'number' => str_replace(' days', '', $attendance_data['absent']),
             ];
             $data['current_month'][] = [
                 'image' => asset($this->getStatisticsImage('visit')),
                 'title' => 'Visits',
                 'slug' => 'visits',
                 'number' => Visit::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                     ->where('user_id', auth()->user()->id)
                     ->count(),
             ];

             $data['current_month'][] = [
                 'image' => asset($this->getStatisticsImage('rewards')),
                 'title' => 'Rewards',
                 'slug' => 'rewards',
                 'number' => "0"
             ];


            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
    public function getCompanyDashboardCurrentMonthStatistics($request)
    {
        try {

            $date = date('Y-m-d');
            $time = explode('-', $date);
            $year = $time[0];
            $month = $time[1];
            $date = $time[2];



            //Current Month
            $request['month'] = null;
            $attendance_data = $this->attendanceReportRepository->companyAttendanceSummary(auth()->user(), $request);
            $data['all_data'][]=[
                'data'=>$attendance_data,
            ];
            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('late')),
                'title' => 'Late In',
                'number' => str_replace(' days', '', $attendance_data['total_late_in']),
            ];
            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('leave')),
                'title' => 'Leave',
                'number' => str_replace(' days', '', $attendance_data['total_leave']),
            ];
            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('early-leave')),
                'title' => 'Early Leave',
                'number' => str_replace(' days', '', $attendance_data['total_left_early']),
            ];
            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('absent')),
                'title' => 'Absent',
                'number' => str_replace(' days', '', $attendance_data['absent']),
            ];
            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('visit')),
                'title' => 'Visits',
                'number' => Visit::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                    ->count(),
            ];

            $data['current_month'][] = [
                'image' => asset($this->getStatisticsImage('rewards')),
                'title' => 'Rewards',
                'number' => "0"
            ];

            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }


    public function currentMonthPieChart($request)
    {
        $data = [];
        $totalPresent = 0;
        $totalAbsent = 0;
        $totalLeave = 0;
        $totalOnTimeIn = 0;
        $totalLateIn = 0;
        $totalLeftTimely = 0;
        $totalLeftEarly = 0;
        if ($request->month) {
            $monthArray = $this->getSelectedMonthDays($request->month);
        } else {
            $monthArray = $this->getCurrentMonthDays();
        }

        foreach ($monthArray as $day) {

            $todayDateInSqlFormat = $day->format('Y-m-d');
            $leaveDate = LeaveRequest::where(['company_id' => $this->companyInformation()->id, 'user_id' => auth()->id(), 'status_id' => 1])
                ->where('leave_from', '<=', $todayDateInSqlFormat)
                ->where('leave_to', '>=', $todayDateInSqlFormat)
                ->first();

            if ($leaveDate) {
                $totalLeave += 1;
            }
            $attendance = $this->attendance->query()->where(['user_id' => auth()->id(), 'date' => $todayDateInSqlFormat])->first();
            if ($attendance) {
                $totalPresent += 1;
                if ($attendance->in_status == AttendanceStatus::ON_TIME) {
                    $totalOnTimeIn += 1;
                } elseif ($attendance->in_status == AttendanceStatus::LATE) {
                    $totalLateIn += 1;
                } else {
                    $totalOnTimeIn += 1;
                }

                if ($attendance->check_out) {
                    if ($attendance->out_status == AttendanceStatus::LEFT_TIMELY || $attendance->out_status == AttendanceStatus::LEFT_LATER) {
                        $totalLeftTimely += 1;
                    } elseif ($attendance->out_status == AttendanceStatus::LEFT_EARLY) {
                        $totalLeftEarly += 1;
                    } else {
                        $totalLeftTimely += 1;
                    }
                }

            } else {
                $totalAbsent += 1;
            }
        }

        $data['leave early'] = $totalLeftEarly;
        $data['on time'] = $totalOnTimeIn;
        $data['late'] = $totalLateIn;
        $data['leave'] = $totalLeave;
        $chartArray =[];
        foreach ($data as $key => $item) {
            if ($key === 'leave early') {
                $chartArray['series'][] = $item;
                $chartArray['labels'][] = $key;
            }
            if ($key === 'leave') {
                $chartArray['series'][] = $item;
                $chartArray['labels'][] = $key;

            }
            if ($key === 'late') {
                $chartArray['series'][] = $item;
                $chartArray['labels'][] = $key;

            }
            if ($key === 'on time') {
                $chartArray['series'][] = $item;
                $chartArray['labels'][] = $key;
            }
        }
        return $this->responseWithSuccess('Pie chart', $chartArray, 200);
    }
}
