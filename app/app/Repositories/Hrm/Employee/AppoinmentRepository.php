<?php

namespace App\Repositories\Hrm\Employee;

use Validator;
use Carbon\Carbon;
use App\Models\Visit\VisitImage;
use Illuminate\Support\Facades\Log;
use App\Models\Hrm\Appoinment\Appoinment;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Http\Resources\Hrm\AppoinmentCollection;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\FirebaseNotification;
use App\Models\Hrm\Appoinment\AppoinmentParticipant;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Http\Resources\Hrm\AppoinmentDetailsCollection;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


class AppoinmentRepository extends BaseRepository
{

    use RelationshipTrait, FileHandler, ApiReturnFormatTrait, DateHandler,TimeDurationTrait,FirebaseNotification;

    protected $appoinment;
    protected $appoinment_participant;

    public function __construct(Appoinment $appoinment, AppoinmentParticipant $appoinment_participant)
    {
        $this->appoinment = $appoinment;
        $this->appoinment_participant = $appoinment_participant;
    }

    public function model()
    {
        return Appoinment::class;
    }

    public function getAllAppoinment()
    {
        $appoinments= $this->appoinment->query();
        $appoinments= $appoinments->with('participants')
        ->where(function ($query) {
            $query->where('created_by',auth()->user()->id)
            ->orWhere('appoinment_with',auth()->user()->id);
        })
        ->when(request()->has('month'), function ($query) {
            $query->where('date','LIKE','%'.request('month').'%');
        })
        ->when(!request()->has('month'), function ($query) {
            $query->limit(5);
        })

        ->orderBy('id','desc')->get();
        return new AppoinmentCollection($appoinments);
    }
    public function getDetails()
    {
        $appoinment= $this->appoinment->query();
        $appoinment= $appoinment->with('participants')
        ->where(function ($query) {
            $query->where('created_by',auth()->user()->id)
            ->orWhere('appoinment_with',auth()->user()->id);
        })
        ->where('id',request('id'))

        ->orderBy('id','desc')->first();
       if ($appoinment) {
            $appointmentDetails=[
                'id' => $appoinment->id,
                'title' => $appoinment->title,
                'date' => Carbon::parse($appoinment->date)->format('F j'),
                'day' => Carbon::parse($appoinment->date)->format('l'),
                'time' => $this->dateTimeInAmPm($appoinment->appoinment_start_at),
                'start_at' => $this->timeFormatInPlainText($appoinment->appoinment_start_at),
                'end_at' => $this->timeFormatInPlainText($appoinment->appoinment_end_at),
                'location' => $appoinment->location,
                'appoinmentWith' => @$appoinment->appoinmentWith->name,
                'other_participant' => [
                    'id' => $appoinment->otherParticipant->participantInfo->id,
                    'name' => $appoinment->otherParticipant->participantInfo->name,
                    'is_agree' => $appoinment->otherParticipant->is_agree==1 ? 'Agree' : 'Disagree',
                    'is_present' => $appoinment->otherParticipant->is_present==1 ? 'Present' : 'Absent',
                    'present_at' => $appoinment->otherParticipant->present_at,
                    'appoinment_started_at' => $appoinment->otherParticipant->appoinment_started_at,
                    'appoinment_ended_at' => $appoinment->otherParticipant->appoinment_ended_at,
                    'appoinment_duration' => $appoinment->otherParticipant->appoinment_duration,
                ],
            ];
            return $this->responseWithSuccess(__('Appointment Details'), $appointmentDetails, 200);
       } else {
            return $this->responseWithSuccess('Appointment Not Found', [], 200);
       }

    }

