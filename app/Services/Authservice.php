<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private AuthRepository $authRepository
    ) {}

    public function register(array $data)
    {
        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            $data['foto'] = $this->uploadFoto($data['foto']);
        }

        return $this->authRepository->register($data);
    }

    public function login(array $data)
    {
        $pengguna = $this->authRepository->findByEmail($data['email']);

        if (!$pengguna) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        $this->authRepository->validatePassword($pengguna, $data['password']);

        $token = $this->authRepository->createToken($pengguna);

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $pengguna->load('roles'),
        ]);
    }


    private function uploadFoto(UploadedFile $foto): string
    {
        return $foto->store('pengguna', 'public');
    }
}
