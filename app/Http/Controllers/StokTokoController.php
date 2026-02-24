<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StokTokoRequest;
use App\Http\Resources\StokTokoResource;
use App\Services\StokTokoService;

class StokTokoController extends Controller
{

    private StokTokoService $stokTokoService;
    public function __construct(StokTokoService $stokTokoService)
    {
        $this->stokTokoService = $stokTokoService;
    }
    public function store(StokTokoRequest $request, int $toko)
    {
        $validated = $request->validated();
        $validated['toko_id'] = $toko;

        $stokToko = $this->stokTokoService->assignProdukToToko($validated);

        return response()->json([
            'message' => 'Produk sukses ditambahkan ke toko',
            'data' => $stokToko,
        ], 201);
    }
    public function update(StokTokoRequest $request, int $toko, int $produk)
    {
        $validated = $request->validated();

        $stokToko = $this->stokTokoService->updateStok($toko, $produk, $validated['stok'], $validated['gudang_id'] ?? null);
        return response()->json([
            'message' => 'Stok berhasil diperbarui',
            'data' => $stokToko,
        ]);
    }
    public function destroy(int $toko, int $produk)
    {
        $this->stokTokoService->removeProdukFromToko($toko, $produk);

        return response()->json([
            'message' => 'Produk berhasil dihapus dari toko',
        ]);
    }
}
