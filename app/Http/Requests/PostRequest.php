<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', Rule::unique('posts')->ignore($this->post), 'max:150'],
            'category_id' => ['nullable', 'exists:categories,id'], // Check if the category id exists // DO NOT INSERT SPACES
            'tags' => ['exists:tags,id'], // BUG HERE!! FIX CREATING A NEW BRANCH -> fixed!!
            'author' => ['nullable'],
            'content' => ['nullable'],
            'cover_image' => ['nullable']
        ];
    }
}
