<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'client_id' => ['required'],
            'progress' => ['required'],
            'status' => ['required'],
            'billing_type' => ['required'],
            'estimated_hour' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'priority' => ['required'],
            'content' => ['required'],
        ];
    }
}
