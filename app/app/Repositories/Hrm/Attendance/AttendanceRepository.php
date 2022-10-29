<?php

namespace App\Repositories\Hrm\Attendance;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Enums\AttendanceStatus;
use App\Models\Track\LocationLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\LocationBind;
use App\Models\coreApp\Setting\IpSetup;
use App\Models\Hrm\Attendance\Attendance;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Models\Hrm\Attendance\DutySchedule;
use App\Models\coreApp\Setting\CompanyConfig;
use App\Models\Hrm\Attendance\LateInOutReason;
use App\Helpers\CoreApp\Traits\GeoLocationTrait;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\FirebaseNotification;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Leave\LeaveRequestRepository;
use App\Repositories\Settings\CompanyConfigRepository;

class AttendanceRepository
{
    use ApiReturnFormatTrait, RelationshipTrait, TimeDurationTrait, GeoLocationTrait, DateHandler,FirebaseNotification;

    protected $attendance;
    protected $user;
    protected $leave_request_repo;
    protected $config_repo;

    public function __construct(
        Attendance $attendance,
        User $user,
        LeaveRequestRepository $leave_request_repo,
        CompanyConfigRepository $companyConfigRepo
    ) {
        $this->attendance = $attendance;
        $this->user = $user;
        $this->leave_request_repo = $leave_request_repo;
        $this->config_repo = $companyConfigRepo;
    }


    public function companySetup()
    {
        $configs = $this->config_repo->getConfigs();
        $config_array = [];
        foreach ($configs as $key => $config) {
            $config_array[$config->key] = $config->value;
        }
        $data = $config_array;
        return $data;
    }

    public function getCheckInCheckoutStatus($userId)
    {   

        $userId=auth()->user()->id;
        $user = $this->user->query()->find($userId);
        if ($user) {
            if (@$this->companySetup()['multi_checkin']) {
                $where = ['user_id' => $userId,'date' => date('Y-m-d'),'check_out' => null];
            } else {
                $where = ['user_id' => $userId,'date' => date('Y-m-d')];
            }
            $attendance = $this->attendance->query()->orderByDesc('id')->where($where)->first();
                if ($attendance) {
                    if ($attendance->check_out) {
                        return $this->responseWithSuccess('Already checked out', [
                            'id' => $attendance->id,
                            'checkin' => true,
                            'checkout' => true,
                            'in_time' => $this->dateTimeInAmPm(@$attendance->check_in),
                            'out_time' => $this->dateTimeInAmPm(@$attendance->check_out),
                            'stay_time' => $this->timeDifference($attendance->check_in, $attendance->check_out)
                        ], 200);
                    } else {
                        return $this->responseWithSuccess('You are checked in please leave from office in due time', [
                            'id' => $attendance->id,
                            'checkin' => true,
                            'checkout' => false,
                            'in_time' => $this->dateTimeInAmPm(@$attendance->check_in),
                            'out_time' => null,
                            'stay_time' => null
                        ], 200);
                    }
                } else {
                    return $this->responseWithSuccess('Please check in now', [
                        'checkin' => false,
                        'checkout' => false,
                        'in_time' => null,
                        'out_time' => null,
                        'stay_time' => null
    
                    ], 200);
                }
            } else {
                return $this->responseWithError('No user found', [], 200);
            }
    
    }

    public function getAll()
    {
        return $this->attendance::get();
    }

    public function index()
    {
        $attendance = $this->attendance->query()->where('company_id', $this->companyInformation()->id)->orderBy('date', 'DESC')->get();
        return $attendance;
    }

    public function checkInUsers()
    {
        return User::query()->where('role_id', '!=', 1)->where('company_id', $this->companyInformation()->id)->select('id', 'name')->get();
    }

    public function show($attendance_id)
    {
        $data['title'] = 'Attendance Check In Edit';
        $data['attendance_data'] = $this->attendance::find($attendance_id);
        $data['users'] = User::where('role_id', '!=', 1)->select('id', 'name')->get();

        return $data;
    }

