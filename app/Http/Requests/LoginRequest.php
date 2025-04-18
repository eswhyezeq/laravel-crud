<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'regex:/^[\w\.-]+@[\w\.-]+\.\w{2,4}$/'],
            'password' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Please enter a valid email address.',
        ];
    }
}

