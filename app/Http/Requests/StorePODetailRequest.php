<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePODetailRequest extends FormRequest
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
            'ponumber' => 'required',
            'purchasetype' => 'required',
            'podate' => 'required',
            'supplier_id' => 'required',
            'name' => 'required',
            'contact_person' => 'required','min:3',
            'gst_number' => 'required','max:15',
            'address' => 'required',
            'payment_terms' => 'required',
            'indentno' => 'required',
            'indentdate' => 'required',
            'quotno' => 'required',
            'quotdt' => 'required',
            'indentdate' => 'required',
            'packing_charges' => 'required'
         ];
    }
}
