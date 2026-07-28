<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
            return [
                'email'    => ['required', 'email'],
                'password'    => ['required', 'min:8'],
            ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Email wajib di isi.',
            'email.email'    => 'Format email tidak valid.',
            'password.required'    => 'Paswword wajib di isi.',
            'password.min'    => 'Password minimal 8 karakter.',
        ];
    }
}
