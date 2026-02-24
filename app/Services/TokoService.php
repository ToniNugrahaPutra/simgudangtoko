<?php

namespace App\Services;

use App\Repositories\TokoRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TokoService
{
    private TokoRepository $tokoRepository;

    public function __construct
    (
        TokoRepository $tokoRepository
    )
    {
        $this->tokoRepository = $tokoRepository;
    }

    public function getAll(array $fields)
    {
        return $this->tokoRepository->getAll($fields);
    }

    public function getById(int $id, array $fields)
    {
        return $this->tokoRepository->getById($id, $fields ?? ['*']);
    }

    public function create(array $data)
    {
        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            $data['foto'] = $this->uploadFoto($data['foto']);
        }
        return $this->tokoRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $fields = ['*'];
        $toko = $this->tokoRepository->getById($id, $fields);

        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            if (!empty($toko->foto)) {
                $this->deleteFoto($toko->foto);
            }
            $data['foto'] = $this->uploadFoto($data['foto']);
        }
        return $this->tokoRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $fields = ['*'];
        $toko = $this->tokoRepository->getById($id, $fields);

        if ($toko->foto) {
            $this->deleteFoto($toko->foto);
        }
        return $this->tokoRepository->delete($id);
    }

    public function getByOperatorId(int $operatorId)
    {
        $fields = ['*'];
        return $this->tokoRepository->getByOperatorId($operatorId, $fields);
    }

    private function uploadFoto(UploadedFile $foto): string
    {
        return $foto->store('toko', 'public');
    }

    private function deleteFoto(string $fotoPath): void
    {
        $relativePath = 'toko/' . basename($fotoPath);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
