<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Services\PenggunaRoleService;
use App\Http\Requests\PenggunaRoleRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenggunaRoleController extends Controller
{
    //  
    private PenggunaRoleService $penggunaRoleService;

    public function __construct(PenggunaRoleService $penggunaRoleService)
    {
        $this->penggunaRoleService = $penggunaRoleService;
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'role' => 'required|string|exists:roles,name',
        ]);

        $pengguna = Pengguna::findOrFail($request->pengguna_id);

        $role = Role::where('name', $request->role)
                    ->where('guard_name', 'web')
                    ->firstOrFail();

        $pengguna->syncRoles([$role->name]);

        return response()->json([
            'message' => 'Role berhasil ditambahkan',
            'roles' => $pengguna->roles,
        ]);
    }


    public function removeRole(PenggunaRoleRequest $request)
    {
        $user = $this->penggunaRoleService->removeRole(
            $request->validated()['pengguna_id'], 
            $request->validated()['role_id']
        );

        return response()->json([
            'message' => 'Role berhasil dihapus',
            'data' => $user
        ]);
    }

    public function listPenggunaRole(int $penggunaId)
    {
        try {
            $roles = $this->penggunaRoleService->listPenggunaRole($penggunaId);

            return response()->json([
                'pengguna_id' => $penggunaId,
                'roles' => $roles
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }
    }
}


