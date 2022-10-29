<?php

namespace App\Http\Controllers\Backend\Leave;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hrm\Leave\LeaveTypeRequest;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Hrm\Leave\LeaveRequest;
use App\Models\Hrm\Leave\LeaveType;
use App\Repositories\Hrm\Leave\LeaveTypeRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    use RelationshipTrait;

    protected LeaveTypeRepository $leaveType;
    protected $model;

    public function __construct(LeaveTypeRepository $leaveTypeRepository, LeaveType $leaveType)
    {
        $this->leaveType = $leaveTypeRepository;
        $this->model = $leaveType;
    }

    public function index()
    {
        try {
            $data['title'] = _trans('leave.Leave type');
            return view('backend.leave.type.index', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function create()
    {
        $data['title'] = _trans('leave.Add leave type');
        return view('backend.leave.type.create', compact('data'));
    }

    public function store(LeaveTypeRequest $request): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($this->isExistsWhenStore($this->model, 'name', $request->name)) {
                $request['company_id'] = $this->companyInformation()->id;
                $this->leaveType->store($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('leave.index');
            } else {
                Toastr::error("{$request->name} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function dataTable(Request $request)
    {
        try {
            return $this->leaveType->dataTable($request, $id = null);
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function show(LeaveType $leaveType)
    {
        return $this->leaveType->show($leaveType->id);
    }

    public function edit(LeaveType $leaveType)
    {
        $data['title'] = _trans('leave.Edit leave type');
        $data['show'] = $this->leaveType->show($leaveType->id);
        return view('backend.leave.type.edit', compact('data'));
    }

    public function update(LeaveTypeRequest $request, LeaveType $leaveType): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($this->isExistsWhenUpdate($leaveType, $this->model, 'name', $request->name)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['type_id'] = $leaveType->id;
                $this->leaveType->update($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('leave.index');
            } else {
                Toastr::error("{$request->name} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function delete($id): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        return $this->leaveType->destroy($id);

    }
}
