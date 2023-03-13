<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateMidyear_EvaluationRequest extends FormRequest
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
                'nullable',
                'integer',
                'exists:users,id'
            ],

            'goal_id.*' => [
                'nullable',
                'integer',
                'exists:goals,id'
            ],
            'midyear_realization.*' => [
                'nullable',
                'string',
                'max:255',
            ],
            'midyear_employee_comment.*' => [
                'nullable',
                'string',
            ],
            'midyear_manager_comment.*' => [
                'nullable',
                'string',
            ],
        ];
    }
}
