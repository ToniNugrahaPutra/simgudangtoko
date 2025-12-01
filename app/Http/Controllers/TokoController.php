<?php

namespace App\Http\Controllers;
use App\Http\Requests\TokoRequest;
use App\Http\Resources\TokoResource;
use App\Services\TokoService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    private TokoService $tokoService;

    public function __construct(TokoService $tokoService)
    {
        $this->tokoService = $tokoService;
    }

    public function index()
    {
        $fields = ['*'];
        $toko = $this->tokoService->getAll($fields ?: ['*']);
        return response()->json(TokoResource::collection($toko));
    }

    public function show(int $id)
    {
        try{
            $fields = ['id', 'nama', 'foto', 'operator_id', 'created_at', 'updated_at'];
            $toko = $this->tokoService->getById($id, $fields);
            return response()->json(new TokoResource($toko));
        }catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Toko tidak ditemukan',
            ], 404);
        }
    }

    public function store(TokoRequest $request)
    {
        $toko = $this->tokoService->create($request->validated());
        return response()->json(new TokoResource($toko), 201);
    }

    public function update(TokoRequest $request, int $id)
    {
        try{
            $toko = $this->tokoService->update($id, $request->validated());
            return response()->json(new TokoResource($toko));
        }catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Toko tidak ditemukan',
            ], 404);
        }
    }

    public function destroy(int $id)
    {
        try{
            $this->tokoService->delete($id);
            return response()->json([
                'message' => 'Toko berhasil dihapus',
            ]);
        } catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Toko tidak ditemukan',
            ], 404);
        }
    }

    public function getMyTokoProfile()
    {
        $userId = Auth::id();

        try{
            $toko = $this->tokoService->getByOperatorId($userId);
            
            return response()->json(new TokoResource($toko));
        }catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Toko tidak ditemukan untuk pengguna ini.',
            ], 404);
        }
    }
}
