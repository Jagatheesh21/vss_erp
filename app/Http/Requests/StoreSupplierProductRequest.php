<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierProductRequest extends FormRequest
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
            'supplier_id' => 'required',
            'raw_material_category_id' => 'required',
            'raw_material_id' => 'required',
            'uom_id'=> 'required',
            'products_rate'=> 'required|numeric|min:0',
            'products_hsnc'=> 'required|numeric|digits_between:6,8',
        ];
    }
}
