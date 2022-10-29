<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Role\RoleRequest;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Role\Role;
use App\Repositories\Admin\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class RoleController extends Controller
{
    use RelationshipTrait;

    protected RoleRepository $role;
    protected $model;

    public function __construct(RoleRepository $roleRepository, Role $model)
    {
        $this->role = $roleRepository;
        $this->model = $model;
    }

    public function index()
    {
        $data['title'] = _trans('common.Roles');
        return view('backend.roles.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('common.Add Role');
        $data['permissions'] = $this->role->getPermission();
        return view('backend.roles.create', compact('data'));
    }

    public function store(RoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            if ($this->isExistsWhenStore($this->model, 'name', $request->name)) {
                $request['company_id'] = $this->companyInformation()->id;
                $this->role->store($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('roles.index');
            } else {
                Toastr::error("{$request->name} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function dataTable(Request $request): object
    {
        return $this->role->dataTable($request);
    }

    public function show($id)
    {
        return $this->role->show($id);
    }

    public function edit(Role $role)
    {
        $data['title'] = 'Edit Role';
        $data['role'] = $role;
        $data['permissions'] = $this->role->getPermission();
        return view('backend.roles.edit', compact('data'));
    }

    public function update(RoleRequest $request, Role $role): \Illuminate\Http\RedirectResponse
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            if ($this->isExistsWhenUpdate($role, $this->model, 'name', $request->name)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['role_id'] = $role->id;
                $this->role->update($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('roles.index');
            } else {
                Toastr::error("{$request->name} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(__translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        return  $this->role->destroy($id);
    }

    public function changeRole(Request $request)
    {
        $data['role_permissions'] = $this->role->get($request->role_id)->permissions;
        $data['permissions'] = $this->role->getPermission();
        return view('backend.user.permissions', compact('data'));
    }
}
