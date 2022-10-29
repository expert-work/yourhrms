<?php

namespace App\Repositories\Hrm\Content;

use App\Models\Content\AllContent;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class AllContentRepository
{

    use AuthorInfoTrait, RelationshipTrait,FileHandler;

    protected AllContent $content;
    protected $model;

    public function __construct(AllContent $content, AllContent $model)
    {
        $this->content = $content;
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->query()->where('company_id', 1)->get();
    }

    public function getContent($slug)
    {
        return $this->model->query()->where('company_id', 1)->where('slug',$slug)->get();
    }

    public function index()
    {
    }

    public function store($request): bool
    {
        $this->content->query()->create($request->all());
        return true;
    }

    public function dataTable($request, $id = null)
    {
        $content = $this->content->query()->where('company_id', 1);
        if (@$request->from && @$request->to) {
            $content = $content->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }

        return datatables()->of($content->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                if (hasPermission('content_update')) {
                    $action_button .= '<a href="' . route('content.edit', $data->id) . '" class="dropdown-item"> '.$edit.'</a>';
                }
                // if (hasPermission('leave_type_delete')) {
                //     $action_button .= actionButton('Delete', '__globalDelete(' . $data->id . ',`admin/settings/content/delete/`)', 'delete');
                // }
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

    public function show($content)
    {
        return $content;
    }

    public function update($request, $content)
    {
        $content = $this->content->query()->where('id', $content->id)->first();
        $content->title = $request->title;
        $content->content = $request->content;

        $content->meta_title = $request->meta_title;
        $content->meta_description = $request->meta_description;
        $content->keywords = $request->keywords;
        if ($request->hasFile('meta_image')) {
            $filePath = $this->uploadImage($request->meta_image, 'uploads/frontent');
            $content->meta_image = $filePath ? $filePath->id : null;
        }
        $content->save();
        return true;
    }

    public function destroy($content)
    {
        // return $content->delete();

        $table_name=$this->model->getTable();
        $foreign_id= \Illuminate\Support\Str::singular($table_name).'_id';
        return \App\Services\Hrm\DeleteService::deleteData($table_name, $foreign_id, $content->id);
    }
}
