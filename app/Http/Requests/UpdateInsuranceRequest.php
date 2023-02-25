<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateInsuranceRequest extends FormRequest
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
            'insurance_type' => 'nullable|string',
            'insurance_number' => 'nullable|string',
            'secondary_insurance_type' => 'nullable|string',
            'secondary_insurance_number' => 'nullable|string',
        ];
    }
}
