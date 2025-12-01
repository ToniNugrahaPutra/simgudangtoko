<?php

namespace App\Services;

use App\Repositories\GudangRepository;
use App\Models\StokGudang;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GudangService
{
    private $gudangRepository;

    public function __construct
    (
        GudangRepository $gudangRepository
    )
    {
         $this->gudangRepository = $gudangRepository;
    }

    public function getAll(array $fields)
    {
        return $this->gudangRepository->getAll($fields);
    }

    public function getById(int $id, array $fields)
    {
        return $this->gudangRepository->getById($id, $fields ?? ['*']);
    }

    public function create(array $data)
    {
        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            $data['foto'] = $this->uploadPhoto($data['foto']);
        }

        return $this->gudangRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $fields = ['*'];
        $gudang = $this->gudangRepository->getById($id, $fields);

        if(isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            if(!empty($gudang->foto)){
                $this->deletePhoto($gudang->foto);
            }
            $data['foto'] = $this->uploadPhoto($data['foto']);
        }

        return $this->gudangRepository->update($id, $data);
    }

    public function delete(int $id)
    {

        $fields = ['*'];
        $gudang = $this->gudangRepository->getById($id, $fields);

        if ($gudang->foto) {
            $this->deletePhoto($gudang->foto);
        }

        $this->gudangRepository->delete($id);
    }

    public function attachProduct(int $gudangId, int $produkId, int $stok)
    {
        $gudang = $this->gudangRepository->getById($gudangId, ['id']);
        $gudang->produk()->syncWithoutDetaching([
            $produkId => ['stok' => $stok]
        ]);
    }

    public function detachProduct(int $gudangId, int $produkId)
    {
        $gudang = $this->gudangRepository->getById($gudangId, ['id']);
        $gudang->produk()->detach($produkId);
    }

     public function updateProductStock(int $gudangId, int $produkId, int $stok)
    {
        $gudang = $this->gudangRepository->getById($gudangId, ['id']);
        $gudang->produk()->updateExistingPivot($produkId, ['stok' => $stok]);

        return $gudang->produk()->where('id', $produkId)->first();
    }

    private function uploadPhoto(UploadedFile $foto)
    {
        return $foto->store('gudang', 'public');
    }

    private function deletePhoto(string $fotoPath)
    {
        $relativePath = 'gudang/' . basename ($fotoPath);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}