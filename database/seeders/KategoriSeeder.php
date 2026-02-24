<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Elektronik',
                'foto' => 'elektronik.png',
                'tagline' => 'Gadgets and more',
            ],
            [
                'nama' => 'Pakaian',
                'foto' => 'pakaian.png',
                'tagline' => 'Fashion for everyone',
            ],
            [
                'nama' => 'Makanan',
                'foto' => 'makanan.png',
                'tagline' => 'Delicious and fresh',
            ],
        ];

        foreach ($categories as $category) {
            Kategori::firstOrCreate(['nama' => $category['nama']], $category);
        }
    }
}
