<?php

namespace App\Http\Controllers\Backend\Performance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Performance\Appraisal;
use App\Models\Performance\CompetenceType;
use App\Services\Performance\AppraisalService;

class AppraisalController extends Controller
{
    protected $service;
    public function __construct(AppraisalService $service)
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
            $data['title']     = _trans('performance.Appraisal List');
            $data['table']     = route('performance.appraisal.table');
            $data['url_id']    = 'appraisal_table_url';
            $data['fields']    = $this->service->fields();
            $data['class']     = 'appraisal_table_class';
            return view('backend.performance.appraisal.index', compact('data'));
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
            $data['title']         = _trans('performance.Create Appraisal');
            $data['url']           = (hasPermission('performance_appraisal_store')) ? route('performance.appraisal.store') : '';
            $data['competence_types']   = CompetenceType::with('competencies')->where(['company_id' => auth()->user()->company_id])->get();
            @$data['button']   = _trans('common.Save');
            return view('backend.performance.appraisal.createModal', compact('data'));
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
                return redirect()->route('performance.appraisal.index');
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
     * Display the specified resource.
     *
     * @param  \App\Models\Performance\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        try {
            $data['edit']               = $this->service->find($id);
            $data['title']              = _trans('performance.View Appraisal');
            $data['competence_types']   = CompetenceType::with('competencies')->where(['company_id' => auth()->user()->company_id])->get();
            return view('backend.performance.appraisal.viewModal', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Performance\Appraisal  $Appraisal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data['edit']               = $this->service->find($id);
            $data['title']              = _trans('performance.Edit Appraisal');
            $data['url']                = (hasPermission('performance_appraisal_update')) ? route('performance.appraisal.update', $id) : '';
            $data['competence_types']   = CompetenceType::with('competencies')->where(['company_id' => auth()->user()->company_id])->get();
            @$data['button']            = _trans('common.Update');
            return view('backend.performance.appraisal.editModal', compact('data'));
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
                return redirect()->route('performance.appraisal.index');
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
     * @param  \App\Models\Performance\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $result = $this->service->delete($id);
            if ($result->original['result']) {
                Toastr::success($result->original['message'], 'Success');
                return redirect()->route('performance.appraisal.index');
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
