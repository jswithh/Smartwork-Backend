<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSalaryRequest extends FormRequest
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
                'bank_account_number' => 'nullable|integer',
                'bank_name' => 'nullable|string|max:255',
                'bank_of_issue' => 'nullable|string|max:255',
                'npwp_number' => 'nullable|integer',
                'signed_date' => 'nullable|date|max:255',
                'sallary_type' => 'nullable|string|max:255',
                'sallary_form' => 'nullable|integer',
                'amout_sallary' => 'nullable|integer',
                'amout_allowance' => 'nullable|integer',
                'note' => 'nullable|string|max:255',

        ];
    }
}
