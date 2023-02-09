<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_id' => 'required|integer|exists:companies,id',
            'employee_id' => 'required|integer|exists:employees,id',
            'clock_in' => 'required|dateTime',
            'clock_out' => 'required|dateTime',
            'working_from' => 'required|string',
            'late' => 'nullable|float',
            'clock_out_address' => 'required|string',
            'working_hours' => 'required|float',
            'break_in' => 'required|time',
            'break_out' => 'required|time',
            'break_hours' => 'required|float',
            'totally' => 'required|float',
            'overtime' => 'nullable|float',
        ];
    }
}
