<?php

namespace App\Http\Controllers\Backend\Attendance;

use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Http\Controllers\Controller;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\HRM\Attendance\Holiday;
use App\Repositories\HolidayRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class HolidayController extends Controller
{

    use AuthorInfoTrait, RelationshipTrait;

    protected $holidayRepository;
    protected $model;

    public function __construct(HolidayRepository $holidayRepository, Holiday $holiday)
    {
        $this->holidayRepository = $holidayRepository;
        $this->model = $holiday;
    }

    public function index()
    {
        $data['title'] = _trans('leave.Holiday list');
        $data['holidays'] = $this->holidayRepository->index();
        return view('backend.attendance.holiday.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('leave.Add holiday');
        return view('backend.attendance.holiday.create', compact('data'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status_id' => 'required'
        ]);

        try {
            if ($this->isExistsWhenStore($this->model, 'title', $request->title)) {
                $request['company_id'] = $this->companyInformation()->id;
                $this->holidayRepository->store($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('holidaySetup.index');
            } else {
                Toastr::error("{$request->title} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }

    public function show(Holiday $holiday)
    {
        $data['title'] = _trans('leave.Edit Holiday');
        $data['holiday'] = $holiday;
        return view('backend.attendance.holiday.edit', compact('data'));

    }

    public function update(Request $request, Holiday $holiday)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status_id' => 'required'
        ]);

        try {
            if ($this->isExistsWhenUpdate($holiday, $this->model, 'title', $request->title)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['holiday_id'] = $holiday->id;
                $this->holidayRepository->update($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('holidaySetup.index');
            } else {
                Toastr::error("{$request->title} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }

    public function delete(Holiday $holiday_id): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $this->holidayRepository->delete($holiday_id);
            Toastr::success(_trans('leave.Holiday has been deleted'), 'Success');
            return redirect()->back();
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }
}
