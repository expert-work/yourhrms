<?php

namespace App\Http\Controllers\Backend\Notice;

use Illuminate\Http\Request;
use App\Models\Hrm\Notice\Notice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeReqeust;
use App\Repositories\UserRepository;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Permission\Permission;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Models\Hrm\Notice\NoticeDepartment;
use App\Models\coreApp\Setting\CompanyConfig;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Hrm\Notice\NoticeRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\FirebaseNotification;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Department\DepartmentRepository;

class NoticeController extends Controller
{

    use ApiReturnFormatTrait, RelationshipTrait, FileHandler,FirebaseNotification;
    protected $notice;
    protected $department;
    protected $company;
    protected $model;
    protected $userRepo;
    public function __construct(NoticeRepository $noticeRepository, DepartmentRepository $department, CompanyRepository $company,Notice $notice,UserRepository $userRepo)
    {
        $this->notice = $noticeRepository;
        $this->department = $department;
        $this->company = $company;
        $this->model = $notice;
        $this->userRepo = $userRepo;

    }

    public function listView(Request $request){
        return $this->notice->noticeList($request);

    }
    public function index(Request $request){
        $data['title'] = _trans('notice.Notice List');
        return view('backend.notice.index', compact('data'));

    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        return $this->notice->show($id);
    }

    public function clear(): \Illuminate\Http\JsonResponse
    {
        return $this->notice->clearNotice();
    }

    public function edit(Notice $notice)
    {
        $data['title'] = _trans('notice.Edit notice');
        $data['notice'] = $notice;
        $data['departments'] = $this->department->getAll();
        $data['companies'] =  $this->company->getAll();
        return view('backend.notice.edit', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('notice.Add Notice');
        $data['departments'] = $this->department->getAll();
        $data['companies'] =  $this->company->getAll();
        $data['permissions'] = Permission::get();
        return view('backend.notice.create', compact('data'));
    }

    public function storeNotice(NoticeReqeust $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }  
        try {
            if ($this->isExistsWhenStore($this->model, 'subject', $request->subject)) {
               return  $this->notice->storeNotice($request);
            } else {
                return $this->responseWithError("{$request->subject} already exists", 400);
            }
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), 400);
        }
    }
    public function store(NoticeReqeust $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($this->isExistsWhenStore($this->model, 'subject', $request->subject)) {
                $this->notice->store($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('notice.index');
            } else {
                Toastr::error("{$request->subject} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect()->back();
        }
    }

    public function update(NoticeReqeust $request, Notice $notice)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($this->isExistsWhenUpdate($notice, $this->model, 'subject', $request->subject)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['notice_id'] = $notice->id;
                $this->notice->update($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('notice.index');
            } else {
                Toastr::error("{$request->subject} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function dataTable(Request $request)
    {
        return $this->notice->noticeDatatable($request);
    }

    public function delete(Notice $notice): \Illuminate\Http\RedirectResponse
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            $this->notice->destroy($notice);
            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function pushNotification()
    {
        $data['title'] = _trans('notice.Push Notification');
        $data['users'] = $this->userRepo->getAll();
        return view('backend.notice.push_notification', compact('data'));
    }
    public function sendPushNotification(Request $request)
    {
       
        $validated = $request->validate([
            'title' => 'required|max:255',
            'users' => 'required_if:notification_type,1',
            'message' => 'required',
            'notification_type' => 'required',
        ]);
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            if ($request->notification_type==1) {
                foreach ($request->users as $key => $user) {
                    $this->sendCustomFirebaseNotification($user, 'notice', '', 'notice', $request->title, $request->message);
                 }
            } else {
               $this->sendToChannel($request->title, $request->message,'notice');
            }
            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function topicPushNotification(Request $request){
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            // Api key
            $apiKey = CompanyConfig::where('key', 'firebase')
                                ->where('company_id', $request->user()->company_id)
                                ->pluck('value')
                                ->first();

            // Compile headers in one variable
            $headers = array (
                'Authorization:key=' . $apiKey,
                'Content-Type:application/json'
            );

            // Add notification content to a variable for easy reference
            $notifyData = [
                'title'        => $request->title,
                'body'         => $request->body,
                'message'      => $request->message ? $request->message : $request->body,
                'image'        => $request->image ? $request->image : null,
                'type'         => $request->type ? $request->type : 'notice',
                'click_action' => $request->click_action ? $request->click_action : null,
                'sound'        => '1',
                'vibrate'      => '1'
            ];

            // Create the api body
            $apiBody = [
                // 'notification' => $notifyData,                                       // Optional - Trigers mulitple notification
                'data' => $notifyData,
                // "time_to_live" => "60",                                              // Optional
                'to' =>  env('FCM_TOPIC')?env('FCM_TOPIC'):'/topics/onestHrm'           // Notification Channel. Example: '/topics/mytargettopic'
            ];

            // Initialize curl with the prepared headers and body
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt ($ch, CURLOPT_POST, true );
            curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

            // Execute call and save result
            $result = curl_exec ( $ch );
            Log::info($result);
            // Close curl after call
            curl_close ( $ch );

            return $result;
        } catch (\Exception $e) {
            return $e;
        }
    }

}
