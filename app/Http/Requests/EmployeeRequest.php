<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:50',
            'secondary_name' => 'string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => [
                'required',
                Rule::in(['male', 'female']),
            ],
            'salary' => 'integer',
            "department_ids"    => "required|array|min:1",
            'department_ids.*' => 'required|integer|min:1|exists:App\Models\Department,id'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
