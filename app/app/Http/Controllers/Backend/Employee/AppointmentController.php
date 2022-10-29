<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Hrm\Leave\LeaveRequest;
use App\Repositories\Hrm\Employee\AppoinmentRepository;

class AppointmentController extends Controller
{

    protected $appointRepo;
    public function __construct(AppoinmentRepository $appointRepo)
    {
        $this->appointRepo = $appointRepo;
    }
    public function index()
    {
        try {
            $data['title'] = _trans('leave.Leave Request');
            $data['departments'] = resolve(DepartmentRepository::class)->getAll();
            $data['url'] = route('leaveRequest.dataTable');
            return view('backend.leave.leaveRequest.index', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function list()
    {
        try {
            $data['title']= _trans('appointment.Appointment List');
            $data['id']=auth()->user()->id;
            return view('backend.appointment.index', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $data['title'] = _trans('common.Create Appointment');
            return view('backend.appointment.create', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        try {
            $data['title'] = _trans('common.Edit Appointment');
            $data['show']=$this->appointRepo->getAppointmentDetails($id);
            // return $data['show'];
            return view('backend.appointment.edit', compact('data'));
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
            $data = $this->appointRepo->store($request);
            if ($data->original['result']) {
                Toastr::success(_trans('response.Operation successfull'), 'Success');
            } else {
                Toastr::error('Appointment is not available for you', 'Error');
            }
            return redirect()->route('appointment.index');
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $data = $this->appointRepo->update($request);
            if ($data->original['result']) {
                Toastr::success(_trans('response.Operation successfull'), 'Success');
            } else {
                Toastr::error('Appointment is not available for you', 'Error');
            }
            return redirect()->route('appointment.index');
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function dataTable(Request $request)
    {
        return $this->appointRepo->dataTable($request);
    }

    public function profileDataTable(Request $request)
    {
        return $this->appointRepo->profileDataTable($request, $request->id);
    }


    public function delete($id)
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $data = $this->appointRepo->deleteAppoinment($id);
            if ($data) {
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('appointment.index');
            } else {
                Toastr::error('Operation is not successful', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->route('appointment.index');
        }
    }

}
