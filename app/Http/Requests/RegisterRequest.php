<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'pin' => 'required|string|size:6|regex:/^[0-9]+$/',
        ];
    }

    public function messages(): array
    {
        return [
            'pin.regex' => 'PIN must contain only numbers.',
            'pin.size' => 'PIN must be exactly 6 digits.',
        ];
    }
}
