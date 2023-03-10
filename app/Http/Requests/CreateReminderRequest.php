<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateReminderRequest extends FormRequest
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
            'reminder_type_id' => 'required|integer|exists:reminder_types,id',
            'created_by' => 'required|integer|exists:users,id',
            'assigned_to' => 'required|integer|exists:users,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'date_added' => 'required|date',
            'time' => 'required|date_format:H:i',
            'adress' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'start_period' => 'required|date',
            'end_period' => 'required|date',
            'repeat_interval' => 'nullable|integer',
            'repeat_unit' => 'nullable|string|max:255',
            'next_reminder_date' => 'nullable|date',
        ];
    }
}
