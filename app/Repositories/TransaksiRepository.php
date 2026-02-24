<?php

namespace App\Repositories;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class TransaksiRepository
{
    public function getAll(array $fields = ['*'])
    {
        return Transaksi::select($fields)
            ->with(['detailTransaksi.produk.kategori', 'toko.operator'])
            ->latest()
            ->get();
    }

    public function getById(int $id, array $fields = ['*'])
    {
        return Transaksi::select($fields)
            ->with(['detailTransaksi.produk.kategori', 'toko.operator'])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return Transaksi::create($data);
    }

    public function update(int $id, array $data)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($data);
        return $transaksi;
    }

    public function delete(int $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return $transaksi->delete();
    }

    public function createDetailTransaksi(int $transaksiId, array $products)
    {
        foreach ($products as $product) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksiId,
                'produk_id' => $product['produk_id'],
                'jumlah' => $product['jumlah'],
                'harga' => $product['harga'],
                'sub_total' => $product['sub_total'],
            ]);
        }
    }

    public function getTransaksiByToko(int $tokoId)
    {
        return Transaksi::where('toko_id', $tokoId)
            ->with(['toko', 'detailTransaksi.produk.kategori'])
            ->latest()
            ->get();
    }
}
