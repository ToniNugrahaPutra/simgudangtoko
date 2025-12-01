<?php

namespace App\Repositories;

use App\Models\Gudang;

class GudangRepository
{
    public function getAll(array $fields)
    {
        return Gudang::select($fields)->with(['produk.kategori'])->latest()->paginate(10);
    }

    public function getById(int $id, array $fields)
    { 
        return Gudang::select($fields)->with(['produk.kategori'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Gudang::create($data);
    }

    public function update(int $id, array $data)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->update($data);
        return $gudang;
    }
 
    public function delete(int $id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();
    }
}
