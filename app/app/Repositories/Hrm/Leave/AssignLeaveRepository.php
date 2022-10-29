<?php

namespace App\Repositories\Hrm\Leave;

use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Hrm\Leave\AssignLeave;

class AssignLeaveRepository
{
    use RelationshipTrait;

    protected AssignLeave $assignLeave;

    public function __construct(AssignLeave $assignLeave)
    {
        $this->assignLeave = $assignLeave;
    }

    public function index()
    {
    }

    public function dataTable($request, $id = null)
    {
        $assignLeave = $this->assignLeave->query()->where('company_id', $this->companyInformation()->id); 
        if (@$request->department_id) {
            $assignLeave = $assignLeave->where('department_id', $request->department_id);
        }
        if (@$id) {
            $assignLeave = $assignLeave->where('id', $id);
        }

        return datatables()->of($assignLeave->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                if (hasPermission('leave_assign_update')) {
                    $action_button .= '<a href="' . route('assignLeave.edit', $data->id) . '" class="dropdown-item"> '.$edit.'</a>';
                }
                if (hasPermission('leave_assign_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/leave/assign/delete/`)', 'delete');
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
            ->addColumn('days', function ($data) {
                return @$data->days;
            })
            ->addColumn('department', function ($data) {
                return @$data->department->title;
            })
            ->addColumn('type', function ($data) {
                return @$data->type->name;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('days', 'department', 'type', 'status', 'action'))
            ->make(true);
    }

    public function store($request): bool
    {
        foreach ($request->department_id as $key => $item) {
            if ($this->isExistsWhenStoreMultipleColumn($this->assignLeave, 'department_id', 'type_id', $item, $request->type_id)) {
                $this->assignLeave->query()->create([
                    'company_id' => $this->companyInformation()->id,
                    'department_id' => $item,
                    'type_id' => $request->type_id,
                    'days' => $request->days,
                    'status_id' => $request->status_id,
                ]);
            }
        }
        return true;
    }

    public function show($id): object
    {
        return $this->assignLeave->query()->find($id);
    }

    public function update($request)
    {
        $this->assignLeave->query()->where('id', $request->id)->update([
            'company_id' => $this->companyInformation()->id,
            'department_id' => $request->department_id,
            'type_id' => $request->type_id,
            'days' => $request->days,
            'status_id' => $request->status_id,
        ]);
        return true;
    }

    public function destroy($id)
    {
        $table_name=$this->assignLeave->getTable();
        $foreign_id= \Illuminate\Support\Str::singular($table_name).'_id';
        return \App\Services\Hrm\DeleteService::deleteData($table_name, $foreign_id, $id);
    }
}
