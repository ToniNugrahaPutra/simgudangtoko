<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProdukResource;
use App\Http\Requests\ProdukRequest;
use App\Services\ProdukService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProdukController extends Controller
{
    private ProdukService $produkService;

    public function __construct(ProdukService $produkService)
    {
        $this->produkService = $produkService;
    }

    public function index()
    {
        $fields = ['id', 'nama', 'thumbnail', 'harga', 'kategori_id', 'is_popular'];
        $produk = $this->produkService->getAll($fields);
        return response()->json(ProdukResource::collection($produk));
    }

    public function show(int $id)
    {
        try {
            $fields = ['id', 'nama', 'thumbnail', 'harga', 'deskripsi', 'kategori_id', 'is_popular'];
            $produk = $this->produkService->getById($id, $fields);
            return response()->json(new ProdukResource($produk));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }
    }

    public function store(ProdukRequest $request)
    {
        $produk = $this->produkService->create($request->validated());
        return response()->json(new ProdukResource($produk), 201);
    }

    public function update(ProdukRequest $request, int $id)
    {
        try {
            $produk = $this->produkService->update($id, $request->validated());
            return response()->json(new ProdukResource($produk));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->produkService->delete($id);
            return response()->json([
                'message' => 'Produk berhasil dihapus',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }
    }
}
