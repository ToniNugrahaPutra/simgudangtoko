<?php

namespace App\Repositories;

use App\Models\StokToko;
use Illuminate\Validation\ValidationException;

class StokTokoRepository
{
    public function create(array $data)
    {
        return StokToko::create($data);
    }

    public function getByTokoAndProduk(int $tokoId, int $produkId)
    {
        return StokToko::where('toko_id', $tokoId)
            ->where('produk_id', $produkId)
            ->first();
    }

    public function updateStok(int $tokoId, int $produkId, int $stok)
    {
        $stokToko = $this->getByTokoAndProduk($tokoId, $produkId);
        
        if (!$stokToko) {
            throw ValidationException::withMessages([
                'produk_id' => 'Produk tidak ditemukan untuk toko ini.',
            ]);
        }

        $stokToko->update(['stok' => $stok]);
        return $stokToko;
    }
}           