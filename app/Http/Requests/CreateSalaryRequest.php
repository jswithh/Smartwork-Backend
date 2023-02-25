<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateSalaryRequest extends FormRequest
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
            'user_id'=>[
                'required',
                'integer',
                'max:255',
                'exists:users,id'
            ],
            'bank_account_number'=>[
                'required',
                'integer',
            ],
            'bank_name'=>[
                'required',
                'string',
                'max:255',
            ],
            'bank_of_issue'=>[
                'required',
                'string',
                'max:255',
            ],
            'npwp_number'=>[
                'required',
                'integer',
            ],
            'signed_date'=>[
                'required',
                'date',
                'max:255',
            ],
            'sallary_type'=>[
                'nullable',
                'string',
                'max:255',
            ],
            'sallary_form'=>[
                'nullable',
                'string',
                'max:255',
            ],
            'amout_sallary'=>[
                'required',
                'integer',
            ],
            'amout_allowance'=>[
                'nullable',
                'integer',
            ],
            'allowance_type'=>[
                'nullable',
                'string',
                'max:255',
            ],
            'note'=>[
                'nullable',
                'string',
                'max:255',
            ],
            
        ];
    }
}
