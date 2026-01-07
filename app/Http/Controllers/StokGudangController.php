<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StokGudangUpdateRequest;
use App\Services\GudangService;

class StokGudangController extends Controller
{
    private GudangService $gudangService;

    public function __construct
    (
        GudangService $gudangService
    )
    {
        $this->gudangService = $gudangService;
    }
    public function attach(Request $request, int $gudang)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'stok' => 'required|integer|min:1',
        ]);

        $this->gudangService->attachProduk(
            $gudang, 
            $request->input('produk_id'), 
            $request->input('stok')
        );

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke gudang',
        ]);
    }

    public function detach(int $gudang, int $produk)
    {
        $this->gudangService->detachProduk($gudang, $produk);

        return response()->json([
            'message' => 'Produk berhasil dihapus dari gudang',
        ]);
    }

    public function update(StokGudangUpdateRequest $request, int $gudang, int $produk)
    {
        $stokGudang = $this->gudangService->updateProdukStok(
            $gudang, 
            $produk, 
            $request->validated()['stok']
        );

        return response()->json([
            'message' => 'Stok berhasil diperbarui',
            'data' => $stokGudang,
        ]);
    }
}
