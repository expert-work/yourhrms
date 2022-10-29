<?php

namespace App\Http\Controllers\Backend\Attendance;

use Illuminate\Http\Request;
use App\Models\Hrm\Shift\Shift;
use App\Http\Requests\ShiftReqeust;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DesignationReqeust;
use App\Models\Hrm\Designation\Designation;
use App\Repositories\Hrm\Shift\ShiftRepository;
use App\Models\coreApp\Relationship\RelationshipTrait;


class ShiftController extends Controller
{
    use RelationshipTrait;

    protected ShiftRepository $shift;
    protected $model;

    public function __construct(ShiftRepository $shift, Shift $model)
    {
        $this->shift = $shift;
        $this->model = $model;
    }

    public function index()
    {
        $data['title'] = _trans('attendance.Duty Shifts');
        return view('backend.shift.index', compact('data'));
    }


    public function create()
    {
        $data['title'] = _trans('attendance.Add Shift');
        return view('backend.shift.create', compact('data'));
    }


    public function store(ShiftReqeust $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            if ($this->isExistsWhenStore($this->model, 'name', $request->name)) {
                $request['company_id'] = $this->companyInformation()->id;
                $this->shift->store($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('shift.index');
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
        return  $this->shift->dataTable($request);
    }


    public function show(Shift $shift): Shift
    {
        return $shift;
    }

    public function edit(Shift $shift)
    {
        $data['title'] = _trans('attendance.Edit Shift');
        $data['shift'] = $shift;
        return view('backend.shift.edit', compact('data'));
    }

    public function update(ShiftReqeust $request, Shift $shift): \Illuminate\Http\RedirectResponse
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            if ($this->isExistsWhenUpdate($shift, $this->model, 'name', $request->name)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['shift_id'] = $shift->id;
                $this->shift->update($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('shift.index');
            } else {
                Toastr::error("{$request->name} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function delete(Shift $shift)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        return $this->shift->destroy($shift);
    }
}
