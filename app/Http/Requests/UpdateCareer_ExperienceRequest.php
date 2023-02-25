<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCareer_ExperienceRequest extends FormRequest
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
            'user_id'=>[
                'nullable',
                'integer',
                'max:255',
                'exists:users,id'
            ],

            'company_name'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'job_title'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'employee_type_id'=>[
                'nullable',
                'integer',
                'max:255',
                'exists:employee_types,id'
            ],

            'location'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'start_date'=>[
                'nullable',
                'date',
                'max:255',
            ],

            'end_date'=>[
                'nullable',
                'date',
                'max:255',
            ],

            'job_description'=>[
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
