<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elektronik = Kategori::where('nama', 'Elektronik')->first();
        $pakaian = Kategori::where('nama', 'Pakaian')->first();
        $makanan = Kategori::where('nama', 'Makanan')->first();

        if ($elektronik) {
            Produk::create([
                'nama' => 'Smartphone X',
                'thumbnail' => 'smartphone.png',
                'deskripsi' => 'Flagship smartphone',
                'harga' => 5000000,
                'kategori_id' => $elektronik->id,
                'is_popular' => true,
            ]);
            Produk::create([
                'nama' => 'Laptop Pro',
                'thumbnail' => 'laptop.png',
                'deskripsi' => 'High performance laptop',
                'harga' => 15000000,
                'kategori_id' => $elektronik->id,
                'is_popular' => false,
            ]);
        }

        if ($pakaian) {
            Produk::create([
                'nama' => 'Kaos Polos',
                'thumbnail' => 'kaos.png',
                'deskripsi' => 'Comfortable cotton t-shirt',
                'harga' => 50000,
                'kategori_id' => $pakaian->id,
                'is_popular' => true,
            ]);
        }

        if ($makanan) {
            Produk::create([
                'nama' => 'Keripik Pedas',
                'thumbnail' => 'keripik.png',
                'deskripsi' => 'Spicy chips',
                'harga' => 15000,
                'kategori_id' => $makanan->id,
                'is_popular' => true,
            ]);
        }
    }
}
