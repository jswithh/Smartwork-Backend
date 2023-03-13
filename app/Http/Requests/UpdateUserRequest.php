<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'manager_id' => 'nullable|integer|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,',
            'password' => 'nullable|string|confirmed',
            'hrcode' => 'nullable|string',
            'gender' => 'nullable|string|in:MALE,FEMALE',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'birthday' => 'nullable|date',
            'birthplace' => 'nullable|string',
            'religion' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'dependent' => 'nullable|integer',
            'nationality' => 'nullable|string',
            'education' => 'nullable|string',
            'name_of_school' => 'nullable|string',
            'number_of_identity' => 'nullable|integer',
            'place_of_identity' => 'nullable|string',
            'branch' => 'nullable|string',
            'department_id' => 'nullable|integer|exists:department,id',
            'team_id' => 'nullable|integer|exists:teams,id',
            'job_level' => 'nullable|string',
            'employee_type' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }
}
