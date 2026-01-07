<?php

namespace App\Services;

use App\Repositories\TransaksiRepository;
use App\Repositories\StokTokoRepository;
use App\Repositories\ProdukRepository;
use App\Repositories\TokoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TransaksiService
{
    private TransaksiRepository $transaksiRepository;
    private StokTokoRepository $stokTokoRepository;
    private ProdukRepository $produkRepository;
    private TokoRepository $tokoRepository;

    public function __construct(
        TransaksiRepository $transaksiRepository,
        StokTokoRepository $stokTokoRepository,
        ProdukRepository $produkRepository,
        TokoRepository $tokoRepository
    ){
        $this->transaksiRepository = $transaksiRepository;
        $this->stokTokoRepository = $stokTokoRepository;
        $this->produkRepository = $produkRepository;
        $this->tokoRepository = $tokoRepository;
    }

    public function createTransaksi(array $data)
    {
        return DB::transaction(function () use ($data) {

            $toko = $this->tokoRepository->getById($data['toko_id'], ['id','operator_id']);

            if (!$toko) {
                throw ValidationException::withMessages([
                    'toko_id' => ['Toko tidak ditemukan'],
                ]);
            }

            if (Auth::id() != $toko->operator_id) {
                throw ValidationException::withMessages([
                    'authorization' => ['Anda tidak berhak membuat transaksi untuk toko ini'],
                ]);
            }

            $items = [];
            $subTotal = 0;

            foreach ($data['produk'] as $item) {

                $stok = $this->stokTokoRepository->getByStokToko(
                    $data['toko_id'], 
                    $item['produk_id']
                );

                if(!$stok || $stok->stok < $item['jumlah']){
                    throw ValidationException::withMessages([
                        'stok' => ['Stok tidak cukup untuk produk ID '.$item['produk_id']],
                    ]);
                }

                $produk = $this->produkRepository->getById($item['produk_id'], ['id','harga']);

                $sub = $produk->harga * $item['jumlah'];
                $subTotal += $sub;

                $items[] = [
                    'produk_id' => $item['produk_id'],
                    'jumlah'    => $item['jumlah'],
                    'harga'     => $produk->harga,
                    'sub_total' => $sub,
                ];

                $this->stokTokoRepository->updateStok(
                    $data['toko_id'],
                    $item['produk_id'],
                    $stok->stok - $item['jumlah']
                );
            }

            $pajak = $subTotal * 0.10;
            $grandTotal = $subTotal + $pajak;

            $transaksi = $this->transaksiRepository->create([
                'nama'        => $data['nama'],
                'telepon'     => $data['telepon'],
                'toko_id'     => $data['toko_id'],
                'sub_total'   => $subTotal,
                'pajak_total' => $pajak,
                'grand_total' => $grandTotal,
            ]);

            $this->transaksiRepository->createDetailTransaksi($transaksi->id, $items);

            return $transaksi->fresh();
        });
    }
}