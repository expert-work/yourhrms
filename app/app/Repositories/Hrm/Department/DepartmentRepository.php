<?php

namespace App\Repositories\Hrm\Department;

use Illuminate\Support\Facades\Log;
use App\Models\Traits\RelationCheck;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cache;
use App\Models\Hrm\Department\Department;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class DepartmentRepository
{

    use AuthorInfoTrait, RelationshipTrait,RelationCheck;

    protected Department $department;
    protected $model;

    public function __construct(Department $department, Department $model)
    {
        $this->department = $department;
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->query()->where('company_id', $this->companyInformation()->id)->get();
    }

    public function index()
    {
    }

    public function store($request): bool
    {
        $this->department->query()->create($request->all());
        return true;
    }

    public function dataTable($request, $id = null)
    {
        $department = $this->department->query()->with('status','users')->where('company_id', $this->companyInformation()->id);
        if (@$request->from && @$request->from != NULL && @$request->to &&  !is_null($request->to)) {
            $department = $department->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }
        if (@$id) {
            $department = $department->where('id', $id);
        }

        return datatables()->of($department->latest()->get())
            ->addColumn('action', function ($data) {

                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                if (hasPermission('department_update')) {
                    $action_button .= '<a href="' . route('department.edit', $data->id) . '" class="dropdown-item"> '.$edit.'</a>';
                }
                if (hasPermission('department_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/department/delete/`)', 'delete');
                }
                $button = getActionButtons($action_button);
                return $button;
            })
            ->addColumn('title', function ($data) {
                return @$data->title;
            })
            ->addColumn('employees', function ($data) {
                $str = '';
                $left_count = 0;

                foreach ($data->users->take(3) as $user) {
                    $str .= '<img src="' . uploaded_asset($user->avatar_id) . '" width="50px" height="50px" class="img-circle __img-border" alt="User Image">';
                }
                if ($data->users->count() > 3) {
                    $left_count = $data->users->count() - 3;
                    $str .= '<br>';
                }
                if ($left_count > 0) {
                    $str .= '<span class=" __employee_count">+' . $left_count . ' more peoples</span>';
                }
                return $str;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('title', 'employees', 'status', 'action'))
            ->make(true);
    }

    public function show($department)
    {
        return $department;
    }

    public function update($request): bool
    {
        $department = $this->department->query()->where('id', $request->department_id)->first();
        $department->title = $request->title;
        $department->status_id = $request->status_id;
        $department->save();
        return true;
    }

    public function destroy($department)
    {

        $table_name=$this->department->getTable();
        $foreign_id= \Illuminate\Support\Str::singular($table_name).'_id';
        return \App\Services\Hrm\DeleteService::deleteData($table_name, $foreign_id, $department->id);

    }
}
