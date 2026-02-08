<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequestForm extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',

            'image' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'rating_count' => 'nullable|integer|min:0',
            'is_published' => 'nullable',
        ];
    }
}
