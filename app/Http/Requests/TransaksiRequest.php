<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
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
<<<<<<< HEAD
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'merchant_id' => 'required|exists:merchants,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
=======
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'toko_id' => 'required|exists:merchants,id',
            'produk' => 'required|array|min:1',
            'produk.*.produk_id' => 'required|exists:produk,id',
            'produk.*.jumlah' => 'required|integer|min:1',
>>>>>>> 0727bfbe7bd8a4de8d7e1c6d3533072f96ca7ff6
        ];
    }
}
