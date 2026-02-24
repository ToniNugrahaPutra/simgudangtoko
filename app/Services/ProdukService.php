<?php

namespace App\Services;

use App\Repositories\ProdukRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProdukService
{
    private ProdukRepository $produkRepository;

    public function __construct(ProdukRepository $produkRepository)
    {
        $this->produkRepository = $produkRepository;
    }

    public function getAll(array $fields)
    {
        return $this->produkRepository->getAll($fields);
    }

    public function getById(int $id, array $fields = ['*'])
    {
        return $this->produkRepository->getById($id, $fields);
    }

    public function create(array $data)
    {
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            $data['thumbnail'] = $this->uploadPhoto($data['thumbnail']);
        }
        return $this->produkRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $fields = ['*'];
        $produk = $this->produkRepository->getById($id, $fields);

        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            if (!empty($produk->thumbnail)) {
                $this->deletePhoto($produk->thumbnail);
            }
            $data['thumbnail'] = $this->uploadPhoto($data['thumbnail']);
        }
        return $this->produkRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $fields = ['*'];
        $produk = $this->produkRepository->getById($id, $fields);

        $rawThumbnail = $produk->getRawOriginal('thumbnail');
        if ($rawThumbnail) {
            $this->deletePhoto($rawThumbnail);
        }
        $this->produkRepository->delete($id);
    }

    private function uploadPhoto(UploadedFile $photo)
    {
        return $photo->store('produk', 'public');
    }

    private function deletePhoto(string $photoPath)
    {
        $relativePath = 'produk/' . basename($photoPath);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
