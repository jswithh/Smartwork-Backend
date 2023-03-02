<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateLeaveRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'approver_id' => 'required|integer|exists:users,id',
            'handover_id' => 'nullable|integer|exists:users,id',
            'subject' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required|string',
            'number_of_days' => 'required|integer',
            'leave_type' => 'required|string|max:255|in:annual,sick,maternity,hajj,unpaid',
            'status' => 'required|string|max:255|in:pending,approved,rejected',

        ];
    }
}
