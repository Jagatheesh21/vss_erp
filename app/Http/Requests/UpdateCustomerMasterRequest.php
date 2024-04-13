<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerMasterRequest extends FormRequest
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
            'cus_code' => 'required',
            'cus_name' => 'required',
            'cus_gst_number' => 'required',
            'cus_address' => 'required',
            'cus_city' => 'required',
            'cus_state' => 'required',
            'cus_country' => 'required',
            'cus_pincode' => 'required|numeric|digits_between:6,6',
            'delivery_cus_name' => 'required',
            'delivery_cus_gst_number' => 'required',
            'delivery_cus_address' => 'required',
            'delivery_cus_city' => 'required',
            'delivery_cus_state' => 'required',
            'delivery_cus_country' => 'required',
            'delivery_cus_pincode' => 'required|numeric|digits_between:6,6',
            'supplier_vendor_code' => 'required',
            'supplytype' => 'required'
        ];
    }
}
