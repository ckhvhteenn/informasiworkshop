<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            //
            'proof' => ['required', 'image', 'mimes:jpg,jpeg,png'],
            'customer_bank_account' => 'required|string|max:255',
            'customer_bank_name' => 'required|string|max:255',
            'customer_bank_number' => 'required|string|max:255',
        ];
    }
}
