<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|nullable',
            'nick_name' => 'required|string|nullable',
            'introduce' => 'required|string|nullable',
            'profile_img' => 'sometimes|image',
            'cover_img' => 'sometimes|image',
        ];
    }
}
