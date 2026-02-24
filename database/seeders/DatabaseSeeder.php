<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PenggunaSeeder::class,
            KategoriSeeder::class,
            ProdukSeeder::class,
            GudangSeeder::class,
            StokGudangSeeder::class,
            TokoSeeder::class,
            StokTokoSeeder::class,
        ]);
    }
}
