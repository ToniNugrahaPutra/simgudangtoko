<?php 

namespace App\Services;

use App\Repositories\PenggunaRoleRepository;
use App\Models\Pengguna;
use App\Models\Role;


class PenggunaRoleService
{
    private PenggunaRoleRepository $penggunaRoleRepository;

    public function __construct(PenggunaRoleRepository $penggunaRoleRepository)
    {
        $this->penggunaRoleRepository = $penggunaRoleRepository;
    }

    public function assignRole(int $penggunaId, int $roleId)
    {
        return $this->penggunaRoleRepository->assignRoleToPengguna($penggunaId, $roleId);
    }

    public function removeRole(int $penggunaId, int $roleId)
    {
        return $this->penggunaRoleRepository->removeRoleFromUser($penggunaId, $roleId);
    }

    public function listUserRoles(int $penggunaId)
    {
        return $this->penggunaRoleRepository->getUserRoles($penggunaId);
    } 
}
