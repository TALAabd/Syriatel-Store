<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customerId = $this->route('customer');
        $customer = $customerId ? Customer::find($customerId) : null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . optional($customer?->user)->id,
            'password' => 'nullable|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ];
    }
}
