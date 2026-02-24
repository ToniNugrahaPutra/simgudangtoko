<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GudangService;
use App\Http\Requests\GudangRequest;
use App\Http\Resources\GudangResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GudangController extends Controller
{
    private $gudangService;

    public function __construct
    (
        GudangService $gudangService
    )
    {
        $this->gudangService = $gudangService;
    }

    public function index()
    {
        $fields = ['id', 'nama', 'foto', 'no_hp', 'alamat'];
        $gudang = $this->gudangService->getAll($fields ?: ['*']);
        return response()->json(GudangResource::collection($gudang));
    }

    public function show(int $id)
    {
        try {
            $fields = ['id', 'nama', 'foto', 'no_hp', 'alamat'];
            $gudang = $this->gudangService->getById($id, $fields);
            return response()->json(new GudangResource($gudang));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Gudang tidak ditemukan',
            ], 404);
        }
    }

    public function store(GudangRequest $request)
    {
        $gudang = $this->gudangService->create($request->validated());
        return response()->json(new GudangResource($gudang), 201);
    }

    public function update(GudangRequest $request, int $id)
    {
        try {
            $gudang = $this->gudangService->update($id, $request->validated());
            return response()->json(new GudangResource($gudang));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Gudang tidak ditemukan',
            ], 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->gudangService->delete($id);
            return response()->json([
                'message' => 'Gudang berhasil dihapus',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Gudang tidak ditemukan',
            ], 404);
        }
    }
}
