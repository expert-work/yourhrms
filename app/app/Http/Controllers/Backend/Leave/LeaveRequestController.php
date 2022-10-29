<?php

namespace App\Http\Controllers\Backend\Leave;

use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\Hrm\AssignedLeavesCollection;
use App\Models\Hrm\Leave\LeaveRequest;
use App\Models\Hrm\Leave\LeaveType;
use App\Models\User;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Hrm\Department\DepartmentRepository;
use App\Repositories\Hrm\Leave\LeaveRequestRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    use ApiReturnFormatTrait, DateHandler;

    protected $leaveRequest;
    protected $role;

    public function __construct(LeaveRequestRepository $leaveRequestRepository, RoleRepository $role)
    {
        $this->leaveRequest = $leaveRequestRepository;
        $this->role = $role;
    }

    public function index()
    {
        try {
            $data['title'] = _trans('common.Leave Request');
            $data['departments'] = resolve(DepartmentRepository::class)->getAll();
            $data['url'] = route('leaveRequest.dataTable');
            return view('backend.leave.leaveRequest.index', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $data['title'] = _trans('common.Leave Request');
            $data['leaveTypes'] = $this->leaveRequest->getUserAssignLeave();
            $data['teamLeaders'] = User::where('status_id', 1)->select('id', 'name')->get();
            return view('backend.leave.leaveRequest.create', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $request['apply_date'] = date('Y-m-d');
            $date = explode(' - ', \request()->get('daterange'));
            $request['leave_from'] = $this->databaseFormat($date[0]);
            $request['leave_to'] = $this->databaseFormat($date[1]);
            $data = $this->leaveRequest->store($request);
            if ($data->original['result']) {
                Toastr::success(_trans('response.Operation successfull'), 'Success');
            } else {
                Toastr::error('Leave is not available for you', 'Error');
            }
            return redirect()->route('user.leaveRequest', auth()->user()->id);
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function dataTable(Request $request)
    {
        return $this->leaveRequest->dataTable($request);
    }

    public function profileDataTable(Request $request)
    {
        return $this->leaveRequest->profileDataTable($request, $request->id);
    }

    public function requestApproveOrReject(LeaveRequest $leaveRequest, $status): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $data = $this->leaveRequest->approveOrRejectOrCancel($leaveRequest->id, $status);
            if ($data) {
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation is not successful', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function delete(LeaveRequest $leaveRequest): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        return  $this->leaveRequest->destroy($leaveRequest->id);
    }

    public function pdfView($id){
        try {
            $data = $this->leaveRequest->show($id);
            $pdf = \PDF::setOptions([
                'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                'logOutputFile' => storage_path('logs/log.htm'),
                'tempDir' => storage_path('logs/'),
            ])->loadView('backend.leave.leaveRequest.leave_form_pdf_view', compact('data'));
            return $pdf->stream('leave-request-' . $data->id . '.pdf');
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
}
