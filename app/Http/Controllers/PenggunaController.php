<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PenggunaRequest;
use App\Http\Resources\PenggunaResource;
use App\Services\PenggunaService;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    private PenggunaService $penggunaService;

    public function __construct(PenggunaService $penggunaService)
    {
        $this->penggunaService = $penggunaService;
    }
    public function index()
    {
    $pengguna = Pengguna::with('roles')->get();

    return response()->json(
        $pengguna->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->nama,
                'email' => $user->email,
                'phone' => $user->no_hp,
                'photo' => asset('storage/' . $user->foto),
                'roles' => $user->roles->pluck('name'),
            ];
        })
    );

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
