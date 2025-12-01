<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProdukRepository
{
    public function getAll(array $fields)
    {
        return Produk::select($fields)->with('kategori')->latest()->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        return Produk::select($fields)->with('kategori')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Produk::create($data);
    }

    public function update(int $id, array $data)
    {
        $produk = Produk::findOrFail($id);
        $produk->update($data);
        return $produk;
    }

    public function delete(int $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
    }
}