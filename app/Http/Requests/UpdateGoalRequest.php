<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateGoalRequest extends FormRequest
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
                'exists:users,id'
            ],

           'strategic_goals'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'key_performance_indicator'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'weight'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'target'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'due_date'=>[
                'nullable',
                'date',
            ],
        ];
    }
}
