<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateProjectRequest extends FormRequest
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
            'created_by' => 'required|integer|exists:users,id',
            'assigned_to' => 'nullable|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'tags' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'due_date' => 'required|date',
            'date_completed' => 'nullable|date',
            'status' => 'required|integer',
            'priority' => 'required|string|max:255',
            
        ];
    }
}
