<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostRequest extends FormRequest
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
            'name' => 'required|string',
            'content' => 'required|string',
            'menu_id' => 'required|integer',
            'thumbnail_id' => 'sometimes|integer',
            'write' => 'sometimes|string',
            'post_state' => 'sometimes|string',
            'tag_list' => 'required|string',
        ];
    }
}
