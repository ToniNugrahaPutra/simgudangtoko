<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = Pengguna::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'nama' => 'Admin',
                'password' => 'password', // Mutator in model might hash this, but explicit hashing is safer if needed. Model has casts => 'hashed', so plain string is fine.
                'foto' => 'default.png',
                'no_hp' => '081234567890',
            ]
        );
        $admin->assignRole('admin');

        // Create Operator
        $operator = Pengguna::firstOrCreate(
            ['email' => 'operator@operator.com'],
            [
                'nama' => 'Operator',
                'password' => 'password',
                'foto' => 'default.png',
                'no_hp' => '080987654321',
            ]
        );
        $operator->assignRole('operator');
    }
}
