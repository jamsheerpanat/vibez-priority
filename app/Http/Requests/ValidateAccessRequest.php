<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAccessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'card_serial' => ['required', 'string', 'exists:wallet_cards,card_serial'],
        ];
    }

    public function messages(): array
    {
        return [
            'card_serial.required' => 'Card serial is required.',
            'card_serial.exists' => 'Invalid card serial.',
        ];
    }
}
