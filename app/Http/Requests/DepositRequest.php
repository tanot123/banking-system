<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:' . config('banking.min_deposit_amount', 1),
            'description' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Minimum deposit amount is ' . config('banking.min_deposit_amount', 1),
        ];
    }
}