    public function getAttendanceStatus($user_id, $check_in_time)
    {
        $check_in_time = $check_in_time . ':00';

        $user_info = User::find($user_id);
        $schedule = DutySchedule::where('role_id', $user_info->role_id)->where('status_id', 1)->first();
        if ($schedule) {
            $check_in_time_diff = timeDiff($schedule->start_time, $check_in_time, 'all', $start_date = null, $end_date = null);
            $consider_time = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d') . ' ' . $schedule->start_time);
            $consider_time = Carbon::parse($consider_time)->addMinutes($schedule->consider_time);
            // ->toDateTimeString()
            $startTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d') . ' ' . $schedule->start_time);
            $endTime = $consider_time;

            $check = Carbon::now()->between($startTime, $endTime, true);
            //IF USER CHECK-IN BEFORE START TIME
            $office_start_time = Carbon::now()->subMinutes(5);
            $in_time = Carbon::now();
            $result = $startTime->gt($in_time);
            $status = "";
            if ($result) {
                $status = 'OT';
            } else {
                //IF USER CHECK-IN AFTER START TIME
                if ($check) {
                    $status = 'OT';
                } else {
                    $status = 'L';
                }
            }
            return $status;
        } else {
            return "OT";
        }
    }


    public function checkInStatus($user_id, $check_in_time): array
    {
        /*
         *  OT = On time
         * E = Early
         * L = Late
         */

        $user_info = User::find($user_id);
        $schedule = DutySchedule::where('shift_id', $user_info->shift_id)->where('status_id', 1)->first();
        if ($schedule) {
            $startTime = strtotime($schedule->start_time);
            $check_in_time = strtotime($check_in_time . ':00');
            $diffFromStartTime = ($check_in_time - $startTime) / 60;
            //check employee check-in on time
            if ($check_in_time <= $startTime) {
                return [AttendanceStatus::ON_TIME, $diffFromStartTime];
            } else {
                $considerTime = $schedule->consider_time;
                // check if employee come late and have some consider time
                if ($diffFromStartTime > $considerTime) {
                    return [AttendanceStatus::LATE, $diffFromStartTime];
                } else {
                    return [AttendanceStatus::ON_TIME, $diffFromStartTime];
                }
            }
        } else {
            return array();
        }
    }

