<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAttendanceRequest extends FormRequest
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
                'nullable',
                'integer',
                'exists:users,id'
            ],

            'clock_in_time'=>[
                'nullable',
                'date',
            ],
            'clock_out_time'=>[
                'nullable',
                'date',
            ],
            'working_from'=>[
                'nullable',
                'string',
                'max:255',
            ],
            'late'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'clock_out_addres'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'work_hours'=>[
                'nullable',
                'float',
            ],

            'break_in'=>[
                'nullable',
                'date_format:H:i:s',
            ],

            'break_out'=>[
                'nullable',
                'date_format:H:i:s',
            ],

            'break_hours'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'Totally'=>[
                'nullable',
                'string',
                'max:255',
            ],

            'Overtime'=>[
                'nullable',
                'string',
                'max:255',
            ],


        ];
    }
}
