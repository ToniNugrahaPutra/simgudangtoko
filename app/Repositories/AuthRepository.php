<?php 

namespace App\Repositories;

use App\Http\Resources\PenggunaResource;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function register(array $data)
    {
        return Pengguna::create([
            'nama'      => $data['nama'],
            'email'     => $data['email'],
            'no_hp'     => $data['no_hp'],
            'foto'     => $data['foto'],
            'password'  => Hash::make($data['password']),
        ]);
    }
    
    public function login(array $data)
    {
        $credentials = [
            'email'     => $data['email'],
            'password'  => $data['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.',
            ], 401);
        }

        request()->session()->regenerate();

        $pengguna = Auth::pengguna();

        return response()->json([
            'message'   => 'Login successful.',
            'pengguna'      => new PenggunaResource($pengguna->load('role')),
        ]);
    }

    public function tokenLogin(array $data)
    {
        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return response()->json(['message' => 'Invalid Credentials',], 401);
        }

        $pengguna = Auth::pengguna();
        $token = $pengguna->createToken('API Token')->plainTextToken;

        return response()->json([
            'message'   => 'Login successful.',
            'token'     => $token,
            'pengguna'      => new PenggunaResource($pengguna->load('role')),
        ]);
    }
}