    public function store($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'date' => 'required',
                'appoinment_with' => 'required',
                'title' => 'required',
                'location' => 'required',
                'appoinment_start_at' => 'required',
                'appoinment_end_at' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

        //Checking creator schedule time
        $appoinment_creator_schedules= Appoinment::where('date',$request->date)
        ->where('appoinment_start_at','<=',$request->appoinment_start_at)
        ->where('appoinment_end_at','>=',$request->appoinment_start_at)
        ->whereHas('participants', function ($query) {
            return $query->where([
                ['participant_id', auth()->user()->id],
                ['appoinment_ended_at', null],
                ['is_agree', 1],
            ]);
        })
        ->where(function ($query) use($request) {
            $query->where('created_by',auth()->user()->id)
            ->orWhere('appoinment_with',auth()->user()->id);
        })
        ->with('participants')
        ->first();

        //Checking Participant schedule time
        $appoinment_participant_schedules= Appoinment::where('date',$request->date)
        ->where('appoinment_start_at','<=',$request->appoinment_start_at)
        ->where('appoinment_end_at','>=',$request->appoinment_start_at)
        ->whereHas('participants', function ($query) use($request) {
            return $query->where([
                ['participant_id', $request->appoinment_with],
                ['appoinment_ended_at', null],
                ['is_agree', 1],
            ]);
        })
        ->where(function ($query) use($request) {
            $query->where('created_by',$request->appoinment_with)
            ->orWhere('appoinment_with',$request->appoinment_with);
        })
        ->with('participants')
        ->first();

        if($appoinment_creator_schedules){
            return $this->responseWithError(__('You have already scheduled, Please try after '.$this->dateFormatInPlainText($request->date .' '. $appoinment_creator_schedules->appoinment_end_at)), [], 200);
        }
        if($appoinment_participant_schedules){
            return $this->responseWithError(__('Participant already scheduled, Please try after '.$this->dateFormatInPlainText($request->date .' '.$appoinment_participant_schedules->appoinment_end_at)), [], 200);
        }



        $appoinment=new Appoinment;
        $appoinment->created_by=auth()->user()->id;
        $appoinment->company_id=auth()->user()->company_id;
        $appoinment->date=$request->date;
        $appoinment->appoinment_with=$request->appoinment_with;
        $appoinment->title=$request->title;
        $appoinment->location=$request->location;
        $appoinment->description=$request->description;
        $appoinment->appoinment_start_at=$request->appoinment_start_at;
        $appoinment->appoinment_end_at=$request->appoinment_end_at;
        $appoinment->save();

        //Creator Participant
        $appoinment_participant=new AppoinmentParticipant;
        $appoinment_participant->participant_id=$appoinment->created_by;
        $appoinment_participant->appoinment_id=$appoinment->id;
        $appoinment_participant->is_agree=1;
        $appoinment_participant->save();

        //Another Participant
        $appoinment_participant=new AppoinmentParticipant;
        $appoinment_participant->participant_id=$appoinment->appoinment_with;
        $appoinment_participant->appoinment_id=$appoinment->id;
        $appoinment_participant->is_agree=1;
        $appoinment_participant->save();

        if (isset($request->attachment_file)) {
            $visit_image = new VisitImage;
            $visit_image->imageable_id = $appoinment->id;
            $visit_image->imageable_type = 'App\Models\Hrm\Appoinment\Appoinment';
            $visit_image->file_id = $this->uploadImage($request->attachment_file, 'uploads/employeeDocuments')->id;
            $visit_image->save();
        }
        //Appointment Notification message
        $notify_body = 'You have scheduled an appointment with '.auth()->user()->name.' on '.$this->dateFormatInPlainText($appoinment->date.' '.$appoinment->appoinment_start_at);

        $details = [
            'title' => 'New Appointment Scheduled',
            'body' => $notify_body,
            'actionText' => 'View',
            'actionURL' => [
                'app' => 'appointment_request',
                'web' => url('dashboard/user/appointment'),
                'target' => '_blank',
            ],
            'sender_id' =>auth()->user()->id
        ];
        //send notification to manager
        if ($appoinment->appoinment_with != null) {
            // $this->sendFirebaseNotification($leaveRequest->user->manager_id, 'leave_approved', $leaveRequest->id, route('leaveRequest.index'));
            $this->sendFirebaseNotification($appoinment->appoinment_with, 'appointment_request', $appoinment->id, null);

            sendDatabaseNotification($appoinment->appoinmentWith, $details);
        }

        return $this->responseWithSuccess('Appoinment Created Successfully', [], 200);
    }
    public function update($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'date' => 'required',
                'appoinment_with' => 'required',
                'title' => 'required',
                'location' => 'required',
                'appoinment_start_at' => 'required',
                'appoinment_end_at' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

        $appoinment=Appoinment::find($request->id);
        $appoinment->date=$request->date;
        $appoinment->appoinment_with=$request->appoinment_with;
        $appoinment->title=$request->title;
        $appoinment->location=$request->location;
        $appoinment->description=$request->description;
        $appoinment->appoinment_start_at=$request->appoinment_start_at;
        $appoinment->appoinment_end_at=$request->appoinment_end_at;
        $appoinment->update();

        //check appoinment participant exist or not
        $appoinment_participant=AppoinmentParticipant::where('appoinment_id',$appoinment->id)->where('participant_id',$appoinment->appoinment_with)->first();
        if(!$appoinment_participant){
            $appoinment_participant=new AppoinmentParticipant;
            $appoinment_participant->participant_id=$appoinment->appoinment_with;
            $appoinment_participant->appoinment_id=$appoinment->id;
            $appoinment_participant->save();
        }
        $old_participant=AppoinmentParticipant::where('appoinment_id',$appoinment->id)
        ->whereNotIn('participant_id',[$appoinment->appoinment_with,$appoinment->created_by])->delete();

        if (isset($request->attachment_file)) {
            $visit_image = new VisitImage;
            $visit_image->imageable_id = $appoinment->id;
            $visit_image->imageable_type = 'App\Models\Hrm\Appoinment\Appoinment';
            $visit_image->file_id = $this->uploadImage($request->attachment_file, 'uploads/employeeDocuments')->id;
            $visit_image->save();
        }

        return $this->responseWithSuccess('Appoinment Updated Successfully', [], 200);
    }

