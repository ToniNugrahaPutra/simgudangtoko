<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Repositories\PenggunaRepository;

class PenggunaService
{
    private PenggunaRepository $penggunaRepository;

    public function __construct(PenggunaRepository $penggunaRepository)
    {
        $this->penggunaRepository = $penggunaRepository;
    }

    public function getAll(array $fields)
    {
        return $this->penggunaRepository->getAll($fields);
    }

    public function getById(int $id, array $fields)
    {
        return $this->penggunaRepository->getById($id, $fields ?? ['*']);
    }
    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        
        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile){
            $data['foto'] = $this->uploadPhoto($data['foto']);
        }
        return $this->penggunaRepository->create($data);
    }
    public function update(int $id, array $data)
    {
        $fields = ['*'];
        $pengguna = $this->penggunaRepository->getById($id, $fields);
        
        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile){
            if (!empty($pengguna->foto)){
                $this->deletePhoto($pengguna->foto);
            }
            $data['foto'] = $this->uploadPhoto($data['foto']);
        }
        return $this->penggunaRepository->update($id, $data);
    }
    public function delete(int $id)
    {
        $fields = ['*'];
        $pengguna = $this->penggunaRepository->getById($id, $fields);

        if ($pengguna->foto) {
            $this->deletePhoto($pengguna->foto);

        }
        $this->penggunaRepository->delete($id);
    }
    private function uploadPhoto(UploadedFile $foto)
    {
        return $foto->store('pengguna', 'public');
    }
    private function deletePhoto(string $fotoPath)
    {
        $relativePath = 'pengguna/' . basename($fotoPath);
        if (Storage::disk('public')->exists($relativePath)){
            Storage::disk('public')->delete($relativePath);
        }
    }

}