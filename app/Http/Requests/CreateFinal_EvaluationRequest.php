<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateFinal_EvaluationRequest extends FormRequest
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

            'midyear_id.*' => [
                'nullable',
                'integer',
                'exists:midyear_evaluations,id'
            ],

            'final_realization.*' => [
                'required',
                'string',
                'max:255',
            ],

            'final_goal_status.*' => [
                'required',
                'string',
                'max:255',
            ],

            'final_employee_score.*' => [
                'required',
                'string',
                'max:255',
            ],

            'final_manager_score.*' => [
                'nullable',
                'string',
                'max:255',
            ],

            'final_employee_behavior.*' => [
                'required',
                'string',
                'max:255',
            ],

            'final_manager_behavior.*' => [
                'nullable',
                'string',
                'max:255',
            ],

            'final_manager_comment.*' => [
                'nullable',
                'string',
            ],

            'final_employee_comment.*' => [
                'required',
                'string',
            ],


        ];
    }
}
