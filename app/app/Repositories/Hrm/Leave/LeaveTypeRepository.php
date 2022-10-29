<?php

namespace App\Repositories\Hrm\Leave;

use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Hrm\Leave\LeaveType;

class LeaveTypeRepository
{
    use AuthorInfoTrait, RelationshipTrait;

    protected LeaveType $leaveType;

    public function __construct(LeaveType $leaveType)
    {
        $this->leaveType = $leaveType;
    }

    public function getAll()
    {
        return $this->leaveType->query()->where('company_id', $this->companyInformation()->id)->where('status_id', 1)->get();
    }

    public function index()
    {
    }

    public function dataTable($request, $id = null)
    {
        $leaveType = $this->leaveType->query()->where('company_id', $this->companyInformation()->id);
        if (@$request->from && @$request->to) {
            $leaveType = $leaveType->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }
        if (@$id) {
            $leaveType = $leaveType->where('id', $id);
        }

        return datatables()->of($leaveType->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                if (hasPermission('leave_type_update')) {
                    $action_button .= '<a href="' . route('leave.edit', $data->id) . '" class="dropdown-item"> '.$edit.'</a>';
                }
                if (hasPermission('leave_type_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/leave/delete/`)', 'delete');
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
                return @$data->name;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('name', 'status', 'action'))
            ->make(true);
    }

    public function store($request)
    {
        return $this->leaveType->create($request->all());
    }

    public function show($id)
    {
        return $this->leaveType->find($id);
    }

    public function update($request)
    {
        $this->leaveType->where('id', $request->type_id)->update([
            'name' => $request->name,
            'status_id' => $request->status_id,
        ]);
        return true;
    }

    public function destroy($id)
    {
        $table_name=$this->leaveType->getTable();
        $foreign_id= \Illuminate\Support\Str::singular($table_name).'_id';
        return \App\Services\Hrm\DeleteService::deleteData($table_name, $foreign_id, $id);
    }

}
