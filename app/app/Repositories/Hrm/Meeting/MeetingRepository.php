<?php

namespace App\Repositories\Hrm\Meeting;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Hrm\Meeting\Meeting;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Notifications\HrmSystemNotification;
use App\Http\Resources\Hrm\MeetingCollection;
use App\Models\Hrm\Meeting\MeetingParticipant;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\FirebaseNotification;
use App\Models\coreApp\Relationship\RelationshipTrait;

class MeetingRepository
{
    use ApiReturnFormatTrait, RelationshipTrait, FileHandler,FirebaseNotification,DateHandler,TimeDurationTrait;

    protected $model;
    protected $participants;

    public function __construct(Meeting $meeting, MeetingParticipant $meetingParticipant)
    {
        $this->model = $meeting;
        $this->participants = $meetingParticipant;
    }

    public function meetingList(): \Illuminate\Http\JsonResponse
    {
        $meeting = $this->model->query()
            ->where(['company_id' => $this->companyInformation()->id, 'user_id' => auth()->id()])
            ->orderByDesc('id')
            ->get();
        $data = new MeetingCollection($meeting);
        return $this->responseWithSuccess('Meeting list', $data, 200);

    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $meeting = $this->model->query()
            ->with(['meetingParticipants.participant', 'status'])
            ->where(['company_id' => $this->companyInformation()->id, 'user_id' => auth()->id()])
            ->where('id', $id)
            ->first();

        $data = [];
        $data['id'] = $meeting->id;
        $data['title'] = $meeting->title ?? "";
        $data['description'] = $meeting->description ?? "";
        $data['location'] = $meeting->location ?? "";
        $data['meeting_at'] = $meeting->date ?? "";
        $data['duration'] = $meeting->start_at ?? "";
        $data['start_at'] = $meeting->start_at ?? "";
        $data['end_at'] = $meeting->end_at ?? "";
        $data['status'] = @$meeting->status->name ?? "";
        $data['color'] = @$meeting->status->color_code ?? "";
        $data['attachment_file'] = uploaded_asset($meeting->attachment_file_id);
        return $this->responseWithSuccess('Meeting list', $data, 200);
    }

    public function participants($meetingId): \Illuminate\Http\JsonResponse
    {
        $participants = $this->participants->query()->with('participant')
            ->where('meeting_id', $meetingId)
            ->get();
        $data = [];
        foreach ($participants as $key => $participant) {
            $data[$key]['id'] = $participant->id;
            $data[$key]['meeting_id'] = $participant->meeting_id;
            $data[$key]['user_id'] = @$participant->participant->id;
            $data[$key]['name'] = @$participant->participant->name;
        }
        return $this->responseWithSuccess('Participant list', $data, 200);
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'description' => 'sometimes|max:255',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }


        $meeting = new $this->model;
        $meeting->company_id = $this->companyInformation()->id;
        $meeting->user_id = auth()->id();
        $meeting->title = $request->title;
        $meeting->description = $request->description;
        $meeting->date = $request->date;
        $meeting->location = $request->location;
        $meeting->start_at = $request->start_at;
        $meeting->end_at = $request->end_at;
        if ($request->hasFile('attachment_file')) {
            $meeting->attachment_file_id = $this->uploadImage($request->attachment_file, 'uploads/meeting')->id;
        }
        $meeting->status_id = 1;
        $meeting->save();
        if ($request->participants) {
            $participants = explode(',', $request->participants);
            foreach ($participants as $participant) {
                $meeting->meetingParticipants()->create([
                    'participant_id' => $participant,
                    'is_going' => 0,
                    'is_present' => 0,
                ]);

                //Send FCM Notification
                $notify_body=auth()->user()->name ." "._trans('common.Create a meeting with you at : ').$this->dateFormatInPlainText($request->date.' '.$request->start_at);
                $title=auth()->user()->name ." "._trans('common.Create meeting');
                $details = [
                    'title' => _trans('response.Meeting Notification'),
                    'body' => $notify_body,
                    'actionText' => 'View',
                    'actionURL' => [
                        'app' => 'meeting',
                        'web' => '',
                        'target' => '_blank',
                    ],
                    'sender_id' => $meeting->user_id
                ];
                $this->sendCustomFirebaseNotification($participant, 'notice', '', 'notice', $title, $notify_body);
                //Send Database Notification
                $user = User::find($participant);
                $user->notify(new HrmSystemNotification($details));
            }
        }

        return $this->responseWithSuccess('Meeting created successfully', 200);
    }

    public function addParticipants($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'meeting_id' => 'required',
            'participant_id' => 'required',
            'is_going' => 'required',
            'is_present' => 'required',
            'present_at' => 'required',
            'meeting_started_at' => 'required',
            'meeting_ended_at' => 'required',
            'meeting_duration' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        foreach ($request->participants as $key => $participant) {
            $participants = new $this->participants;
            $participants->meeting_id = $request->meeting_id;
            $participants->participant_id = $participant;
            $participants->is_going = $request->is_going;
            $participants->is_present = $request->is_present;
            $participants->meeting_duration = $request->meeting_duration;
            $participants->meeting_started_at = Carbon::now();
            $participants->meeting_ended_at = Carbon::now();
            $participants->save();
        }
        return $this->responseWithSuccess('Participants added successfully', 200);
    }
}