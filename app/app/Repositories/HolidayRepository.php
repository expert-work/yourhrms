<?php

namespace App\Repositories;

use App\Helpers\CoreApp\Traits\FileHandler;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Hrm\Attendance\Holiday;

class HolidayRepository
{
    use FileHandler, RelationshipTrait;

    protected Holiday $holiday;

    public function __construct(Holiday $holiday)
    {
        $this->holiday = $holiday;
    }

    public function index()
    {
        return $this->holiday->query()->with('status')->where('company_id', $this->companyInformation()->id)->get();
    }

    public function appScreen()
    {
        return $this->holiday->query()
            ->when(request()->has('month'), function ($query) {
                $query->where('start_date', 'LIKE', '%' . request('month') . '%');
            })
            ->when(!request()->has('month'), function ($query) {
                $query->where('start_date', '>=', date('Y-m-d'))->limit(5);
            })
            ->orderBy('start_date', 'ASC')
            ->get();
    }

    public function store($request)
    {
        if ($request->file) {
            $request['attachment_id'] = $this->uploadImage($request->file)->id;
        }
        $this->holiday->query()->create($request->all());
        return true;
    }

    public function update($request)
    {
        $holiday = $this->holiday->where('id', $request->holiday_id)->first();
        $holiday->title = $request->title;
        $holiday->description = $request->description;
        $holiday->start_date = $request->start_date;
        $holiday->end_date = $request->end_date;
        $holiday->status_id = $request->status_id;
        if ($request->file) {
            $request['attachment_id'] = $this->uploadImage($request->file)->id;
            $holiday->attachment_id = $request->attachment_id;
        }
        $holiday->save();
        return true;
    }

    public function delete($model): bool
    {
        $model->delete();
        return true;
    }


}
