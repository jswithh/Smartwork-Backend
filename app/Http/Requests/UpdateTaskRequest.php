<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
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
            'project_id' => 'nullable|integer',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'priority' => 'nullable|string',
            'date_added' => 'nullable|date',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'date_completed' => 'nullable|date',
            'status' => 'nullable|integer',
            'created_by' => 'nullable|integer',
            'assigned_to' => 'nullable|integer',
        ];
    }
}
