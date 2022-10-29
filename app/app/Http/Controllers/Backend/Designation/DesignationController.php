<?php

namespace App\Http\Controllers\Backend\Designation;

use Illuminate\Http\Request;
use App\Models\Company\Company;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DesignationReqeust;
use App\Models\Hrm\Designation\Designation;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Designation\DesignationRepository;

class DesignationController extends Controller
{

    use RelationshipTrait;

    protected DesignationRepository $designation;
    protected $model;

    public function __construct(DesignationRepository $designation, Designation $model)
    {
        $this->designation = $designation;
        $this->model = $model;
    }

    public function index()
    {
        $data['title'] = _trans('common.Designations');
        return view('backend.designation.index', compact('data'));
    }


    public function create()
    {
        $data['title'] = _trans('common.Add Designation');
        return view('backend.designation.create', compact('data'));
    }


    public function store(DesignationReqeust $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($this->isExistsWhenStore($this->model, 'title', $request->title)) {
                $request['company_id'] = $this->companyInformation()->id;
                $this->designation->store($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('designation.index');
            } else {
                Toastr::error("{$request->title} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function dataTable(Request $request)
    {
        return $this->designation->dataTable($request);
    }


    public function show(Designation $designation): Designation
    {
        return $designation;
    }

    public function edit(Designation $designation)
    {
        $data['title'] = _trans('common.Edit designation');
        $data['designation'] = $designation;
        return view('backend.designation.edit', compact('data'));
    }

    public function update(DesignationReqeust $request, Designation $designation): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($this->isExistsWhenUpdate($designation, $this->model, 'title', $request->title)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['designation_id'] = $designation->id;
                $this->designation->update($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('designation.index');
            } else {
                Toastr::error("{$request->title} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function delete(Designation $designation)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        return $this->designation->destroy($designation);
    }
}
