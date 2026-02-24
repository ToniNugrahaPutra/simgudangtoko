<?php

namespace App\Repositories;

use App\Models\Kategori;

class KategoriRepository
{
    public function getAll(array $fields)
    {
        return Kategori::select($fields)->withCount('produk')->latest()->get();
    }

    public function getById(int $id, array $fields)
    {
        return Kategori::select($fields)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Kategori::create($data);
    }

    public function update(int $id, array $data)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->update($data);

        return $kategori;
    }

    public function delete(int $id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();
    }
}
