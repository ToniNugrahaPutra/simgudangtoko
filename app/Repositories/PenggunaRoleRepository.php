<?php

namespace App\Repositories;

use App\Models\Pengguna;
use Spatie\Permission\Models\Role;


class PenggunaRoleRepository
{
    public function assignRoleToPengguna(int $penggunaId, string $roleName)
    {
        $pengguna = Pengguna::findOrFail($penggunaId);

        $pengguna->syncRoles([$roleName]);

        return $pengguna->load('roles');
    }


    public function removeRoleFromPengguna(int $penggunaId, int $roleId)
    {
        $pengguna = Pengguna::findOrFail($penggunaId);
        $role = Role::findOrFail($roleId);

        $pengguna->removeRole($role);

        return $pengguna->load('roles');
    }

    public function getUserRoles(int $penggunaId)
    {
        return Pengguna::findOrFail($penggunaId)->roles;
    }
}
