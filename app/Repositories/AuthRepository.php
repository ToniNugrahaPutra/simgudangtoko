<?php

namespace App\Repositories;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthRepository
{
    public function register(array $data): Pengguna
    {
        return Pengguna::create($data);
    }

    public function findByEmail(string $email): ?Pengguna
    {
        return Pengguna::where('email', $email)->first();
    }

    public function validatePassword(Pengguna $pengguna, string $password): void
    {
        if (!Hash::check($password, $pengguna->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }
    }

    public function createToken(Pengguna $pengguna): string
    {
        $pengguna->tokens()->delete();

        return $pengguna->createToken('auth_token')->plainTextToken;
    }
}