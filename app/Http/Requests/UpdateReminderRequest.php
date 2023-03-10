<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateReminderRequest extends FormRequest
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
            'reminder_type_id' => 'nullable|integer|exists:reminder_types,id',
            'created_by' => 'nullable|integer|exists:users,id',
            'assigned_to' => 'nullable|integer|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'date_added' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
            'adress' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'start_period' => 'nullable|date',
            'end_period' => 'nullable|date',
            'repeat_interval' => 'nullable|integer',
            'repeat_unit' => 'nullable|string|max:255',
            'next_reminder_date' => 'nullable|date',
        ];
    }
}
