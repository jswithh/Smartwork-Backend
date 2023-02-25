<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateContractRequest extends FormRequest
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
            'employee_type_id' => 'nullable|integer|exists:employee_types,id',
            'contract_status' => 'nullable|boolean',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
        ];
    }
}
