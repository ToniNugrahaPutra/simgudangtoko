<?php

namespace App\Repositories;

use App\Models\Pengguna;

class PenggunaRepository
{
    public function getAll(array $fields)
    {
        return Pengguna::select($fields)->latest()->paginate(50);
    }

    public function getById(int $id, array $fields)
    {
        return Pengguna::select($fields)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Pengguna::create($data);
    }

    public function update(int $id, array $data)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update($data);
        return $pengguna;
    }

    public function delete(int $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();
    }
}
