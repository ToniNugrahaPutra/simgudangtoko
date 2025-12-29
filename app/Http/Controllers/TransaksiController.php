<?php

namespace App\Http\Controllers;

use App\Services\TransaksiService;
use App\Http\Resources\TransaksiResource;
use App\Http\Requests\TransaksiRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransaksiController extends Controller
{
    private TransaksiService $transaksiService;

    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    public function index()
    {
        $fields = ['*'];
        $transaksi = $this->transaksiService->getAll($fields);

        return response()->json(
            TransaksiResource::collection($transaksi)
        );
    }

    public function store(TransaksiRequest $request)
    {
        $transaksi = $this->transaksiService->createTransaksi($request->validated());
    
        return response()->json([
            'message' => 'Transaksi berhasil dibuat',
            'data' => new TransaksiResource($transaksi),
        ], 201);
    }

    public function show(int $transaksi)
    {
        try {
            $fields = ['*'];
            $transaksi = $this->transaksiService->getTransaksiById($transaksi, $fields);
            return response()->json(new TransaksiResource($transaksi));

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }
    }

    public function getTransaksiByToko()
    {
        $pengguna = auth()->user();
        if (!$pengguna) {
            return response()->json([
                'message' => 'pengguna belum login'
            ], 401);
        }
        if (!$pengguna->toko) {
            return response()->json([
                'message' => 'pengguna tidak memiliki toko'
            ], 403);
        }
        $tokoId = $pengguna->toko->id;
        $transaksi = $this->transaksiService->getTransaksiByToko($tokoId, ['*']);
        return response()->json(
            TransaksiResource::collection($transaksi)
        );
    }
}
