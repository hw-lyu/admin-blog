<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCommentRequest extends FormRequest
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
            'comment_id' => 'required|string',
            'comment_pw' => 'required|string',
            'comment_content' => 'required|string',
            'menu_id' => 'required|string',
            'post_id' => 'required|string',
            'comment_image' => 'sometimes|image',
        ];
    }
}
