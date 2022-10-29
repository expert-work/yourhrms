<?php

namespace App\Repositories\Hrm\Designation;

use function route;
use function datatables;
use function actionButton;
use function start_end_datetime;
use App\Models\Traits\RelationCheck;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Hrm\Designation\Designation;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class DesignationRepository
{
    use AuthorInfoTrait, RelationshipTrait,RelationCheck;

    protected Designation $designation;

    public function __construct(Designation $designation)
    {
        $this->designation = $designation;
    }

    public function getAll()
    {
        return $this->designation::query()->where('company_id', $this->companyInformation()->id)->get();
    }

    public function index()
    {
    }

    public function store($request)
    {
        $company = $this->designation->query()->create($request->all());
        $this->createdBy($company);
        return true;
    }

    public function dataTable($request, $id = null)
    {
        $designation = $this->designation->query()->with('status')->where('company_id', $this->companyInformation()->id);
        if (@$request->from && @$request->to) {
            $designation = $designation->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }
        if (@$id) {
            $designation = $designation->where('id', $id);
        }

        return datatables()->of($designation->orderBy('id', 'DESC')->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                if (hasPermission('designation_update')) {
                    $action_button .= '<a href="' . route('designation.edit', $data->id) . '" class="dropdown-item"> '.$edit.'</a>';
                }
                if (hasPermission('designation_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/designation/delete/`)', 'delete');
                }
                $button = getActionButtons($action_button);
                return $button;
            })
            ->addColumn('title', function ($data) {
                return @$data->title;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('title', 'status', 'action'))
            ->make(true);
    }

    public function show($id)
    {

    }


    public function update($request): bool
    {
        $designation = $this->designation->where('id', $request->designation_id)->first();
        $designation->title = $request->title;
        $designation->status_id = $request->status_id;
        $designation->save();
        // $this->updatedBy($designation);
        return true;
    }

    public function destroy($designation)
    {
        $table_name=$this->designation->getTable();
        $foreign_id= \Illuminate\Support\Str::singular($table_name).'_id';
        return \App\Services\Hrm\DeleteService::deleteData($table_name, $foreign_id, $designation->id);


    }
}
