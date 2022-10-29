<?php

namespace App\Http\Controllers\Backend\Attendance;

use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\HRM\Attendance\DutySchedule;
use App\Repositories\DutyScheduleRepository;

class DutyScheduleController extends Controller
{
    use RelationshipTrait, AuthorInfoTrait;

    protected $dutyScheduleRepository;
    protected $model;

    public function __construct(DutyScheduleRepository $dutyScheduleRepository, DutySchedule $dutySchedule)
    {
        $this->dutyScheduleRepository = $dutyScheduleRepository;
        $this->model = $dutySchedule;
    }

    public function index()
    {
        $data = $this->dutyScheduleRepository->index();
        return view('backend.attendance.duty_schedule.index', compact('data'));
    }

    public function create()
    {
        $data = $this->dutyScheduleRepository->create();
        return view('backend.attendance.duty_schedule.create', compact('data'));
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $this->validate($request, [
            'shift_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'consider_time' => 'numeric',
            'status_id' => 'required'
        ]);

        try {
            $store = $this->dutyScheduleRepository->store($request);
            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->route('dutySchedule.index');

        } catch (\Throwable $th) {

            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }

    }

    public function show($duty_schedule)
    {
        $data = $this->dutyScheduleRepository->show($duty_schedule);
        return view('backend.attendance.duty_schedule.edit', compact('data'));
    }

    public function update(Request $request, DutySchedule $schedule)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $this->validate($request, [
            'shift_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'consider_time' => 'numeric',
            'status_id' => 'required'
        ]);
        try {
            if ($this->isExistsWhenUpdate($schedule, $this->model, 'shift_id', $request->shift_id)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['duty_schedule_id'] = $schedule->id;

                $st = explode(':', $request->start_time);
                $ed = explode(':', $request->end_time);
                // return sizeof($st);
                if (sizeof($st) > 2) {
                    $start_time = date('Y-m-d') . ' ' . $request->start_time;
                } else {
                    $start_time = date('Y-m-d') . ' ' . $request->start_time . ':00';
                }
                if($request->end_on_same_date == 1){
                    $end_date = date('Y-m-d');
                }else{
                    $end_date = date('Y-m-d', strtotime('+1 day'));
                }
                if (sizeof($ed) > 2) {
                    $end_time =  $end_date . ' ' . $request->end_time;
                } else {
                    $end_time =  $end_date . ' ' . $request->end_time . ':00';
                }
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $start_time);
                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $end_time);

                $diff_in_minutes = $to->diffInMinutes($from);
                $request['hour'] = $diff_in_minutes / 60;
                $store = $this->dutyScheduleRepository->update($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('dutySchedule.index');
            } else {
                Toastr::error("Already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }

    public function delete($duty_schedule)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $this->dutyScheduleRepository->distroy($duty_schedule);
            Toastr::success(__translate('Duty schedule has been deleted'), 'Success');
            return redirect()->back();
        } catch (\Exception $exception) {
            Toastr::error(__translate('Something went wrong'), 'Error');
            return redirect()->back();
        }
    }


    public function dutyScheduleDataTable(Request $request)
    {
        return $this->dutyScheduleRepository->dutyScheduleDataTable($request);
    }

}
