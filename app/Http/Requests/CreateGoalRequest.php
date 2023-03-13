<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateGoalRequest extends FormRequest
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
            'user_id' => [
                'required',
                'integer',
                'exists:users,id'
            ],

            'strategic_goals' => [
                'required',
                'string',
                'max:255',
            ],

            'key_performance_indicator' => [
                'required',
                'string',
                'max:255',
            ],

            'weight' => [
                'required',
                'string',
                'max:255',
            ],

            'target' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'string',
                'max:255',
            ],

            'due_date' => [
                'required',
                'date',
            ],
        ];
    }
}
