<?php

namespace App\Repositories;

use App\Models\Toko;

class TokoRepository
{
    public function getAll(array $fields)
    {
        return Toko::select($fields)->with(['operator', 'produk'])->latest()->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        return Toko::select($fields)->with(['operator', 'produk.kategori'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Toko::create($data);
    }

    public function update(int $id, array $data)
    {
        $toko = Toko::findOrFail($id);
        $toko->update($data);
        return $toko;
    }

    public function delete(int $id)
    {
        $toko = Toko::findOrFail($id);
        $toko->delete();
    }

    public function getByOperatorId(int $operatorId, array $fields)
    {
        return Toko::select($fields)
            ->where('operator_id', $operatorId)
            ->with(['operator', 'produk.kategori'])
            ->firstOrFail();
    }
}
