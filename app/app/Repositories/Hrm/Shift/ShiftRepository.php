<?php

namespace App\Repositories\Hrm\Shift;

use function route;
use function datatables;
use function actionButton;
use function start_end_datetime;
use App\Models\Traits\RelationCheck;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Hrm\Designation\Designation;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Hrm\Shift\Shift;

class ShiftRepository
{
    use AuthorInfoTrait, RelationshipTrait,RelationCheck;

    protected Shift $shift;

    public function __construct(Shift $shift)
    {
        $this->shift = $shift;
    }

    public function getAll()
    {
        return $this->shift::query()->where('company_id', $this->companyInformation()->id)->get();
    }

    public function index()
    {
    }

    public function store($request)
    {
        $company = $this->shift->query()->create($request->all());
        $this->createdBy($company);
        return true;
    }

    public function dataTable($request, $id = null)
    {
        $shift = $this->shift->query()->with('status')->where('company_id', $this->companyInformation()->id);
        if (@$request->from && @$request->to) {
            $shift = $shift->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }
        if (@$id) {
            $shift = $shift->where('id', $id);
        }

        return datatables()->of($shift->orderBy('id', 'DESC')->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                if (hasPermission('shift_update')) {
                    $action_button .= '<a href="' . route('shift.edit', $data->id) . '" class="dropdown-item"> '. $edit .'</a>';
                }
                if (hasPermission('shift_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/shift/delete/`)', 'delete');
                }
                $button = getActionButtons($action_button);
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

    public function show($id)
    {

    }


    public function update($request): bool
    {
        $shift = $this->shift->where('id', $request->shift_id)->first();
        $shift->name = $request->name;
        $shift->status_id = $request->status_id;
        $shift->save();
        $this->updatedBy($shift);
        return true;
    }

    public function destroy($shift)
    {
        $table_name=$this->shift->getTable();
        $foreign_id= \Illuminate\Support\Str::singular($table_name).'_id';
        return \App\Services\Hrm\DeleteService::deleteData($table_name, $foreign_id, $shift->id);
    }
}
