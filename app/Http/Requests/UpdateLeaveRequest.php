<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateLeaveRequest extends FormRequest
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
            'approver_id' => 'nullable|integer|exists:users,id',
            'handover_id' => 'nullable|integer|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'reason' => 'nullable|string',
            'number_of_days' => 'nullable|integer',
            'leave_type' => 'nullable|string|max:255|in:annual,sick,maternity,hajj,unpaid',
            'status' => 'nullable|string|max:255|in:pending,approved,rejected',

        ];
    }
}
