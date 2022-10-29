<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Repositories\DashboardRepository;
use App\Repositories\Hrm\Expense\HrmExpenseRepository;
use App\Repositories\Hrm\Attendance\AttendanceRepository;


class DashboardController extends Controller
{
    protected $dashboardRepository;
    protected $attendanceRepo;
    protected $expenseRepo;

    public function __construct(DashboardRepository $dashboardRepository, AttendanceRepository $attendanceRepo, HrmExpenseRepository $expenseRepo)
    {
        $this->dashboardRepository = $dashboardRepository;
        $this->attendanceRepo = $attendanceRepo;
        $this->expenseRepo = $expenseRepo;
    }

    public function loadMyProfileDashboard($request)
    {
        try {
            $request['month'] = date('Y-m');

            $menus = $this->dashboardRepository->getDashboardStatistics($request);
            $data['dashboardMenus'] = @$menus->original['data'];
            // $companyMenus = $this->dashboardRepository->getCompanyDashboardStatistics($request);
            // $data['companyMenus'] = @$companyMenus->original['data'];
            return $returnHTML = view('backend.dashboard.loadProfileDashboard', compact('data'))->render();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function loadCompanyDashboard($request)
    {
        try {
            $request['month'] = date('Y-m');

            $menus = $this->dashboardRepository->getCompanyDashboardStatistics($request);
            $data['dashboardMenus'] = @$menus->original['data'];
            // $companyMenus = $this->dashboardRepository->getCompanyDashboardStatistics($request);
            // $data['companyMenus'] = @$companyMenus->original['data'];
            return $returnHTML = view('backend.dashboard.loadCompanyDashboard', compact('data'))->render();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function loadSuperadminDashboard($request)
    {
        try {
            $request['month'] = date('Y-m');
            $menus = $this->dashboardRepository->getDashboardStatistics($request);
            $data['dashboardMenus'] = @$menus->original['data'];
            $companyMenus = $this->dashboardRepository->getCompanyDashboardStatistics($request);
            $data['companyMenus'] = @$companyMenus->original['data'];
            return $returnHTML = view('backend.dashboard.loadSuperadminDashboard', compact('data'))->render();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function profileWiseDashboard(Request $request)
    {
        $user = Auth::user();
        $dashboardType = $request->dashboardType;
        $dashboard = '';
        $date=date('Y-m-d');
        switch ($dashboardType) {
            //myProfile
            //companyDashboard
            //superadminDashboard
            case 'My Dashboard':
                $dashboard = $this->loadMyProfileDashboard($request);
                $data['dashboardType'] = 'Dashboard';
                break;
            case 'Company Dashboard':
                $dashboard = $this->loadCompanyDashboard($request);
                $data['dashboardType'] = 'Dashboard';
                $data['expense'] = $this->expenseRepo->getMonthlyExpense($request);
                $data['attendance_summary'] = $this->attendanceRepo->getTodayAttendance($date);
                break;
            case 'Superadmin Dashboard':
                $dashboard = $this->loadSuperadminDashboard($request);
                $data['dashboardType'] = 'Super Admin';
                break;
        }
        $data['dashboard'] = $dashboard;
        $data['status'] = 'success';
        $data['message'] = 'Dashboard loaded successfully';
        return $data;
    }

    public function companyDashboard()
    {
        $request['month'] = date('Y-m');
        $menus = $this->dashboardRepository->getDashboardStatistics($request);
        $data['dashboardMenus'] = @$menus->original['data'];
        $companyMenus = $this->dashboardRepository->getCompanyDashboardStatistics($request);
        $data['companyMenus'] = @$companyMenus->original['data'];
        $attendance_data = $this->attendanceRepo->getCheckInCheckoutStatus(auth()->user()->id);
        $data['attendance'] = @$attendance_data->original['data'];
        $company_today_attendance = $this->attendanceRepo->getTodayAttendance(date('Y-m-d'));
        $data['company_today_attendance'] = $company_today_attendance;

        return $data;
    }

    public function superadminDashboard()
    {
        $request['month'] = date('Y-m');
        $menus = $this->dashboardRepository->getSuperadminDashboardStatistic($request);
        $data['dashboardMenus'] = @$menus->original['data'];
        // $companyMenus = $this->dashboardRepository->getCompanyDashboardStatistics($request);
        // $data['companyMenus'] = @$companyMenus->original['data'];
        // $attendance_data = $this->attendanceRepo->getCheckInCheckoutStatus(auth()->user()->id);
        // $data['attendance'] = @$attendance_data->original['data'];
        // $company_today_attendance= $this->attendanceRepo->getTodayAttendance(date('Y-m-d'));
        // $data['company_today_attendance'] = $company_today_attendance;

        return $data;
    }

    public function index(Request $request)
    {
        try {
            if (auth()->user()->role_id == 1 && config('app.APP_BRANCH')=='saas') {
                $data = $this->superadminDashboard();
                return view('backend.__superadmin_dashboard', compact('data'));
            } else {
                if (!config('settings.app')['site_under_maintenance']) {
                    
                    $data = $this->companyDashboard();
                    return view('backend.dashboard', compact('data'));
                } else {
                    return redirect('/');
                }
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function currentMonthPieChart(Request $request)
    {
        $request['month'] = date('Y-m');
        // return $this->dashboardRepository->currentMonthPieChart($request);
        return $this->expenseRepo->getMonthlyExpense();
    }

    public function incomeExpenseGraph(Request $request)
    {
        try {
            return $this->dashboardRepository->getIncomeExpenseGraph($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function statistics(Request $request)
    {
        try {
            return $this->dashboardRepository->getDashboardStatistics($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('adminLogin');
    }
}
