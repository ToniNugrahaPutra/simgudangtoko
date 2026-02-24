<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function getAll(array $fields)
    {
        if (!in_array('*', $fields) && !in_array('guard_name', $fields)) {
            $fields[] = 'guard_name';
        }
        return Role::select($fields)->withCount(['users as pengguna_count'])->latest()->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        if (!in_array('*', $fields) && !in_array('guard_name', $fields)) {
            $fields[] = 'guard_name';
        }
        return Role::select($fields)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Role::create([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);
    }

    public function update(int $id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }

    public function delete(int $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
    }
}
