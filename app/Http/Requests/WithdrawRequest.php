<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:' . config('banking.min_withdrawal_amount', 1),
            'description' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Minimum withdrawal amount is ' . config('banking.min_withdrawal_amount', 1),
        ];
    }
}
