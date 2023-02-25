<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCareer_ExperienceRequest extends FormRequest
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
                'required',
                'integer',
                'exists:users,id'
            ],

            'company_name'=>[
                'required',
                'string',
                'max:255',
            ],

            'job_title'=>[
                'required',
                'string',
                'max:255',
            ],

            'employee_type_id'=>[
                'required',
                'integer',
                'exists:employee_types,id'
            ],

            'location'=>[
                'required',
                'string',
                'max:255',
            ],

            'start_date'=>[
                'required',
                'date',
                'max:255',
            ],

            'end_date'=>[
                'required',
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
