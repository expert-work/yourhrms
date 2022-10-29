<?php

namespace App\Http\Controllers\Backend\Attendance;

use App\Http\Controllers\Controller;
use App\Models\HRM\Attendance\Weekend;
use App\Repositories\WeekendsRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class WeekendsController extends Controller
{
    protected $weekend;

    public function __construct(WeekendsRepository $weekendsRepository)
    {
        $this->weekend = $weekendsRepository;
    }

    public function index()
    {
        $data['title'] = _trans('leave.Weekend list');
        $data['weekends'] = $this->weekend->index();
        return view('backend.attendance.weekend.index', compact('data'));
    }

    public function show(Weekend $weekend): Weekend
    {
        return $weekend;
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        } 
        $this->validate($request, [
            'name' => 'required'
        ]);

        try {
            $this->weekend->update($request);
            Toastr::success(_trans('leave.Weekend has been updated'), 'Success');
            return redirect()->back();
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }
}
