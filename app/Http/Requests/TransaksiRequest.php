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
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'toko_id' => 'required|exists:toko,id',
            'produk' => 'required|array|min:1',
            'produk.*.produk_id' => 'required|exists:produk,id',
            'produk.*.jumlah' => 'required|integer|min:1',
        ];
    }
}
