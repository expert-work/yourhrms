<?php

namespace App\Repositories;


use JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role\Role;
use App\Models\Role\RoleUser;
use App\Models\Hrm\Shift\Shift;
use App\Models\Track\LocationLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\SmsHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Repositories\Interfaces\UserInterface;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class UserRepository
{
    
    use FileHandler, SmsHandler, AuthorInfoTrait, RelationshipTrait,ApiReturnFormatTrait;
    
    public $token = true;
    public $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->query()->where('company_id', $this->companyInformation()->id)->get();
    }

    public function getShift()
    {
        return Shift::query()->where('company_id', $this->companyInformation()->id)->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getUserByKeywords($request)
    {
        $where = [];
        if ($request->has('department_id')) {
            $where = array('department_id' => $request->get('department_id'));
        }
        return $this->model->query()->where('company_id', $this->companyInformation()->id)
            ->where($where)
            ->where('name', 'LIKE', "%$request->term%")
            ->select('id', 'name', 'phone', 'employee_id')
            ->take(10)
            ->get();
    }

    public function save($request)
    {
        if (empty($request->joining_date)) {
            $request['joining_date'] = date('Y-m-d');
        }
        if ($request->permissions) {
            $request['permissions'] = $request->permissions;
        } else {
            $request['permissions'] = [];
        }
        $request['company_id'] = $this->companyInformation()->id;
        $request['password'] = Hash::make($request->password);
        $request['country_id'] = $request->country;
        $user = $this->model->query()->create($request->all());
        $user->userRole()->create([
            'user_id' => $user->id,
            'role_id' => $request->role_id
        ]);
        return $user;
    }

    public function update($request, $id)
    {
        $request->validate([
            'phone' => 'required|unique:users,phone,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'name' => 'required|max:250',
            'gender' => 'nullable|max:250',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:25000',
        ]);
        if (settings('login_method')=='pin') {
            $request->validate([
                'pin' => 'required|unique:users,pin,'.$id,
            ]);
        }

        try {
            $user = $this->model->query()->find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->joining_date = $request->joining_date;
            $user->department_id = $request->department_id;
            $user->designation_id = $request->designation_id;
            $user->address = $request->address;
            $user->religion = $request->religion;
            $user->shift_id = $request->shift_id;
            $user->marital_status = $request->marital_status;
            $user->basic_salary = $request->basic_salary;
            $user->role_id = $request->role_id;
            $user->birth_date = $request->birth_date;
            $user->pin = @$request->pin;
            $user->permissions = $request->permissions;

            if ($request->avatar) {
                $user->avatar_id = $this->uploadImage($request->avatar, 'uploads/user')->id;
            }
            //author info update here
            $user->save();
            $role = RoleUser::where('user_id', $user->id)->first();
            $role->role_id = $user->role_id;
            $role->save();
            $this->updatedBy($user);

            return $user;
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function updateProfile($request)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->query()->find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->birth_date = $request->birth_date;

            if ($request->avatar) {
                $this->deleteImage(asset_path($user->avatar_id));
                $user->avatar_id = $this->uploadImage($request->avatar, 'uploads/user')->id;
            }
            DB::commit();
            $user->save();
            //author info update here
            $this->updatedBy($user);
            Toastr::success('Operation successful!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return back();
        }
    }


    public function delete($user)
    {
        $user->delete();
        return true;
    }

    public function changeStatus($user, $status)
    {
        $user->update([
            'status_id' => $status
        ]);
        return true;
    }
    public function makeHR($user_id)
    {
        $user = $this->model->query()->find($user_id);
       if ($user->is_hr == 1) {
           $user->is_hr=0;
           $user->update();
       } else {
            $user->is_hr=1;
            $user->update();
       }

        return true;
    }

    public function data_table($request, $id = null)
    {

        $users = $this->model->query()->with('department','designation','role','shift','status')
                ->where('id','!=',$this->companyInformation()->id)
                ->where('company_id', $this->companyInformation()->id)
                ->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'name', 'email', 'phone','shift_id', 'status_id','is_hr','pin');
                if (@$request->from && @$request->to) {
                    $users = $users->whereBetween('created_at', start_end_datetime($request->from, $request->to));
                }

                if (@$request->userTypeId) {
                    $users = $users->where('role_id', $request->userTypeId);
                }
                if (@$request->user_id) {
                    $users = $users->where('id', $request->user_id);
                }
                $users = $users->latest()->get();


        return datatables()->of($users)
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                $unBanned = _trans('common.Unbanned');
                $banned = _trans('common.Banned');
                // $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/department/delete/`)', 'delete');

                if (hasPermission('profile_view')) {
                    $action_button .= actionButton('Profile', route('user.profile', [$data->id, 'official']), 'profile');
                    if (hasPermission('user_edit')) {
                        $action_button .= actionButton($edit, route('user.edit', $data->id), 'profile');
                    }
                }
                
                if ($data->status_id == 3) {
                    if (hasPermission('user_banned')) {
                        $action_button .= actionButton($unBanned, 'ApproveOrReject(' . $data->id . ',' . "1" . ',`dashboard/user/change-status/`,`Approve`)', 'approve');
                    }
                } else {
                    if (hasPermission('user_unbanned')) {
                        $action_button .= actionButton($banned, 'ApproveOrReject(' . $data->id . ',' . "3" . ',`dashboard/user/change-status/`,`Approve`)', 'approve');
                    }
                }
                if (hasPermission('user_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`dashboard/user/delete/`)', 'delete');
                }
                if (hasPermission('make_hr')) {

                    if ($data->is_hr == "1") {
                        $hr_btn = _trans('leave.Remove HR');
                    } else {
                        $hr_btn = _trans('leave.Make HR');
                    }
                    $action_button .= actionButton($hr_btn, 'MakeHrByAdmin(' . $data->id .',`dashboard/user/make-hr/`,`HR`)', 'approve');
                }
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            
            ->addColumn('name', function ($data) {
                if ($data->is_hr==1) {
                    $actAsHr = _trans('hrm.Acting as HR');
                    $hr_badge= @$data->name.' </br><small class="text-success">['. $actAsHr .']</small>';
                } else {
                    $hr_badge= @$data->name. "";
                }
                return @$hr_badge;
            })
           
            ->addColumn('email', function ($data) {
                $pin="";
                if(settings('login_method')=='pin') {
                    $login_data = $data->pin;
                }else{
                    $login_data = $data->email;
                }
                return @$login_data;
            })
            ->addColumn('phone', function ($data) {
                return @$data->phone;
            })
            ->addColumn('department', function ($data) {
                return @$data->department->title;
            })
            ->addColumn('designation', function ($data) {
                return @$data->designation->title;
            })
            ->addColumn('role', function ($data) {
                return @$data->role->name;
            })
            ->addColumn('shift', function ($data) {
                return @$data->shift->name;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('name', 'email', 'phone', 'department', 'designation', 'role', 'shift', 'status', 'action'))
            ->make(true);
    }
    public function ip_data_table($request, $id = null)
    {

        $users = $this->model->query()->with('department','designation','role','shift','status')
                ->where('id','!=',$this->companyInformation()->id)
                ->where('company_id', $this->companyInformation()->id)
                ->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'name', 'ip_bind', 'ip_address','shift_id', 'status_id','is_hr','pin');
                if (@$request->from && @$request->to) {
                    $users = $users->whereBetween('created_at', start_end_datetime($request->from, $request->to));
                }

                if (@$request->userTypeId) {
                    $users = $users->where('role_id', $request->userTypeId);
                }
                if (@$request->user_id) {
                    $users = $users->where('id', $request->user_id);
                }
                $users = $users->latest()->get();


        return datatables()->of($users)
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                $unBanned = _trans('common.Unbanned');
                $banned = _trans('common.Banned');
                // $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/department/delete/`)', 'delete');

                $button = '
                <a href="#" onclick="manageIpSetup('.$data->id.',1)" class="show_ip_edit_field" data-id="'.$data->id.'" id="ip_edit_btn_'.$data->id.'" ><i  class="text-primary bi bi-pencil-square"></i></a>
                <a href="#" onclick="manageIpSetup('.$data->id.',2)" id="ip_save_btn_'.$data->id.'" style="display: none" ><i class="text-success bi bi-save2"></i></a>
                <a href="#" onclick="manageIpSetup('.$data->id.',2)" id="ip_save_btn_'.$data->id.'" style="display: none" ><i class="text-success bi bi-save2"></i></a>';

                return $button;
            })
            
            ->addColumn('name', function ($data) {
                if ($data->is_hr==1) {
                    $actAsHr = _trans('hrm.Acting as HR');
                    $hr_badge= @$data->name.' </br><small class="text-success">['. $actAsHr .']</small>';
                } else {
                    $hr_badge= @$data->name. "";
                }
                return @$hr_badge;
            })
           
            ->addColumn('email', function ($data) {
                $pin="";
                if(settings('login_method')=='pin') {
                    $login_data = $data->pin;
                }else{
                    $login_data = $data->email;
                }
                return @$login_data;
            })
            ->addColumn('phone', function ($data) {
                return @$data->phone;
            })
            ->addColumn('department', function ($data) {
                return @$data->department->title;
            })
            ->addColumn('designation', function ($data) {
                return @$data->designation->title;
            })
            ->addColumn('role', function ($data) {
                return @$data->role->name;
            })
            ->addColumn('ip_address', function ($data) {
                // return @$data->ip_address;
                // return '<input type="text"  class="form-control" value="'.$data->ip_address.'">';
                return '
                <span id="show_ip_'.$data->id.'">'.$data->ip_address.'</span>
                <input type="text" id="ip_edit_field_'.$data->id.'" name="ip_address" style="display: none" class="form-control" value="'.$data->ip_address.'">';
                
            })
            ->addColumn('ip_bind', function ($data) {
                $status = view('components.wizard.status-switch', ['id' => $data->id, 'name' => 'ip_bind', 'value' => $data->ip_bind, 'table' => 'users', 'change' => $data->ip_bind==1? 1 : 0]);

                return $status;
            })
            ->rawColumns(array('name', 'email', 'ip_bind', 'department', 'designation', 'role', 'ip_address', 'status', 'action'))
            ->make(true);
    }

    public function liveTrackingEmployee($request, $id = null)
    {
         $track = $this->model->query()->with('location_log')
                ->where('company_id', $this->companyInformation()->id)
                ->whereHas('location_log', function ($query) use ($request) {
                    $query->where('date', 'LIKE', $request->date . '%');
                })
                ->select('company_id', 'id','name')
                ->get();
        if ($track->count() > 0) {
            return $track;
        }else{
            return [
                0=>[
                    'name' => ' ',
                    'location_log' => [
                        'latitude' =>settings('default_latitude')??40.7127753,
                        'longitude' =>settings('default_longitude')??-74.0059728,
                        'address' =>'',
                    ],
                ]
               ];
        }

    }

    public function employeeLocationHistory($request, $id = null)
    {
        $logs =   DB::table('location_logs')
                    ->select('latitude','longitude','address as start_location','id','created_at')
                    ->where('company_id', $this->companyInformation()->id)
                    ->where('user_id', $request->user)
                    ->where('date', 'LIKE', $request->date . '%')
                    ->get();

        $data = [];
        $total = $logs->count();
        foreach ($logs as $key => $value) {
            if ($total > 25 ? ($key % ceil($total / 25)) == 0 || $key == 0 || $key == $total - 1 : true) {
                array_push($data, $value);
            }

        }
         return $data;

    }

    public function departmentWiseUser($request)
    {
        $users = $this->model->query()->where('company_id', $this->companyInformation()->id);
        $users = $users->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'name', 'email', 'phone', 'status_id');
        
        
        return datatables()->of($users->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $action_button .= actionButton('Profile', route('user.profile', [$data->id, 'official']), 'profile');


                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('name', function ($data) {
                return @$data->name;
            })
            ->addColumn('email', function ($data) {
                return @$data->email;
            })
            ->addColumn('phone', function ($data) {
                return @$data->phone;
            })
            ->addColumn('department', function ($data) {
                return $data->department->title;
            })
            ->addColumn('designation', function ($data) {
                return $data->designation->title;
            })
            ->addColumn('role', function ($data) {
                return $data->role->name;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('name', 'email', 'phone', 'department', 'designation', 'role', 'status', 'action'))
            ->make(true);
    }

    function verifyPin($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pin' => 'required|numeric',
            ]
        );
        
        //Format changed as app developer requirement [FC]
        if ($validator->fails()) {
            return $this->responseWithError($validator->errors()->first('pin'), $validator->errors(), 400);
        }
        $user = $this->model->query()->where('pin', $request->pin)->first();
        if ($user) {

                $jwt_token = null;
                if (!$jwt_token=JWTAuth::fromUser($user)) {
                    return $this->responseWithError(__('Invalid PIN'), [], 400);
                }
                Auth()->login($user);

                $checkUser['id'] = $user->id;
                $checkUser['company_id'] = $user->company_id;
                $checkUser['is_admin'] = auth()->user()->is_admin ? true : false;
                $checkUser['is_hr'] = auth()->user()->is_hr ? true : false;
                $checkUser['is_face_registered'] = auth()->user()->face_data ? true : false;
                $checkUser['name'] = $user->name;
                $checkUser['email'] = $user->email;
                $checkUser['phone'] = $user->phone;
                $checkUser['avatar'] = uploaded_asset($user->avatar_id);
                $checkUser['token'] = $jwt_token;

                $user->save();
                return $this->responseWithSuccess(__('Successfully Login'), $checkUser, 200);
        } else {
            return $this->responseWithError(__('User Not Found'), [], 400);
        }
    }
    function updateUserPin($request)
    {
        try {
            if ($request->user_id && is_Admin()) {
               $user_id=$request->user_id;
            } else {
               $user_id=auth()->user()->id;
            }
            
            $user = $this->model->query()->find($user_id);
            $user->pin = $request->pin;
            $user->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }

    }


}
