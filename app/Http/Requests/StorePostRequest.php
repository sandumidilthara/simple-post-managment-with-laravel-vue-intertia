<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[A-Za-z0-9\s\-\_]+$/',
            ],
            'body' => [
                'required',
                'string',
                'min:10',
                'not_regex:/<script\b[^>]*>(.*?)<\/script>/i',
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'tags' => [
                'nullable',
                'array',
            ],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required',
            'title.min' => 'The title must be at least 2 characters',
            'title.max' => 'The title may not be greater than 255 characters',
            'title.regex' => 'The title may only contain letters, numbers, spaces, dashes and underscores',
            'body.required' => 'The content field is required',
            'body.min' => 'The content must be at least 10 characters',
            'body.not_regex' => 'Script tags are not allowed in the content',
            'category_id.required' => 'Please select a category',
            'category_id.exists' => 'The selected category is invalid',
        ];
    }

    /**
     * Attribute names (for cleaner error messages).
     */
    public function attributes(): array
    {
        return [
            'title' => 'Post Title',
            'body' => 'Post Content',
            'category_id' => 'Category',
        ];
    }
}
