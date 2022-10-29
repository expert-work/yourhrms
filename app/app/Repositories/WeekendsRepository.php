<?php

namespace App\Repositories;

use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Hrm\Attendance\Weekend;

class WeekendsRepository
{
    use RelationshipTrait;

    protected $model;

    public function __construct(Weekend $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->query()->with('status')->where('company_id', $this->companyInformation()->id)->get();
    }

    public function update($request)
    {
        $this->model->where('id', $request->weekend_id)->update([
            'is_weekend' => $request->is_weekend,
            'status_id' => $request->status_id
        ]);
    }
}
