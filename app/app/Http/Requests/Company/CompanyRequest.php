<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required',
                    'company_name' => 'required',
                    'email' => 'required|email|unique:companies,email',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|unique:companies,phone',
                    'phone' => 'required|unique:users,phone',
                    'total_employee' => 'required',
                    'business_type' => 'required',
                    'trade_licence_number' => 'required',
                    'status_id' => 'required',
                ];
            }
            case 'PATCH':
            {
                return [
                    'name' => 'required',
                    'company_name' => 'required',
                    'email' => 'required|email|unique:companies,email,' . $this->company->id,
                    'email' => 'required|email|unique:users,email,' . $this->company->user->id,
                    'phone' => 'required|unique:companies,phone,' . $this->company->id,
                    'phone' => 'required|unique:users,phone,' . $this->company->user->id,
                    'total_employee' => 'required',
                    'business_type' => 'required',
                    'trade_licence_number' => 'required',
                    'status_id' => 'required',
                ];
            }
            default:
                break;
        }
    }
}
