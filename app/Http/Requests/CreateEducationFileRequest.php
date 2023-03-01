<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateEducationFileRequest extends FormRequest
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
            'education_id' => 'required|integer|exists:educations,id',
            'file_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size' => 'required|string',
            'type' => 'required|string',
        ];
    }
}
