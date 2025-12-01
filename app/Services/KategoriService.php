<?php

namespace App\Services;

use App\Repositories\KategoriRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

    class KategoriService
{
   private $kategoriRepository;

    public function __construct
    (
        KategoriRepository $kategoriRepository
    )
    {
         $this->kategoriRepository = $kategoriRepository;
    }

    public function getAll(array $fields)
    {
        return $this->kategoriRepository->getAll($fields);
    }

    public function getById(int $id, array $fields)
    {
        return $this->kategoriRepository->getById($id, $fields ?? ['*']);
    }

    public function create(array $data)
    {
        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            $data['foto'] = $this->uploadPhoto($data['foto']);
        }

        return $this->kategoriRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $fields = ['id', 'foto'];
        $kategori = $this->kategoriRepository->getById($id, $fields);

        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            if (!empty($kategori->foto)) {
                $this->deletePhoto($kategori->foto);
            }
            $data['foto'] = $this->uploadPhoto($data['foto']);
        }

        return $this->kategoriRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $fields = ['id', 'foto'];

        $kategori = $this->kategoriRepository->getById($id, $fields);

        if ($kategori->foto) {
            $this->deletePhoto($kategori->foto);

        }
        $this->kategoriRepository->delete($id);
    }

    private function uploadFoto(UploadedFile $foto)
    {
        return $foto->store('kategori', 'public');
    }

    private function deleteFoto(string $fotoPath)
    {
        $relativePath = 'kategori/' . basename($fotoPath);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    
    }
}