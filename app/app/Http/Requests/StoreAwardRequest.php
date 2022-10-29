<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAwardRequest extends FormRequest
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
                'award_type' => 'required',
                'gift' => 'required',
                'date' => 'required',
                'status' => 'required',
                'award_info' => 'required',
                'amount' => 'required',
                'attachment' => 'required|mimes:jpeg,png,jpg|max:2048',
                'content' => 'required',
        ];
    }
}
