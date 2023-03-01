<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTaskRequest extends FormRequest
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
            'project_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|string',
            'date_added' => 'required|date',
            'start_date' => 'required|date',
            'due_date' => 'required|date',
            'date_completed' => 'nullable|date',
            'status' => 'required|string',
            'created_by' => 'required|integer',
            'assigned_to' => 'required|integer',
        ];
    }
}
