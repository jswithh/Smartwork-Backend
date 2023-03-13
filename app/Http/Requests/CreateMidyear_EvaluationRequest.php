<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateMidyear_EvaluationRequest extends FormRequest
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
            'user_id.*' => [
                'required',
                'integer',
                'exists:users,id'
            ],

            'goal_id.*' => [
                'required',
                'integer',
                'exists:goals,id'
            ],
            'midyear_realization.*' => [
                'required',
                'string',
                'max:255',
            ],
            'midyear_employee_comment.*' => [
                'required',
                'string',
            ],
            'midyear_manager_comment.*' => [
                'required',
                'string',
            ],
        ];
    }
}
