<?php

namespace App\Http\Controllers\Backend\Performance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Performance\GoalType;
use Brian2694\Toastr\Facades\Toastr;
use App\Services\Performance\GoalTypeService;

class GoalTypeController extends Controller
{
    protected $service;
    public function __construct(GoalTypeService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['title']     = _trans('performance.Goal Type List');
            $data['table']     = route('performance.goal_type.table');
            $data['url_id']    = 'goal_type_table_url';
            $data['fields']    = $this->service->fields();
            $data['class']     = 'goal_type_table_class';
            return view('backend.performance.goal.type.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function table(Request $request)
    {
        return $this->service->table($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $data['title']     = _trans('award.Create Competence Type');
            $data['url']       = (hasPermission('performance_goal_type_store')) ? route('performance.goal_type.store') : '';
            @$data['button']   = _trans('common.Save');
            return view('backend.performance.goal.type.createModal', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

 
    public function store(Request $request)
    {
        try {
            $result = $this->service->store($request);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('performance.goal_type.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Performance\Goal  $Goal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try {
            $data['edit']      = $this->service->where([
                'id' => $id,
                'company_id' => auth()->user()->company_id
            ])->first();
            if (blank($data['edit'])) {
                Toastr::error(_translate('response.Data not found!'), 'Error');
                return redirect()->back();
            }
            $data['title']     = _trans('award.Edit Goal Type');
            $data['url']       = (hasPermission('performance_goal_type_update')) ? route('performance.goal_type.update', $id) : '';
            @$data['button']   = _trans('common.Save');
            return view('backend.performance.goal.type.createModal', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $result = $this->service->update($request, $id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('performance.goal_type.index');
            } else {
                Toastr::error($result->original['message'], 'Error');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Performance\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $result = $this->service->delete($id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('performance.goal_type.index');
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
