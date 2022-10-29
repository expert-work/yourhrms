<?php

namespace App\Http\Controllers\coreApp\Setting;

use function view;
use App\Models\User;
use function config;
use function request;
use function session;
use function redirect;
use function __translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Permission\Permission;
use App\Models\coreApp\Setting\Setting;
use App\Models\Database\DatabaseBackup;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\PermissionTrait;
use App\Repositories\Settings\SettingRepository;
use App\Repositories\Hrm\Leave\LeaveSettingRepository;
use App\Repositories\Settings\CompanyConfigRepository;

class SettingsController extends Controller
{

    use FileHandler,PermissionTrait;

    protected LeaveSettingRepository $leaveSetting;
    protected $settingRepo;
    protected $companyConfigRepo;

    public function __construct(LeaveSettingRepository $leaveSettingRepository, SettingRepository $settingRepo, CompanyConfigRepository $companyConfigRepo)
    {
        $this->leaveSetting = $leaveSettingRepository;
        $this->settingRepo = $settingRepo;
        $this->companyConfigRepo = $companyConfigRepo;
    }

    public function index()
    {
        try {
            $data['title'] = _trans('settings.Settings');
            $data['databases'] = DatabaseBackup::orderByDesc('id')->get();
            return view('backend.settings.general.settings', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function leaveSettings()
    {
        try {
            $data['title'] = _trans('leave.Leave');
            $data['leaveSetting'] = $this->leaveSetting->getLeaveSetting();
            return view('backend.settings.leave_settings.index', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function leaveSettingsEdit()
    {
        try {
            $data['title'] = _trans('leave.Leave');
            $data['leaveSetting'] = $this->leaveSetting->getLeaveSetting();
            return view('backend.settings.leave_settings.edit', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function emailSetup(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request = $request->except('_token');
        try {
            foreach ($request as $key => $value) {
                $company_config = \App\Models\coreApp\Setting\Setting::firstOrNew(array('name' => $key));
                $company_config->value = $value;
                $company_config->save();

                putEnvConfigration($key, $value);
            }
            Toastr::success(_trans('settings.Email settings updated successfully'), 'Success');
            return redirect('/admin/settings/list?email_setup=true');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function storageSetup(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request = $request->except('_token');
        try {
            foreach ($request as $key => $value) {
                // return $key ."-". $value;
                $company_config = \App\Models\coreApp\Setting\Setting::firstOrNew(array('name' => $key));
                $company_config->value = $value;
                $company_config->save();

                putEnvConfigration($key, $value);
            }
            Toastr::success(_trans('settings.Storage settings updated successfully'), 'Success');
            return redirect('/admin/settings/list?storage_setup=true');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function leaveSettingsUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $this->leaveSetting->settingUpdate($request);
            Toastr::success(_trans('settings.Settings updated successfully'), 'Success');
            return redirect()->route('leaveSettings.view');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $settings = request()->except('_token');
            $i = 0;
            foreach ($settings as $key => $item) {
                $new_setup = Setting::where('name', $key)->where('company_id', auth()->user()->company_id)->first();
                if (!$new_setup) {
                    $new_setup = new Setting;
                }
                $new_setup->name = $key;
                $new_setup->value = $item;
                $new_setup->company_id = auth()->user()->company_id;
                $new_setup->save();
                //upgrade base app settings
                config()->set("settings.app.{$key}", $item);
                //change language
                if ($key == 'language') {
                    App::setLocale($item);
                    session()->put('locale', $item);
                }
                if (request()->file($key)) {
                    $settings[$key] = $this->saveImage(request()->file($key), 'uploads/settings/logo');
                    Setting::where('name', $key)->update([
                        'value' => $settings[$key]->path
                    ]);
                }
                $i++;
            }
            Toastr::success(_trans('settings.Settings updated successfully'), 'Success');
            return redirect('/admin/settings/list?general_setting=true');
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    public function permissionUpdate()
    {
        try {
            $delete_existing_permissions = Permission::truncate();
            $attributes = $this->adminRolePermissions();
            $user_permission_array=[];
            foreach ($attributes as $key => $attribute) {
                $permission = new Permission;
                $permission->attribute = $key;
                $permission->keywords = $attribute;
                $permission->save();
                foreach ($attribute as $key => $value) {
                    $user_permission_array[]= $value;
                }  
            }
            $admin_permission=User::find(auth()->user()->id);
            $admin_permission->permissions=$user_permission_array;
            $admin_permission->save();
            Toastr::success(_trans('settings.Permission updated successfully'), 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
        
    }
    public function chengeStatus(Request $request)
    {
        try {
            $column_name=$request->column_name;
            $select=DB::table($request->table_name)->where('id',$request->id)->first();
            $set_value=[
                $column_name => $request->value
            ];
            $find_row=DB::table($request->table_name)->where('id',$request->id)->update($set_value);
            
            $response = array(

                'value' => $request->value,
                'change' => $request->value==1?0:1,
                'id' => $request->id,
                'update_status' => $request->value,
                'status' => _trans('message.Success'),
                'msg' => _trans('message.Changed successfully'),
            );
            return $response;

        } catch (\Throwable $th) {
          return $th->getMessage();
        }
    }


}

