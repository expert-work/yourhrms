<?php

namespace App\Http\Controllers\Backend\Leave;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hrm\Leave\AssignLeaveRequest;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Hrm\Leave\AssignLeave;
use App\Models\Hrm\Leave\LeaveType;
use App\Models\Role\Role;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Hrm\Department\DepartmentRepository;
use App\Repositories\Hrm\Leave\AssignLeaveRepository;
use App\Repositories\Hrm\Leave\LeaveTypeRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AssignLeaveController extends Controller
{
    use RelationshipTrait;

    protected AssignLeaveRepository $assignLeave;
    protected RoleRepository $role;
    protected LeaveTypeRepository $leaveType;
    protected DepartmentRepository $departmentRepository;
    protected $model;

    public function __construct(AssignLeaveRepository $assignLeaveRepository, RoleRepository $role, LeaveTypeRepository $leaveType, AssignLeave $model, DepartmentRepository $departmentRepository)
    {
        $this->assignLeave = $assignLeaveRepository;
        $this->role = $role;
        $this->leaveType = $leaveType;
        $this->model = $model;
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        try {
            $data['title'] = _trans('leave.Assign leave');
            $data['departments'] = $this->departmentRepository->getAll();
            return view('backend.leave.assign.index', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function create()
    {
        $data['title'] = _trans('leave.Assign leave');
        $data['departments'] = $this->departmentRepository->getAll();
        $data['leaveTypes'] = $this->leaveType->getAll();
        return view('backend.leave.assign.create', compact('data'));
    }


    public function dataTable(Request $request)
    {
        try {
            return $this->assignLeave->dataTable($request, $id = null);
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function store(AssignLeaveRequest $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $this->assignLeave->store($request);
            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->route('assignLeave.index');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        return $this->assignLeave->show($id);
    }

    public function edit(AssignLeave $assignLeave)
    {
        $data['title'] = _trans('leave.Edit assign leave');
        $data['departments'] = $this->departmentRepository->getAll();
        $data['leaveTypes'] = $this->leaveType->getAll();
        $data['show'] = $this->assignLeave->show($assignLeave->id);
        return view('backend.leave.assign.edit', compact('data'));
    }

    public function update(AssignLeaveRequest $request,$assignLeave)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $request['department_id']=intval($request->department_id);
            $request['type_id']=intval($request->type_id);
            $request['status_id']=intval($request->status_id);
            $request['id']=intval($request->assignLeave);
            $this->assignLeave->update($request);
            Toastr::success(_trans('response.Operation successfull'), 'Success');
            return redirect()->route('assignLeave.index');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function isAlreadyAssigned($request)
    {
        $exists = AssignLeave::where([
            'type_id' => $request->type_id,
            'role_id' => $request->role_id,
        ])->first();
        if (!$exists) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(AssignLeave $assignLeave)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
       return $this->assignLeave->destroy($assignLeave->id);
    }
}
