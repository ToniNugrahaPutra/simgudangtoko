<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PenggunaRoleService;
use App\Http\Requests\PenggunaRoleRequest;
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

    public function assignRole(PenggunaRoleRequest $request)
    {
        $user = $this->penggunaRoleService->assignRole(
            $request->validated()['pengguna_id'], 
            $request->validated()['role_id']
        );

        return response()->json([
            'message' => 'Role berhasil ditambahkan',
            'data' => $user
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


