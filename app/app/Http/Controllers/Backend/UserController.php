<?php

namespace App\Http\Controllers\Backend;

use Validator;
use Svg\Tag\Rect;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Task\TaskService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\Award\AwardService;
use Brian2694\Toastr\Facades\Toastr;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Hash;
use App\Models\Permission\Permission;
use App\Services\Travel\TravelService;
use App\Http\Requests\PinUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Repositories\ProfileRepository;
use App\Models\Hrm\Department\Department;
use App\Repositories\Admin\RoleRepository;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Models\Hrm\Designation\Designation;
use App\Services\Management\ProjectService;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Repositories\Hrm\Visit\VisitRepository;
use App\Repositories\Hrm\Notice\NoticeRepository;
use App\Repositories\Hrm\Payroll\SalaryRepository;
use App\Repositories\Hrm\Payroll\AdvanceRepository;
use App\Http\Requests\Hrm\User\ProfileUpdateRequest;
use App\Repositories\Support\SupportTicketRepository;
use App\Http\Requests\coreApp\User\UserProfileRequest;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Employee\AppoinmentRepository;
use App\Repositories\Report\AttendanceReportRepository;
use App\Repositories\Hrm\Department\DepartmentRepository;
use App\Repositories\Hrm\Designation\DesignationRepository;
use App\Repositories\Settings\ProfileUpdateSettingRepository;

class UserController extends Controller
{
    use FileHandler, AuthorInfoTrait, RelationshipTrait;

    protected $user;
    protected $role;
    protected $profile;
    protected $profileSetting;
    protected $designation;
    protected $department;
    protected $noticeRepository;

    protected $supportTicketRepository;
    protected $visitRepository;
    protected $appointmentRepository;
    protected $salaryRepository;
    protected $projectService;
    protected $taskService;
    protected $awardService;
    protected $travelService;
    protected $advanceRepository;

    public function __construct(
        UserRepository                 $user,
        RoleRepository                 $roleRepository,
        ProfileRepository              $profileRepository,
        DesignationRepository          $designation,
        DepartmentRepository           $department,
        ProfileUpdateSettingRepository $profileUpdateSettingRepository,
        SupportTicketRepository        $supportTicketRepository,
        AttendanceReportRepository     $attendanceReportRepository,
        NoticeRepository               $noticeRepository,
        VisitRepository                $visitRepository,
        AppoinmentRepository           $appointmentRepository,
        SalaryRepository               $salaryRepository,
        ProjectService                 $projectService,
        TaskService                    $taskService,
        AwardService                   $awardService,
        TravelService                  $travelService,
        AdvanceRepository              $advanceRepository
    ) {
        $this->user = $user;
        $this->role = $roleRepository;
        $this->profile = $profileRepository;
        $this->profileSetting = $profileUpdateSettingRepository;
        $this->designation = $designation;
        $this->department = $department;
        $this->supportTicketRepository = $supportTicketRepository;
        $this->attendanceReportRepository = $attendanceReportRepository;
        $this->noticeRepository = $noticeRepository;
        $this->visitRepository = $visitRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->salaryRepository = $salaryRepository;
        $this->projectService = $projectService;
        $this->taskService = $taskService;
        $this->awardService = $awardService;
        $this->travelService = $travelService;
        $this->advanceRepository = $advanceRepository;
    }

