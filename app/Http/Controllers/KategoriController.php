<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Http\Resources\KategoriResource;
use App\Services\KategoriService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    private $kategoriService;

    public function __construct(KategoriService $kategoriService)
    {
        $this->kategoriService = $kategoriService;
    }

    public function index()
    {
        $fields = ['id', 'nama', 'foto', 'tagline'];
        $kategoris = $this->kategoriService->getAll($fields);

        return response()->json(KategoriResource::collection($kategoris));
    }

    public function show(int $id)
    {
        try {
            $fields = ['id', 'nama', 'foto', 'tagline'];
            $kategori = $this->kategoriService->getById($id, $fields);
            return response()->json(new KategoriResource($kategori));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }
    }

    public function store(KategoriRequest $request)
    {
        $kategori = $this->kategoriService->create($request->validated());
        return response()->json(new KategoriResource($kategori), 201);
    }

    public function update(KategoriRequest $request, int $id)
    {
        try {
            $kategori = $this->kategoriService->update($id, $request->validated());
            return response()->json(new KategoriResource($kategori));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->kategoriService->delete($id);
            return response()->json([
                'message' => 'Kategori berhasil dihapus',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }
    }
}