    public function attendanceFromDevice($request)
    {
        $validator = Validator::make($request->all(), [
            'userID' => 'required',
            'date_time' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

        try {
            $request['remote_mode_in'] = 1;
            $request['check_in_location'] = 'Device';
            $request['check_in_latitude'] = '';
            $request['check_in_longitude'] = '';
            $request['city'] = '';
            $request['country_code'] = '';
            $request['country'] = '';
            $request['checkin_ip'] = '';
            $request['check_in'] = $this->timeFormatFromTimestamp($request['date_time']);
            $request['date'] = $this->databaseFormat($request['date_time']);
            // return $request;
            $user = $this->user->query()->where('userID', $request->userID)->first();
            if (!$user) {
                return $this->responseWithError('User not found', [], 200);
            }

            auth()->login($user);


            $request['user_id'] = $user->id;
            return $this->userAttendance($user, $request);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->responseWithError('Something went wrong', [$th->getMessage()], 400);
        }
    }

    function distanceCheck($request)
    {   
        $request['remote_mode_in'] = 1;
        $result=$this->locationCheck($request);
        if($result){
            return $this->responseWithSuccess('User In Location', [], 200);
        }else{
            return $this->responseWithError('Location Not In The Office', [], 422);
        }

    }

    public function locationCheck($request)
    {
        // Log::info($request->all());
        $locationInfo = false;
        $where = [
            'company_id' => auth()->user()->company_id,
            'status_id' => 1,
        ];
        if ($request->remote_mode==1) {
            $where  = array_merge($where, [
                'is_office' => 33,
            ]);
        } else {
            $where  = array_merge($where, [
                'is_office' => 22,
            ]);
        }
        foreach (DB::table('location_binds')->where($where)->get() as $location) {
            $distance = distanceCalculate($request->latitude, $request->longitude, $location->latitude, $location->longitude);
            if ($distance <= $location->distance) {
                $locationInfo = true;
            }
        }
        return $locationInfo;
    }
    public function checkUserIpEligibility($request){
        $user_ip_check=false;

        if (auth()->user()->ip_address == getUserIpAddr()) {
            $user_ip_check=true;
         } else {
            $user_ip_check=false;
         }
        return $user_ip_check;
    }
    public function ipCheck($request)
    {
        if(auth()->user()->ip_bind==0){
            return true;
        }

        $where = [
            'company_id' => auth()->user()->company_id,
            'status_id'  => 1,
            'ip_address' => getUserIpAddr()
        ];
        if ($request->remote_mode_in) {
            $where  = array_merge($where, [
                'is_office' => 33,
            ]);
        } else {
            $where  = array_merge($where, [
                'is_office' => 22,
            ]);
        }
        $getIps = IpSetup::where($where)->get();
        if ($getIps->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function store($request)
    {
        // Log::info($request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'check_in' => 'required',
            'date' => 'required|date',
            'remote_mode_in' => 'required',
        ]);

        $request['remote_mode'] = $request->remote_mode_in;
        

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

          //Start Checking QR Code
          if (settings('attendance_method')=='QR') {
            $validator = Validator::make($request->all(), [
                'qr_scan' => 'required',
            ]);
    
            if ($validator->fails()) {
                return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
            }
            try {
                $company_id=decrypt($request->qr_scan);
                if (auth()->user()->company_id!=$company_id) {
                    return $this->responseWithError('Invalid QR Code', [], 400);
                }
            } catch (\Throwable $th) {
                return $this->responseWithError('Something went wrong', [$th->getMessage()], 400);
            }
        }
        //End QR Checking


        try {
            if (auth()->user()->role->slug == 'staff' && $request->user_id != auth()->id()) {
                return $this->responseWithError('You are doing a shit thing so go away from here!!', [], 400);
            }


            $user = $this->user->query()->find($request->user_id);

            return $this->userAttendance($user, $request);
        } catch (\Throwable $th) {
            // dd($th);
            return $this->responseWithError('Something went wrong', [$th->getMessage()], 400);
        }
    }

    public function userAttendance($user, $request)
    {
        if ($user) {
            $attendance = $this->attendance->where(['user_id' => $user->id, 'date' => $request->date])->first();
            if ($attendance && !settings('multi_checkin')) {
                return $this->responseWithError('Attendance already exists', [], 400);
            }
            if (settings('location_check') && !$this->locationCheck($request)) {
                return $this->responseWithError(_trans('message.Your location is not valid'), [], 400);
            }
            if (checkFeature('user_location_binds') && auth()->user()->ip_bind==1 && !$this->checkUserIpEligibility($request)) {
                return $this->responseWithError(_trans('message.You are not in your registered IP address'), [], 400);
            }
            if (checkFeature('user_location_binds')==false && settings('ip_check') &&  !$this->ipCheck($request)) {
                return $this->responseWithError(_trans('message.You your ip address is not valid'), [], 400);
            }
            $request['checkin_ip'] = getUserIpAddr();
            $attendance_status = $this->checkInStatus($request->user_id, $request->check_in);
            if (count($attendance_status) > 0) {

                if ($attendance_status[0] == AttendanceStatus::LATE && $request['check_in_location'] != 'Device') {
                    $validator = Validator::make($request->all(), [
                        'reason' => 'required',
                    ]);

                    if ($validator->fails()) {
                        $data = [
                            'reason_status' => 'L'
                        ];
                        return $this->responseWithError(__('Reason is required'), $data, 400);
                    }
                }
              
                $check_in=$this->storeAttendance($request,$user,$attendance_status);

                if ($request->reason) {
                    LateInOutReason::create([
                        'attendance_id' => $check_in->id,
                        'user_id' => $check_in->user_id,
                        'company_id' => $check_in->user->company->id,
                        'type' => 'in',
                        'reason' => $request->reason
                    ]);
                }

                return $this->responseWithSuccess('Check in successfully', $check_in, 200);
            } else {
                return $this->responseWithError('No Schedule found', [], 400);
            }
        } else {
            return $this->responseWithError('No user found', [], 400);
        }
    }
    function pushNotification($title,$notify_body,$attendance,$notify_to)
    {
        $details = [
            'title' => _trans('response.Attendance Notification'),
            'body' => $notify_body,
            'actionText' => 'View',
            'actionURL' => [
                'app' => 'leave_request',
                'web' => route('leaveRequest.index'),
                'target' => '_blank',
            ],
            'sender_id' => $attendance->user_id
        ];

        $this->sendCustomFirebaseNotification($notify_to, 'notice', '', 'notice', $title, $notify_body);
    }

    function storeAttendance($request,$user,$attendance_status)
    {
        $current_date_time = date('Y-m-d H:i:s');
        $checkinTime = $this->getDateTime($request->check_in);
        $check_in = new $this->attendance;
        $check_in->company_id = $user->company->id;
        $check_in->user_id = $request->user_id;
        $check_in->remote_mode_in = $request->remote_mode_in;
        $check_in->date = $request->date;

        if ($request->attendance_from == 'web') {
            $check_in->check_in = $checkinTime;
        } else {
            $check_in->check_in = $current_date_time;
        }

        $check_in->in_status = $attendance_status[0];
        $check_in->checkin_ip = $request->checkin_ip;
        $check_in->late_time = $attendance_status[1];
        $check_in->check_in_location = $request->check_in_location;
        $check_in->check_in_latitude = $request->check_in_latitude;
        $check_in->check_in_longitude = $request->check_in_longitude;
        $check_in->check_in_city = $request->city;
        $check_in->check_in_country_code = $request->country_code;
        $check_in->check_in_country = $request->country;
        $check_in->save();

        $notify_body=$check_in->user->name ." "._trans('attendance.Check-in Time : ').$this->timeFormatInPlainText(date('H:i:s'));
        $title=$check_in->user->name ." "._trans('attendance.Check-in');

        if (!isset($request->attendance_from) && settings('admin_notify')==1 ) {
            $this->pushNotification($title,$notify_body,$check_in,$check_in->user->myAdmin()->id);
        }
        if (!isset($request->attendance_from) && settings('hr_notify')==1 && $check_in->user->myHr()) {
            $this->pushNotification($title,$notify_body,$check_in,$check_in->user->myHr()->id);
        }

        return $check_in;
    }

    public function getTodayAttendance($date)
    {
        // $date='2022-05-10';
        // $date=date('Y-m-d');
        $attendance = $this->attendance->where('company_id', auth()->user()->company_id)
            ->where('date', $date)
            ->select('user_id', 'date')
            ->groupBy('user_id', 'date')
            ->get()
            ->count();
        $total_employee = $this->user->where('company_id', auth()->user()->company_id)->where('status_id', 1)->count();
        $today_leave = $this->leave_request_repo->dateWiseLeaveCount($date);
        $data = [
            'Present' => $attendance,
            'total_employee' => $total_employee,
            'Absent' => $total_employee - $attendance - intval($today_leave),
            'Leave' => $today_leave,
        ];
        return $data;
        if ($attendance) {
            return $this->responseWithSuccess('Attendance found', $attendance, 200);
        } else {
            return $this->responseWithError('No attendance found', [], 400);
        }
    }

    public function isIpRestricted(): bool
    {
        $companyId = $this->companyInformation()->id;
        $isIpEnabled = CompanyConfig::where([
            'company_id' => $this->companyInformation()->id,
            'key' => 'ip_check',
            'value' => 1
        ])->first();

        // Log::info('ip' . getUserIpAddr());

        // Log::info('info ' . $companyId . ' ip_address ' . getUserIpAddr());

        //if IP restriction is enabled the meet the condition and go for IP check otherwise this will return true
        if ($isIpEnabled) {
            // if (\request()->get('remote_mode_in') === 0 || \request()->get('remote_mode_out') === 0) {
            $getIps = IpSetup::where('company_id', $companyId)->where('status_id', 1)->whereIn('ip_address', [getUserIpAddr()])->get();
            if ($getIps->count() > 0) {
                return true;
            } else {
                return false;
            }
            // } else {
            //     return true;
            // }
        } else {
            return true;
        }
    }

    public function lateInOutReason($request, $attendance_id): \Illuminate\Http\JsonResponse
    {
        $attendance = $this->attendance->query()->find($attendance_id);
        if ($attendance) {
            $request['company_id'] = $this->companyInformation()->id;
            $attendance->lateInOutReason()->create($request->all());
            return $this->responseWithSuccess('Reason added successfully', [], 200);
        } else {
            return $this->responseWithError('No data found', $attendance, 400);
        }
    }

    public function checkOutStatus($user_id, $check_out_time): array
    {
        /*
         *  LE = Left Early
         *  LT = Left Timely
         *  LL = Left Later
         */

        $user_info = User::find($user_id);
        $schedule = DutySchedule::where('shift_id', $user_info->shift_id)->first();
        if ($schedule) {
            $endTime = strtotime($schedule->end_time);
            $formate = [
                'check_out_time' => $check_out_time,
                'endTime' => $schedule->end_time
            ];
            // return $formate;
            $check_out_time = strtotime($formate['check_out_time']);
            $endTime = strtotime($formate['endTime']);
            $diffFromEndTime = ($endTime - $check_out_time) / 60;

            //check employee check-out after end time
            if ($check_out_time > $endTime) {
                return [AttendanceStatus::LEFT_LATER, $diffFromEndTime];
            } //check employee check-out timely
            elseif ($check_out_time == $endTime) {
                return [AttendanceStatus::LEFT_TIMELY, $diffFromEndTime];
            } //check employee check-out before end time
            elseif ($check_out_time < $endTime) {
                return [AttendanceStatus::LEFT_EARLY, $diffFromEndTime];
            } //in general an employee check-out timely
            else {
                return [AttendanceStatus::LEFT_TIMELY, $diffFromEndTime];
            }
        } else {
            return array();
        }
    }

    public function checkOut($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'check_out' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }


        try {
            $request['remote_mode'] = $request->remote_mode_out;
            if (settings('location_check') && !$this->locationCheck($request)) {
                return $this->responseWithError('Your location is not valid', [], 400);
            }
            if (settings('ip_check') && !$this->isIpRestricted()) {
                return $this->responseWithError('You your ip address is not valid', [], 400);
            }
            $user = $this->user->query()->find($request->user_id);
            if ($user) {
                $isIpRestricted = $this->isIpRestricted();
                if ($isIpRestricted) {
                    $request['checkin_ip'] = getUserIpAddr();
                    $attendance_status = $this->checkOutStatus($request->user_id, $request->check_out);
                    //abhi
                    if (count($attendance_status) > 0) {
                        // return $attendance_status;
                        if ($attendance_status[0] == AttendanceStatus::LEFT_EARLY  && !isset($request->app_lite)) {
                            $validator = Validator::make($request->all(), [
                                'reason' => 'required',
                            ]);

                            if ($validator->fails()) {
                                $data = [
                                    'reason_status' => 'LE'
                                ];
                                return $this->responseWithError(__('Reason is required'), $data, 422);
                            }
                        }

                        $checkOutTime = $this->getDateTime($request->check_out);
                        $time_zone = @settings('timezone') ?? config('app.timezone');
                        date_default_timezone_set($time_zone);
                        $current_date_time = date('Y-m-d H:i:s');
                        $check_in = $this->attendance->query()->find($id);
                        if ($check_in) {
                            $check_in->user_id = $request->user_id;
                            $check_in->remote_mode_out = $request->remote_mode_out;
                            $check_in->date = $request->date;
                            $check_in->check_out = $current_date_time;
                            $check_in->out_status = $attendance_status[0];
                            $check_in->checkout_ip = $request->checkin_ip;
                            $check_in->late_time = $attendance_status[1];
                            $check_in->check_out_location = $request->check_out_location;
                            $check_in->check_out_latitude = $request->check_out_latitude;
                            $check_in->check_out_longitude = $request->check_out_longitude;
                            $check_in->check_out_city = $request->city;
                            $check_in->check_out_country_code = $request->country_code;
                            $check_in->check_out_country = $request->country;
                            $check_in->save();
                            if ($request->reason) {
                                LateInOutReason::create([
                                    'attendance_id' => $check_in->id,
                                    'user_id' => $check_in->user_id,
                                    'company_id' => $check_in->user->company->id,
                                    'type' => 'out',
                                    'reason' => $request->reason
                                ]);
                            }
                            $notify_body=$check_in->user->name ." "._trans('attendance.Check-out Time : ').$this->timeFormatInPlainText(date('H:i:s'));
                            $title=$check_in->user->name ." "._trans('attendance.Check-out');

                            if (!isset($request->attendance_from) && settings('admin_notify')==1 ) {
                                $this->pushNotification($title,$notify_body,$check_in,$check_in->user->myAdmin()->id);
                            }
                            if (!isset($request->attendance_from) && settings('hr_notify')==1 ) {
                                $this->pushNotification($title,$notify_body,$check_in,$check_in->user->myHr()->id);
                            }

                            
                            if (isset($request->app_lite)) {
                                $user_checkout['user_id']=$check_in->user_id;
                                $user_checkout['date']=$this->dateFormatWithoutTime($check_in->date);
                                $user_checkout['check_out']=$this->timeFormatInPlainText($check_in->check_out);
                                return $this->responseWithSuccess('Check out successfully', $user_checkout, 200);
                            }
                            return $this->responseWithSuccess('Check out successfully', $check_in, 200);
                        } else {
                            return $this->responseWithError('No data found', [], 400);
                        }
                    } else {
                        return $this->responseWithError('No Schedule found', [], 400);
                    }
                } else {
                    return $this->responseWithError('You your ip address is not valid', [], 400);
                }
            } else {
                return $this->responseWithError('No user found', [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError('Something went wrong', [], 400);
        }
    }

    public function checkOutFromAdmin($request, $attendance_id)
    {
        try {
            $check_out = Carbon::now()->toDateTimeString();
            $attendance = $this->attendance->query()->find($attendance_id);
            $check_in = date("H:i:s", strtotime($attendance->check_in));
            $check_out_time = date("H:i:s", strtotime($check_out));
            $stay_time = timeDiff($check_in, $check_out_time, 'all', $start_date = null, $end_date = null);

            $attendance->check_out = $check_out;
            $attendance->checkout_ip = getUserIpAddr();
            $attendance->stay_time = $stay_time;
            $attendance->save();

            return $this->responseWithSuccess('Check out successfully', $check_in, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError('Something went wrong', [], 400);
        }
    }

    public function update($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'check_out' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

        try {
            $user = $this->user->query()->find($request->user_id);
            if ($user) {
                $request['checkout_ip'] = getUserIpAddr();
                $attendance_status = $this->checkOutStatus($request->user_id, $request->check_out);
                if (count($attendance_status) > 0) {

                    if (settings('location_check') && !$this->locationCheck($request)) {
                        return $this->responseWithError( _trans('message.Your location is not valid'), [], 400);
                    }
                    if (settings('ip_check') && !$this->isIpRestricted()) {
                        return $this->responseWithError(_trans('message.You your ip address is not valid'), [], 400);
                    }

                    $checkInTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d') . ' ' . $request->check_in . ':00');
                    $checkOutTime = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d') . ' ' . $request->check_out . ':00');
                    $check_out = $this->attendance->query()->find($id);
                    $check_out->user_id = $request->user_id;
                    $check_out->check_in_location = $request->check_in_location;
                    $check_out->check_in = $checkInTime;
                    $check_out->date = $request->date ? $request->date : $check_out->date;
                    $check_out->check_out = $checkOutTime;
                    $check_out->check_out_location = $request->check_out_location;
                    $check_out->out_status = $attendance_status[0];
                    $check_out->late_time = $attendance_status[1];
                    $check_out->save();

                    if ($request->late_in_reason) {
                        LateInOutReason::updateOrCreate([
                            'attendance_id' => $check_out->id,
                            'company_id' => $check_out->user->company->id,
                            'type' => 'in',
                        ], [
                            'reason' => $request->late_in_reason
                        ]);
                    }
                    if ($request->early_leave_reason) {
                        LateInOutReason::updateOrCreate([
                            'attendance_id' => $check_out->id,
                            'company_id' => $check_out->user->company->id,
                            'type' => 'out',
                        ], [
                            'reason' => $request->early_leave_reason
                        ]);
                    }


                    return $this->responseWithSuccess('Check out successfully', $check_out, 200);
                } else {
                    return $this->responseWithError('No Schedule found', [], 400);
                }
            } else {
                return $this->responseWithError('No user found', [], 400);
            }
        } catch (\Throwable $th) {
            // Log::error($th);
            return $this->responseWithError('Something went wrong', [], 400);
        }
    }

    public function liveLocationStore($request)
    {
        try {

            foreach ($request->locations as $key => $location) {
                $locationLog = new LocationLog();
                $locationLog->date = $request->date;
                $locationLog->latitude = $location['latitude'];
                $locationLog->longitude = $location['longitude'];
                $locationLog->speed = $location['speed'];
                $locationLog->heading = $location['heading'];
                $locationLog->city = $location['city'];
                $locationLog->country = $location['country'];
                $locationLog->distance = $location['distance'];
                $locationLog->address = $location['address'];
                $locationLog->countryCode = $location['countryCode'];
                $locationLog->user_id = auth()->id();
                $locationLog->company_id = auth()->user()->company_id;
                $locationLog->save();
            }



            return $this->responseWithSuccess('Live data stored successfully');
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 400);
        }
    }

    function checkInLite($request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        try {
            $request['remote_mode'] = $request->remote_mode_in;

            $location_info = $this->locationCheck($request);
            if(settings('location_check') && !$location_info){
                return $this->responseWithError('Location Not In The Office', [], 422);
            }

        $attendance_status = $this->checkInStatus($request->user_id, $request->check_in);
        if (count($attendance_status) > 0) {

            $user=auth()->user();
            $check_in= $this->storeAttendance($request,$user,$attendance_status);
            $user_checkin=[];
            $user_checkin['user_id']=$check_in->user_id;
            $user_checkin['date']=$this->dateFormatWithoutTime($check_in->date);
            $user_checkin['check_in']=$this->timeFormatInPlainText($check_in->check_in);
            return $this->responseWithSuccess('Check in successfully', $user_checkin, 200);
        } else {
            return $this->responseWithError('No Schedule found', [], 400);
        }
        return $this->responseWithSuccess('Live data stored successfully');
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    function checkOutLite($request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        try {
            $request['remote_mode'] = $request->remote_mode_in;

            $location_info = $this->locationCheck($request);
            if(!$location_info){
                return $this->responseWithError('Location Not In The Office', [], 422);
            }

        $attendance_status = $this->checkInStatus($request->user_id, $request->check_in);
        if (count($attendance_status) > 0) {

            $user=auth()->user();
            $check_out= $this->storeAttendance($request,$user,$attendance_status);

            $user_checkout['user_id']=$check_out->user_id;
            $user_checkout['date']=$this->dateFormatWithoutTime($check_out->date);
            $user_checkout['check_out']=$this->timeFormatInPlainText($check_out->check_out);

            return $this->responseWithSuccess('Check Out successfully', $user_checkout, 200);
        } else {
            return $this->responseWithError('No Schedule found', [], 400);
        }
        return $this->responseWithSuccess('Live data stored successfully');
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