    public function profile(Request $request,$slug)
    {
        try {
            $user = $request->user();
            if (!myCompanyData($user->company_id)) {
                Toastr::warning('You Can\'t access!', 'Access Denied');
                return redirect()->back();
            }        
            $data['title'] = _trans('common.Employee Details');
            $data['slug'] = $slug;
            $data['id'] = auth()->user()->id;
            $request['user_id'] = auth()->user()->id;
            $data['show'] = $this->profile->getProfile($request, $slug);
            return view('backend.user.staff.show', compact('data'));
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function userInfo(Request $request,$user_id,$slug)
    {
        try {
            $user = $request->user();
            if (!myCompanyData($user->company_id)) {
                Toastr::warning('You Can\'t access!', 'Access Denied');
                return redirect()->back();
            }        
            $data['title']      = plain_text($slug);
            $data['slug']       = $slug;
            $data['id']         = $user_id;
            $request['user_id'] = $user_id;
            $data['show']       = $this->profile->getProfile($request, $slug);
            switch ($slug) {
                case 'tasks':
                    $data['table']     = route('task.table');
                    $data['url_id']    = 'task_table_url';
                    $data['fields']    = $this->taskService->fields();
                    $data['class']     = 'task_table_class';
                    break;
                case 'award':
                    $data['title']     = _trans('award.Award List');
                    $data['table']     = route('award.table');
                    $data['url_id']    = 'award_table_url';
                    $data['fields']    = $this->awardService->fields();
                    $data['class']     = 'award_table_class';
                    break;
                case 'travel':
                    $data['title']     = _trans('travel.Travel List');
                    $data['table']     = route('user.profileDataTable',['user_id'=>$data['id'],'type'=>'travel']);
                    $data['url_id']    = 'travel_table_url';
                    $data['fields']    = $this->travelService->fields();
                    $data['class']     = 'travel_table_class';
                    break;
                case 'support':
                    $data['title'] = _trans('support.Support ticket');
                    $data['url'] = route('supportTicket.dataTable');
                    break;
                // case 'commission':
                //    $data['show'] = $this->profile->getProfile($request, $slug);
                //     break;
                
                default:
                    # code...
                    break;
            }
               
            return view('backend.user.'.$slug, compact('data'));
        } catch (\Exception $e) {
            dd($e);
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function staffInfo(Request $request,$slug)
    {
        try {
            $user = $request->user();
            if (!myCompanyData($user->company_id)) {
                Toastr::warning('You Can\'t access!', 'Access Denied');
                return redirect()->back();
            }        
            $data['title']      = plain_text($slug);
            $data['slug']       = $slug;
            $data['id']         = auth()->user()->id;
            $request['user_id'] = auth()->user()->id;
            $data['show']       = $this->profile->getProfile($request, $slug);
            switch ($slug) {
                case 'tasks':
                    $data['table']     = route('task.table');
                    $data['url_id']    = 'task_table_url';
                    $data['fields']    = $this->taskService->fields();
                    $data['class']     = 'task_table_class';
                    break;
                case 'award':
                    $data['title']     = _trans('award.Award List');
                    $data['table']     = route('award.table');
                    $data['url_id']    = 'award_table_url';
                    $data['fields']    = $this->awardService->fields();
                    $data['class']     = 'award_table_class';
                    break;
                case 'travel':
                    $data['title']     = _trans('travel.Travel List');
                    $data['table']     = route('travel.table');
                    $data['url_id']    = 'travel_table_url';
                    $data['fields']    = $this->travelService->fields();
                    $data['class']     = 'travel_table_class';
                    break;
                
                default:
                    # code...
                    break;
            }
               
            return view('backend.user.staff.'.$slug, compact('data'));
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function profileInfo(Request $request,$slug)
    {
        try {
            $user = $request->user();
            if (!myCompanyData($user->company_id)) {
                Toastr::warning('You Can\'t access!', 'Access Denied');
                return redirect()->back();
            }        
            $data['title'] = _trans('common.Co-Worker Details');
            $data['slug'] = $slug;
            $data['id'] = auth()->user()->id;
            $request['user_id'] = auth()->user()->id;
            $data['show'] = $this->profile->getProfile($request, $slug);
            return view('backend.user.staff.show', compact('data'));
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    // user datatable
    function userDataTable(Request $request,$user_id, $slug){
        switch ($slug) {
            case 'attendance':
                $table = $this->attendanceReportRepository->getAttendanceDataTable($request);
                break;
            
            case 'visit':
                $table =  $this->visitRepository->getUserVisitListForWeb($request);
                break;
            case 'phonebook':
                $table =  $this->user->departmentWiseUser($request);
                break;
            case 'appointment':
                $table =  $this->appointmentRepository->staffProfileDatatable($request, $request->id);
                break;
            case 'ticket':
                $table =  $this->supportTicketRepository->staffSupportDataTable($request);
                break;
            case 'advance':
                $table =  $this->advanceRepository->userDataTable($request,$user_id);
                break;
            case 'contract':
                $table =  $this->profile->getProfile($request, $slug);
                break;
            case 'notice':
                $table =  $this->noticeRepository->noticeDatatable($request);
                break;
            case 'salary':
                $table =   $this->salaryRepository->userDataTable($request,$user_id);
                break;
            case 'project':
                $table =   $this->projectService->userDataTable($request,$user_id);
                break;
            case 'tasks':
                $table =   $this->taskService->userDatatable($request,$user_id);
                break;
            case 'award':
                $table =   $this->awardService->userDatatable($request,$user_id);
                break;
            case 'travel':
                $table =   $this->travelService->userDatatable($request,$user_id);
                break;
            
            default:
                # code...
                break;
        }


        return $table; 
    } 
    // auth user datatable
    function authUserDataTable(Request $request, $slug){
        switch ($slug) {
            case 'attendance':
                $table = $this->attendanceReportRepository->getAttendanceDataTable($request);
                break;
            
            case 'visit':
                $table =  $this->visitRepository->getUserVisitListForWeb($request);
                break;
            case 'phonebook':
                $table =  $this->user->departmentWiseUser($request);
                break;
            case 'appointment':
                $table =  $this->appointmentRepository->staffProfileDatatable($request, $request->id);
                break;
            case 'ticket':
                $table =  $this->supportTicketRepository->staffSupportDataTable($request);
                break;
            case 'advance':
                $table =  $this->advanceRepository->userDataTable($request,auth()->user()->id);
                break;
            case 'contract':
                $table =  $this->profile->getProfile($request, $slug);
                break;
            case 'notice':
                $table =  $this->noticeRepository->noticeDatatable($request);
                break;
            case 'salary':
                $table =   $this->salaryRepository->staffDataTable($request);
                break;
            case 'project':
                $table =   $this->projectService->datatable($request);
                break;
            case 'tasks':
                $table =   $this->taskService->datatable($request);
                break;
            
            default:
                # code...
                break;
        }


        return $table; 
    } 

    function security(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $this->validate($request, array(
            'email' => 'nullable|max:250',
            'old_password' => 'nullable|max:250',
            'password' => 'confirmed|min:8|different:old_password',

        ));
        DB::beginTransaction();
        try {
            $data = User::find($request->_id);

            if (!Hash::check($request['old_password'], $data->password)) {
                Toastr::error('The old password does not match our records.', 'Error');
                return redirect()->back();
            }
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->save();
            DB::commit();
            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function update(Request $request, User $user)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            $this->user->update($request, $user->id);
            DB::commit();
            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return back();
        }
    }

    public function updateProfile(UserProfileRequest $request)
    {
        return $this->user->updateProfile($request);
    }

    public function index()
    {
        try {
            // return $this->user->getById(46);
            $data['title'] = _trans('common.User List');
            // $data['users'] = $this->user->getAll();
            $data['roles'] = $this->role->getAll();
            return view('backend.user.index', compact('data'));
        } catch (\Exception $exception) {
        }
    }

    public function create()
    {
        $data['title'] = _trans('common.Add User');
        $data['designations'] = $this->designation->getAll();
        $data['departments'] = $this->department->getAll();
        $data['shifts'] = $this->user->getShift();
        $data['roles'] = $this->role->getAll();
        $data['permissions'] = Permission::get();
        return view('backend.user.add_user', compact('data'));
        return view('backend.user.create', compact('data'));
    }

    public function store(UserStoreRequest $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $user = $this->user->save($request);
            DB::commit();
            Toastr::success('User Created Successfuly', 'Success');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return back();
        }
    }


    public function delete(User $user)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $this->user->delete($user);
            Toastr::success(__translate('User Deleted Successfuly'), 'Success');
            return redirect()->back();
        } catch (\Exception $exception) {
            Toastr::error(__translate('Something went wrong!'), 'Error');
            return back();
        }
    }

    public function changeStatus(User $user, $status)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $this->user->changeStatus($user, $status);
            Toastr::success('User status change Successfuly', 'Success');
            return redirect()->back();
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return back();
        }
    }

    public function show($id)
    {
        try {
            return $this->user->getById($id);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function profileView(Request $request, User $user, $slug)
    {
      if (!myCompanyData($user->company_id)) {
        Toastr::warning('You Can\'t access!', 'Access Denied');
        return redirect()->back();
      }

        $data['title'] = _trans('common.Co-Worker Details');
        $data['slug'] = $slug;
        $data['id'] = $user->id;
        $request['user_id'] = $user->id;
        $data['show'] = $this->profile->getProfile($request, $slug);
        if (auth()->user()->role->name == "Staff") {
            if ($user->id == auth()->id()) {
                return view('backend.user.show', compact('data'));
            } else {
                return back();
            }
        } else {
            return view('backend.user.show', compact('data'));
        }
    }

    public function profileEditView(Request $request, User $user, $slug)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $data['title'] = _trans('common.Edit Co-Worker');
        $data['slug'] = $slug;
        $data['id'] = $user->id;
        $data['departments'] = $this->profileSetting->getAllDepartment();
        $data['designations'] = $this->profileSetting->getAllDesignation();
        $data['managers'] = $this->user->getAll();
        $request['user_id'] = $user->id;
        $data['show'] = $this->profile->getProfile($request, $slug);
        return view('backend.user.edit', compact('data'));
    }
    public function staffProfileEditView(Request $request,$slug)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $user=auth()->user();
        $data['title'] = _trans('common.Edit Profile');
        $data['slug'] = $slug;
        $data['id'] = $user->id;
        $data['departments'] = $this->profileSetting->getAllDepartment();
        $data['designations'] = $this->profileSetting->getAllDesignation();
        $data['managers'] = $this->user->getAll();
        $request['user_id'] = $user->id;
        $data['show'] = $this->profile->getProfile($request, $slug);
        return view('backend.user.staff.edit', compact('data'));
    }



    public function profileUpdate(ProfileUpdateRequest $request, User $user, $slug)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            // return $request;
            $update= $this->profile->updateProfile($request, $slug);
            if ($update) {
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return back();
            } else {
                Toastr::error(_trans('response.Something went wrong.'), 'Error');
                // return redirect()->route('user.edit.profile', [$user->id, $slug]);
                return back();
            }

        } catch (\Exception $exception) { 
            Toastr::error('Something went wrong.', 'Error');
            return back();
        }
    }

    public function edit(User $user)
    {
        try {
            $data['title'] = _trans('common.Edit information');
            $data['show'] = $user;
            $data['designations'] = $this->designation->getAll();
            $data['departments'] = $this->department->getAll();
            $data['shifts'] = $this->user->getShift();
            $data['roles'] = $this->role->getAll();
            $data['permissions'] = Permission::get();
            return view('backend.user.edit_view', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }

    public function support(Request $request, $id)
    {
        try {
            $data['id'] = $id;
            $data['title'] = _trans('common.Support Ticket List');
            $data['permissions'] = Permission::get();
            return view('backend.user.support', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }


    public function supportTicketsDataTable(Request $request)
    {
        return $this->supportTicketRepository->dataTable($request);
    }

    public function attendance(Request $request, $id)
    {
        try {
            $user=$this->user->getById($id);
            if ($user) {
                if (!myCompanyData($user->company_id)) {
                    Toastr::warning('You Can\'t access!', 'Access Denied');
                    return redirect()->back();
                }
                if (auth()->user()->role->slug == 'staff' && auth()->id() != $id) {
                    return abort(403);
                }
                $data['id'] = $id;
                $data['title'] = _trans('common.Attendance List');
                $data['users'] = $this->user->getAll();
                $data['departments'] = $this->department->getAll();
                $data['permissions'] = Permission::get();
                $data['url'] = route('user.attendanceTable', $id);
                return view('backend.user.attendance', compact('data'));
            } else {
                Toastr::error('User Not Found.', 'Error');
                return back();
            }

        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
            return back();
        }
    }

    public function leaveRequest(Request $request, $id)
    {
        try {
            $user=$this->user->getById($id);
            if ($user) {
                if (!myCompanyData($user->company_id)) {
                    Toastr::warning('You Can\'t access!', 'Access Denied');
                    return redirect()->back();
                }
                if (auth()->user()->role->slug == 'staff' && auth()->id() != $id) {
                    return abort(403);
                }
                $data['id'] = $id;
                $data['title'] = _trans('common.Leave Request List');
                return view('backend.user.leave_request', compact('data'));

            } else {
                Toastr::error('User Not Found.', 'Error');
                return back();
            }
        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }

    public function leaveRequestApproved(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $user=$this->user->getById($id);
            if ($user) {
                if (!myCompanyData($user->company_id)) {
                    Toastr::warning('You Can\'t access!', 'Access Denied');
                    return redirect()->back();
                }
                if (auth()->user()->role->slug == 'staff' && auth()->id() != $id) {
                    return abort(403);
                }
                $data['id'] = $id;
                $data['title'] = _trans('common.Approved Leave Request List');
                return view('backend.user.approved_leave_request', compact('data'));

            } else {
                Toastr::error('User Not Found.', 'Error');
                return back();
            }

        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }

    public function notice(Request $request, $id)
    {
        try {
            $user=$this->user->getById($id);
            if ($user) {
                if (!myCompanyData($user->company_id)) {
                    Toastr::warning('You Can\'t access!', 'Access Denied');
                    return redirect()->back();
                }
                if (auth()->user()->role->slug == 'staff' && auth()->id() != $id) {
                    return abort(403);
                }
                $data['id'] = $id;
                $data['user'] = $this->user->getById($id);
                $data['title'] = _trans('common.Notice List');
                return view('backend.user.notice', compact('data'));
            } else {
                Toastr::error('User Not Found.', 'Error');
                return back();
            }

        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }

    public function clearNotice(Request $request)
    {
        return $this->attendanceReportRepository->attendanceProfileDatatable($request);
        return $this->noticeRepository->clearNotice();
    }

    public function attendanceListDataTable(Request $request, $id)
    {
        try {

            $request['user_id'] = $id;
            return $this->attendanceReportRepository->attendanceDatatable($request);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    function noticeDatatable(Request $request)
    {
        try {
            return $this->noticeRepository->noticeDatatable($request);
        } catch (\Exception $e) {
            Log::error($e);
            Toastr::error(__translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    function data_table(Request $request)
    {
        try {
            return $this->user->data_table($request);
        } catch (\Exception $e) {
            Toastr::error(__translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    function makeHR(Request $request, $user_id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $result = $this->user->makeHR($user_id);
            if ($result) {
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Something went wrong.', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(__translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function getUsers(Request $request)
    {
        // Log::info($request->all());
        return $this->user->getUserByKeywords($request);
    }

    public function phonebook($id)
    {
        try {
            $user=$this->user->getById($id);
            if ($user) {
                if (!myCompanyData($user->company_id)) {
                    Toastr::warning('You Can\'t access!', 'Access Denied');
                    return redirect()->back();
                }
                if (auth()->user()->role->slug == 'staff' && auth()->id() != $id) {
                    return abort(403);
                }
                $data['id'] = $id;
                $data['title'] = _trans('common.Phonebook');
                $data['user'] = $this->user->getById($id);
                return view('backend.user.phonebook', compact('data'));

            } else {
                Toastr::error('User Not Found.', 'Error');
                return back();
            }
        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }

    public function phonebookDatatable(Request $request)
    {
        try {
            return $this->user->departmentWiseUser($request);
        } catch (\Exception $e) {
            Toastr::error(__translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function appointment($id)
    {
        try {
            $user=$this->user->getById($id);
            if ($user) {
                if (!myCompanyData($user->company_id)) {
                    Toastr::warning('You Can\'t access!', 'Access Denied');
                    return redirect()->back();
                }
                if (auth()->user()->role->slug == 'staff' && auth()->id() != $id) {
                    return abort(403);
                }

                $data['id'] = $id;
                $data['title'] = _trans('common.Appointment List');
                $data['user'] = $this->user->getById($id);
                return view('backend.user.appointment', compact('data'));
            } else {
                Toastr::error('User Not Found.', 'Error');
                return back();
            }
        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }

    public function updateUserPin(PinUpdateRequest $request)
    {
        try {
            $result=$this->user->updateUserPin($request);
            if ($result) {
                Toastr::success('Pin Updated Successfully.', 'success');
                return redirect()->back();
            } else {
                Toastr::error('Something went wrong.', 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error('Something went wrong.', 'Error');
            return redirect()->back();
        }
    }
    public function updateUserIp(Request $request){
        try {
            $user=User::find($request->user_id);
            if ($user){
                $user->ip_address=$request->ip_address;
                $user->save();
            }
            $response = array(
                'ip_address' => $user->ip_address,
                'status' => _trans('message.Success'),
                'msg' => _trans('message.Updated successfully'),
            );
            return $response;
        } catch (\Throwable $th) {
            $response = array(
                'status' => _trans('message.Error'),
                'msg' =>$th->getMessage(),
            );
            return $response;
        }
    }
}