    public function appoinmentChangeStatus($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'appoinment_id' => 'required',
                // 'date_time' => 'required',
                'status' => 'required|in:start,end,agree,disagree,present,absent',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        $participant=AppoinmentParticipant::where('appoinment_id', $request->appoinment_id)->where('participant_id',auth()->user()->id)->first();
            if(!$participant){
                return $this->responseWithError(__('You are not participant of this appoinment'), [], 422);
            }
        switch ($request->status) {
            case 'start':
                $participant->is_agree=1;
                $participant->is_present=1;
                $participant->present_at=date('Y-m-d H:i:s');
                $participant->appoinment_started_at=date('Y-m-d H:i:s');
                break;
            case 'end':
                if ($participant->appoinment_started_at != null) {
                    $participant->appoinment_ended_at=date('Y-m-d H:i:s');
                    $participant->appoinment_duration=$this->timeDifference($participant->appoinment_started_at, $participant->appoinment_ended_at);
                }else{
                    return $this->responseWithError(__('Appoinment not started yet'), [], 422);
                }
                break;
            case 'agree':
                $participant->is_agree=1;
                break;
            case 'disagree':
                $participant->is_agree=0;
                break;
            case 'present':
                $participant->is_present=1;
                break;
            case 'absent':
                $participant->is_present=0;
                break;
            default:
                return $participant;
                break;


            }
        $participant->save();
        return $this->responseWithSuccess('Appoinment Status Changed Successfully', [], 200);
    }
    public function deleteAppoinment($id)
    {
        $appoinment=Appoinment::find($id);
        if($appoinment->created_by!=auth()->user()->id){
            return $this->responseWithError(__('You are not creator of this appoinment'), [], 422);
        }
        $appoinment->delete();

        return $this->responseWithSuccess('Appoinment Deleted Successfully', [], 200);
    }

