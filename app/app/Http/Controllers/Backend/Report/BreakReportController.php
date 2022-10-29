<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Repositories\Hrm\Department\DepartmentRepository;
use App\Repositories\Report\BreakReportRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class BreakReportController extends Controller
{
    protected $breakReport;
    protected $department;
    protected $users;

    public function __construct(BreakReportRepository $breakReport, DepartmentRepository $department, UserRepository $users)
    {
        $this->breakReport = $breakReport;
        $this->department = $department;
        $this->users = $users;
    }

    public function index()
    {
        $data['title'] = _trans('common.Break History');
        $data['departments'] = $this->department->getAll();
        $data['users'] = $this->users->getAll();
        return view('backend.report.break.index', compact('data'));
    }

    public function dataTable()
    {
        return $this->breakReport->dataTable();
    }
}
