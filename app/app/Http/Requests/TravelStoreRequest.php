<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'travel_type' => 'required',
            'motive' => 'required',
            'place' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'mode' => 'required',
            'expect_amount' => 'required',
            'actual_amount' => 'required',
            'attachment' => 'sometimes|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'sometimes|required',
    ];
    }
}
