<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        return [
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,processing,completed',
            'customer_id' => 'required|exists:customers,id',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'required|exists:products,id',

            'quantities' => 'required|array',
            'quantities.*' => 'nullable|numeric|min:0',

        ];
    }
}
