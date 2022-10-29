<?php

namespace App\Repositories\Admin;

use App\Models\Role\Role;
use Illuminate\Support\Str;
use App\Services\Hrm\DeleteService;
use App\Models\Traits\RelationCheck;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Permission\Permission;
use Illuminate\Support\Facades\Cache;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class RoleRepository
{
    use AuthorInfoTrait, RelationshipTrait,RelationCheck;

    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function get($id)
    {
        return $this->role->query()->where('company_id', $this->companyInformation()->id)->findOrFail($id);
    }

    public function getAll()
    {
        return Cache::rememberForever('all_roles', function () {
            return $this->role->query()->where('company_id', $this->companyInformation()->id)->where('status_id', 1)->where('id', '!=', '1')->get();
        });

    }

    public function getPermission()
    {
        return Permission::get();
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function dataTable($request, $id = null)
    {
        $roles = $this->role->query()->where('company_id', $this->companyInformation()->id)->with('status')->where('id', '!=', '1');
        if (@$request->from && @$request->to) {
            $roles = $roles->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }
        if (@$id) {
            $roles = $roles->where('id', $id);
        }

        return datatables()->of($roles->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                if (hasPermission('role_update')) {
                    $action_button .= '<a href="' . route('roles.edit', $data->id) . '" class="dropdown-item"> '.$edit.'</a>';
                }
                if (hasPermission('role_delete')) {
                    
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/roles/delete/`)', 'delete');
                }
                if ($data->is_system==0) {
                    $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                } else {
                    $button = '<span class="badge badge-danger">' ._trans('common.Restricted') . '</span>';
                }
                return $button;
            })
            ->addColumn('name', function ($data) {
                return @$data->name;
            })
            ->addColumn('permissions', function ($data) {
                return $data->permissions != null ? count($data->permissions) : 0;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('name', 'status', 'action'))
            ->make(true);
    }

    public function store($request)
    {
        $request['slug'] = Str::slug($request->name, '-');
        $this->role->query()->create($request->all());
    }

    public function show($id)
    {
        return $this->role->query()->find($id);
    }

    public function update($request)
    {
        $request['slug'] = Str::slug($request->name, '-');
        $this->role->query()->where('id', $request->role_id)->update($request->only(['name', 'slug', 'status_id', 'permissions']));
        return true;
    }

    public function destroy($id)
    {
        $foreign_id= \Illuminate\Support\Str::singular($this->role->getTable()).'_id';
        return \App\Services\Hrm\DeleteService::deleteData($this->role->getTable(), $foreign_id, $id);
    }

}
