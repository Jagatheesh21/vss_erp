<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerMasterRequest extends FormRequest
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
            'cus_code' => 'required|unique:customer_masters,cus_code',
            'cus_name' => 'required',
            'cus_gst_number' => 'required|digits:10',
            'cus_address' => 'required',
            'cus_address1' => 'required',
            'cus_city' => 'required',
            'cus_state' => 'required',
            'cus_country' => 'required',
            'cus_pincode' => 'required',
            'delivery_cus_name' => 'required',
            'delivery_cus_gst_number' => 'required',
            'delivery_cus_address' => 'required',
            'delivery_cus_address1' => 'required',
            'delivery_cus_city' => 'required',
            'delivery_cus_state' => 'required',
            'delivery_cus_country' => 'required',
            'delivery_cus_pincode' => 'required',
            'supplier_vendor_code' => 'required',
            'supplytype' => 'required'
        ];
    }
}
