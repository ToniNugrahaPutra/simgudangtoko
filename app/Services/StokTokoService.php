<?php 

namespace App\Services;

use App\Repositories\StokTokoRepository;
use App\Repositories\TokoRepository;
use App\Repositories\StokGudangRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\StokGudang;

class StokTokoService
{
    
    private TokoRepository $tokoRepository;
    private StokTokoRepository $stokTokoRepository;
    private StokGudangRepository $stokGudangRepository;

    public function __construct(
        TokoRepository $tokoRepository,
        StokTokoRepository $stokTokoRepository, 
        StokGudangRepository $stokGudangRepository)
    {
        $this->tokoRepository = $tokoRepository;
        $this->stokTokoRepository = $stokTokoRepository;
        $this->stokGudangRepository = $stokGudangRepository;
    }

public function assignProdukToToko(array $data)
    {
       return DB::transaction(function () use ($data) {

        $stokGudang = $this->stokGudangRepository->getByGudangAndProduk(
            $data['gudang_id'], 
            $data['produk_id']
        );

        if(!$stokGudang || $stokGudang->stok < $data['stok']) {
            throw ValidationException::withMessages([
                'stok' => ['Stok di gudang tidak mencukupi.']
            ]);
        }

        $existingProduk = $this->stokTokoRepository->getByTokoAndProduk(
            $data['toko_id'], 
            $data['produk_id']
        );

        if ($existingProduk) {
            throw ValidationException::withMessages([
                'produk' => ['Produk sudah ada di toko ini.'],
            ]);
        }

        $this->stokGudangRepository->updateStock(
            $data['gudang_id'], 
            $data['produk_id'], 
            $stokGudang->stok - $data['stok']
        );

        return $this->stokTokoRepository->create([
            'gudang_id' => $data['gudang_id'],
            'toko_id' => $data['toko_id'],
            'produk_id' => $data['produk_id'],
            'stok' => $data['stok'],
        ]);
       });
    }

public function updateStok(int $tokoId, int $produkId, int $newStok, int $gudangId)
    {
        return DB::transaction(function () use ($tokoId, $produkId, $newStok, $gudangId) {
            
            $existing = $this->stokTokoRepository->getByTokoAndProduk($tokoId, $produkId);
            if (!$existing) {
                throw ValidationException::withMessages([
                    'produk' => ['Produk tidak dimasukkan ke toko ini.'],
                ]);
            }

            if(!$gudangId) {
                throw ValidationException::withMessages([
                    'gudang_id' => ['ID Gudang diperlukan saat menambah stok.'],
                ]);
            }

            $currentStok = $existing->stok;

            if ($newStok > $currentStok) {
                
                $diff = $newStok - $currentStok;
                $stokGudang = $this->stokGudangRepository->getByGudangAndProduk(
                    $gudangId, 
                    $produkId
                );

                if(!$stokGudang || $stokGudang->stok < $diff) {
                    throw ValidationException::withMessages([
                        'stok' => ['Stok di gudang tidak mencukupi.'],
                    ]);
                }

                $this->stokGudangRepository->updateStock(
                    $gudangId, 
                    $produkId, 
                    $stokGudang->stok - $diff
                );
            }

            if ($newStok < $currentStok) {
                
                $diff = $currentStok - $newStok;

                $stokGudang = $this->stokGudangRepository->getByGudangAndProduk(
                    $gudangId, 
                    $produkId
                );

                if(!$stokGudang) {
                    throw ValidationException::withMessages([
                        'gudang' => ['Product tidak ditemukan di gudang ini.'],
                    ]);
                }

                $this->stokGudangRepository->updateStock(
                    $gudangId, 
                    $produkId, 
                    $stokGudang->stok + $diff
                );
            }
            return $this->stokTokoRepository->updateStock(
                $tokoId, 
                $produkId, 
                $newStok);
        });
    }

    public function removeProdukFromToko(int $tokoId, int $produkId)
    {
        // $merchant = Merchant::findOrFail($merchantId);

        $toko = $this->tokoRepository->getById($tokoId, ['*']);

        if (!$toko) {
            throw ValidationException::withMessages([
                'produk' => ['Toko tidak ditemukan.'],
            ]);
        }

        $exists = $this->stokTokoRepository->getByTokoAndProduk($tokoId, $produkId);
        
        if (!$exists) {
            throw ValidationException::withMessages([
                'produk' => ['Produk tidak dimasukkan ke toko ini.']
            ]);
        }
        $toko->products()->detach($produkId);
    }
}