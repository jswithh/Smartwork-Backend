<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEducationRequest extends FormRequest
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
            'user_id' => 'nullable|integer|exists:users,id',
            'institution_name' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'nullable|date|max:255',
            'end_date' => 'nullable|date|max:255',
            'grade' => 'nullable|string|max:255',
            'activities_and_societies' => 'nullable|string|max:255',
        ];
    }
}
