<?php

namespace App\Http\Requests\coreApp\User;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
            'name' => 'required|max:250',
            'phone' => 'required|unique:users,phone,' . \request()->get('id'),
            'email' => 'required|unique:users,email,' . \request()->get('id'),
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:25000'
        ];
    }
}
