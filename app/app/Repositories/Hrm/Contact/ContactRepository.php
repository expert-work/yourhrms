<?php

namespace App\Repositories\Hrm\Contact;

use App\Models\Hrm\Contact;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class ContactRepository
{

    use AuthorInfoTrait, RelationshipTrait;

    protected $model;

    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->query()->get();
    }
    public function dataTable($request)
    {
        $content = $this->model->query();
        if (@$request->from && @$request->to) {
            $content = $content->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }

        return datatables()->of($content->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                if (hasPermission('leave_type_update')) {
                    $action_button .= '<a href="' . route('content.edit', $data->id) . '" class="dropdown-item"> Edit</a>';
                }
                if (hasPermission('leave_type_delete')) {
                    $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/settings/content/delete/`)', 'delete');
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
            ->addColumn('title', function ($data) {
                return @$data->title;
            })
            ->addColumn('slug', function ($data) {
                return @$data->slug;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('title', 'slug', 'status', 'action'))
            ->make(true);
    }
}