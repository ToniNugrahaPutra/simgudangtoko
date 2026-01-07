<?php

namespace App\Repositories;

use App\Models\Pengguna;
use Spatie\Permission\Models\Role;

class PenggunaRoleRepository
{
    public function assignRoleToPengguna(int $penggunaId, int $roleId)
    {
        $pengguna = Pengguna::findOrFail($penggunaId);
        $role = Role::findOrFail($roleId);
        
        $pengguna->assignRole($role->nama);

        return $pengguna;
    }

    public function removeRoleFromPengguna(int $penggunaId, int $roleId)
    {
        $pengguna = Pengguna::findOrFail($penggunaId);
        $role = Role::findOrFail($roleId);
        
        $pengguna->removeRole($role->nama);

        return $pengguna;
    }

    public function getUserRoles(int $penggunaId)
    {
        $pengguna = Pengguna::findOrFail($penggunaId);
        
        return $pengguna->roles;
    }
}