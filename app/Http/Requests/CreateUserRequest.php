<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Rules\Password;

class CreateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password],
                'hrcode' => ['nullable', 'string', 'unique:users' ],
                'gender' => 'nullable|string|in:MALE,FEMALE',
                'addres' => ['nullable', 'string' ],
                'phone' => ['nullable', 'string' ],
                'birthday' => ['nullable', 'dateTime' ],
                'birthplace' => ['nullable', 'string' ],
                'religion' => ['nullable', 'string' ],
                'nationality' => ['nullable', 'string' ],
                'marital_status' => ['nullable', 'string' ],
                'dependent' => ['nullable', 'string' ],
                'education' => ['nullable', 'string' ],
                'name_of_school' => ['nullable', 'string' ],
                'number_of_identity' => ['nullable', 'integer' ],
                'place_of_identity' => ['nullable', 'string' ],
                'branch' => ['nullable', 'string' ],
                'department_id' => ['required', 'integer' ],
                'team_id' => ['required', 'integer' ],
                'job_level' => ['nullable', 'string' ],
                'employee_type' => ['nullable', 'string' ],
                'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => ['nullable', 'boolean' ],

        ];
    }
}
