<?php

namespace App\Http\Controllers\LiteApp\FaceRecognition;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\Hrm\Attendance\AttendanceRepository;

class FaceAttendanceController extends Controller
{

    protected $userRepo;
    protected $attendantRepo;

    public function __construct(UserRepository $userRepo, AttendanceRepository $attendantRepo)
    {
        $this->userRepo = $userRepo;
        $this->attendantRepo = $attendantRepo;
    }

    public function verifyPin(Request $request)
    {
        return $this->userRepo->verifyPin($request);
    }
    public function distanceCheck(Request $request)
    {
        return $this->attendantRepo->distanceCheck($request);
    }

    public function checkIn(Request $request)
    {
        $request['user_id']             =   auth()->user()->id;
        $request['remote_mode_in']      =   1;
        $request['date']                =   date('Y-m-d');
        $request['check_in']            =   date('H:i');

        return $this->attendantRepo->checkInLite($request);
    }
    public function checkOut(Request $request)
    {
        $request['user_id']             =   auth()->user()->id;
        $request['remote_mode_out']     =   1;
        $request['date']                =   date('Y-m-d');
        $request['check_out']           =   date('H:i');
        $request['app_lite']            =   1;
        $attendance_id                  =   $request->attendance_id;

        return $this->attendantRepo->checkOut($request,$attendance_id);
    }
}
