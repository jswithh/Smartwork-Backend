<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCareerFileRequest extends FormRequest
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
            'career_experience_id' => 'required|integer|exists:career_experiences,id',
            'file_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size' => 'required|string',
            'type' => 'required|string',
        ];
    }
}
