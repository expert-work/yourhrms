<?php

namespace App\Http\Controllers\Backend\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Services\Management\FileService;
use Illuminate\Support\Facades\Response;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Services\Management\ProjectService;

class FileController extends Controller
{
    use FileHandler;

    protected $fileService;
    protected $projectService;

    public function __construct(FileService $fileService, ProjectService $projectService)
    {
        $this->fileService = $fileService;
        $this->projectService    = $projectService;
    }

    public function create(Request $request)
    {
        try {
            $result       = $this->projectService->where([
                'id' => $request->project_id,
                'company_id' => auth()->user()->company_id,
            ])->first();
            if (@$result) {
                $data['title']    = _trans('project.Create File');
                $data['view']     = $result;
                $data['url']      = (hasPermission('project_files_store')) ? route('project.file.store', 'project_id=' . $request->project_id) : '';
                $data['button']   = _trans('common.Submit');
                return view('backend.project.file.createModal', compact('data'));
            } else {
                return response()->json('fail');
            }
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    public function store(Request $request)
    {
        try {
            $result = $this->fileService->store($request);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('project.view', [$request->project_id, 'files']);
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function comment(Request $request)
    {
        try {
            return $this->fileService->commentStore($request);
        } catch (\Throwable $th) {
            return $this->responseExceptionError($th->getMessage(), [], 400);
        }
    }


    // file datatable 
    public function datatable(Request $request, $id)
    {
        return $this->fileService->table($request, $id);
    }

    // file download
    public function download(Request $request)
    {
        try {

            $result       = $this->fileService->where([
                'id' => $request->file_id,
                'company_id' => auth()->user()->company_id,
                'project_id' => $request->project_id,
            ])->first();
            if (@$result) {
                return $this->downloadFile($result->attachment?? null, $result->subject);
            } else {
                Toastr::error(_trans('response.Something went wrong.'), 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->fileService->delete($id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('project.view', [$result->original['data']->project_id, 'files']);
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }
}
