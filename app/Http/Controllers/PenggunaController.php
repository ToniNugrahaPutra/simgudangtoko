<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PenggunaRequest;
use App\Http\Resources\PenggunaResource;
use App\Services\PenggunaService;

class PenggunaController extends Controller
{
    private PenggunaService $penggunaService;

    public function __construct(PenggunaService $penggunaService)
    {
        $this->penggunaService = $penggunaService;
    }
    public function index()
    {
        $fields = ['id', 'nama', 'email', 'foto', 'no_hp'];
        $pengguna = $this->penggunaService->getAll($fields ?: ['*']);
        return response()->json(PenggunaResource::collection($pengguna));
    }
    public function show(int $id)
    {
        $fields = ['id', 'nama', 'email', 'foto', 'no_hp'];
        $pengguna = $this->penggunaService->getById($id, $fields ?: ['*']);
        return response()->json(new PenggunaResource($pengguna));
    }
    public function store(PenggunaRequest $request)
    {
        $pengguna = $this->penggunaService->create($request->validated());
        return response()->json(new PenggunaResource($pengguna), 201);
    }
    public function update(PenggunaRequest $request, int $id)
    {
        $pengguna = $this->penggunaService->update($id, $request->validated());
        return response()->json(new PenggunaResource($pengguna));
    }
    public function destroy(int $id)
    {
        $this->penggunaService->delete($id);
        return response()->json([
            'message' => 'Pengguna berhasil dihapus.',
        ]);
    }
}
