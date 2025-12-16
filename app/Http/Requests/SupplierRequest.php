<?php

namespace App\Http\Requests;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier');
        $supplier = $supplierId ? Supplier::find($supplierId) : null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . optional($supplier?->user)->id,
            'password' => 'required|string|min:6',

            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',        ];
    }
}
