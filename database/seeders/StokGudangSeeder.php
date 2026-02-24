<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\Produk;
use App\Models\StokGudang;
use Illuminate\Database\Seeder;

class StokGudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gudang = Gudang::where('nama', 'Gudang Pusat')->first();
        $produk = Produk::all();

        if ($gudang) {
            foreach ($produk as $p) {
                StokGudang::firstOrCreate(
                    [
                        'gudang_id' => $gudang->id,
                        'produk_id' => $p->id,
                    ],
                    [
                        'stok' => 1000,
                    ]
                );
            }
        }
    }
}
