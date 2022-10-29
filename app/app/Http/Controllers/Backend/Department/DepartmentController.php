<?php

namespace App\Http\Controllers\Backend\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\DepartmentReqeust;
use App\Models\Hrm\Department\Department;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Department\DepartmentRepository;

class DepartmentController extends Controller
{

    use AuthorInfoTrait, RelationshipTrait;

    protected DepartmentRepository $department;
    protected $model;

    public function __construct(DepartmentRepository $department, Department $model)
    {
        $this->department = $department;
        $this->model = $model;
    }

    public function index()
    {
        $data['title'] = _trans('common.Departments');
        return view('backend.department.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('common.Add Department');
        return view('backend.department.create', compact('data'));
    }

    public function store(DepartmentReqeust $request): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($this->isExistsWhenStore($this->model, 'title', $request->title)) {
                $request['company_id'] = $this->companyInformation()->id;
                $this->department->store($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('department.index');
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
        return $this->department->dataTable($request);
    }

    public function show(Department $department): Department
    {
        return $department;
    }

    public function edit(Department $department)
    {
        $data['title'] = _trans('common.Edit department');
        $data['department'] = $department;
        return view('backend.department.edit', compact('data'));
    }


    public function update(DepartmentReqeust $request, Department $department): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($this->isExistsWhenUpdate($department, $this->model, 'title', $request->title)) {
                $request['company_id'] = $this->companyInformation()->id;
                $request['department_id'] = $department->id;
                $this->department->update($request);
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->route('department.index');
            } else {
                Toastr::error("{$request->title} already exists", 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error(__translate('Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function delete(Department $department): \Illuminate\Http\RedirectResponse
    {
        if (demoCheck()) {
            return redirect()->back();
        } 
       return  $this->department->destroy($department);
      
    }
}
