<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'billing_address' => ['nullable', 'string', 'max:255'],
            'billing_city' => ['nullable', 'string', 'max:255'],
            'billing_zip' => ['nullable', 'string', 'max:50'],
            'billing_country' => ['nullable', 'string', 'max:255'],
            'shipping_address' => ['nullable', 'string', 'max:255'],
            'shipping_city' => ['nullable', 'string', 'max:255'],
            'shipping_zip' => ['nullable', 'string', 'max:50'],
            'shipping_country' => ['nullable', 'string', 'max:255'],
        ];
    }
}
