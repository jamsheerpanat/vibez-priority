<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:190'],
            'email' => ['nullable', 'email', 'max:190'],
            'mobile' => ['nullable', 'string', 'max:50'],
            'user_type' => ['nullable', 'in:visitor,employee'],
            'company_name' => ['nullable', 'string', 'max:190'],
            'src' => ['nullable', 'string', 'exists:qr_sources,source_code'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // At least one contact method required
            if (empty($this->email) && empty($this->mobile)) {
                $validator->errors()->add('contact', 'Either email or mobile is required.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required.',
            'email.email' => 'Please provide a valid email address.',
            'src.exists' => 'Invalid QR source code.',
        ];
    }
}