    public function staffProfileDatatable($request)
    {
        $appoinment = $this->appoinment
        ->where(function ($query) use ($request) {
            $query->where('created_by', auth()->user()->id)
            ->orWhere('appoinment_with',auth()->user()->id);
        });
        if (@$request->daterange) {
            $dateRange = explode(' - ', $request->daterange);
            $from = date('Y-m-d', strtotime($dateRange[0]));
            $to = date('Y-m-d', strtotime($dateRange[1]));
            $appoinment = $appoinment->whereBetween('date', start_end_datetime($from, $to));
        }
        if (@$id) {
            $appoinment = $appoinment->where('id', $id);
        }

        return $this->appointmentDatatable($appoinment);
    }


    public function profileDataTable($request, $id = null)
    {
        $appoinment = $this->appoinment
        ->where(function ($query) use ($request) {
            $query->where('created_by', $request->user_id)
            ->orWhere('appoinment_with',$request->user_id);
        });
        if (@$request->daterange) {
            $dateRange = explode(' - ', $request->daterange);
            $from = date('Y-m-d', strtotime($dateRange[0]));
            $to = date('Y-m-d', strtotime($dateRange[1]));
            $appoinment = $appoinment->whereBetween('date', start_end_datetime($from, $to));
        }
        if (@$id) {
            $appoinment = $appoinment->where('id', $id);
        }

        return $this->appointmentDatatable($appoinment);
    }

    function getAppointmentDetails($id){
        $appoinment = $this->appoinment->find($id);
        return $appoinment;
    }

    public function appointmentDatatable($appoinment)
    {
        return datatables()->of($appoinment->latest()->get())
            ->addColumn('title', function ($data) {
                return $data->title;
            })  ->addColumn('appoinment_with', function ($data) {
                return $data->appoinmentWith->name;
            })
            ->addColumn('date', function ($data) {
                return $data->date;
            })
            ->addColumn('start_at', function ($data) {
                return $data->appoinment_start_at;
            })
             ->addColumn('end_at', function ($data) {
                return $data->appoinment_end_at;
            })
            ->addColumn('location', function ($data) {
                return $data->location;
            })
            ->addColumn('action', function ($data) {
                if ($data->created_by==auth()->user()->id) {
                    $action_button = '';
                    $edit = _trans('common.Edit');
                    $delete = _trans('common.Delete');
                    $action_button .= '<a href="' . route('appointment.edit', $data->id) . '" class="dropdown-item"> '.$edit.'</a>';
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/appointment/delete/`)', 'delete');
                    $button = getActionButtons($action_button);
                    return $button;
                }else{
                    return "";
                }
            })

            ->addColumn('file', function ($data) {
                $files_array = '';
                    $files_array .= '<a href="' . uploaded_asset(@$data->visitImages->file_id) . '" target="_blank"> <img height="40px" width="40px" src="' . uploaded_asset(@$data->visitImages->file_id) . '"/> </a>';
                    return $files_array;
            })

            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('title', 'appoinment_with', 'date', 'start_at', 'end_at', 'location', 'file', 'status','action'))
            ->make(true);
    }

    public function dataTable($request)
    {
        $leaveRequest = $this->leaveRequest->query();
        if (auth()->user()->role->slug == 'staff') {
            $leaveRequest = $leaveRequest->where('user_id', auth()->id());
        } else {
            $leaveRequest->when(\request()->get('user_id'), function (Builder $builder) {
                return $builder->where('user_id', \request()->get('user_id'));
            });
        }
        $leaveRequest->when(\request()->get('daterange'), function (Builder $builder) {
            $date = explode(' - ', \request()->get('daterange'));
            return $builder->whereBetween('apply_date', [$this->databaseFormat($date[0]), $this->databaseFormat($date[1])]);
        });
        $leaveRequest->when(\request()->get('short_by'), function (Builder $builder) {
            return $builder->where('status_id', \request()->get('short_by'));
        });
        $leaveRequest->when(\request()->get('department_id'), function (Builder $builder) {
            return $builder->whereHas('assignLeave', function (Builder $builder) {
                return $builder->where('department_id', \request()->get('department_id'));
            });
        });
        return $this->leaveDataTable($leaveRequest);
    }


}
