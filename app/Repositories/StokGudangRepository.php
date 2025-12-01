<?php

namespace App\Repositories;

use Illuminate\Validation\ValidationException;
use App\Models\StokGudang;

class StokGudangRepository
{
    public function getByGudangId(int $gudangId, int $produkId)
    {
        return StokGudang::where('gudang_id', $gudangId)
        ->where('produk_id', $produkId)
        ->first();
    }

    public function updateStock(int $gudangId, int $produkId, int $stok)
    {
        $stokGudang = $this->getByGudangId($gudangId, $produkId);

        if (!$stokGudang) {
            throw ValidationException::withMessages([
                'produk_id' => 'Produk tidak ditemukan di gudang ini.',
            ]);
        }

        $stokGudang->update(['stok' => $stok]);
        return $stokGudang;
    }
}
