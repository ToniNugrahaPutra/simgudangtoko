<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Http\UploadedFile;

class AuthService
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            $data['foto'] = $this->uploadfoto($data['foto']);
        }

        return $this->authRepository->register($data);
    }

    public function login(array $data)
    {
        return $this->authRepository->login($data);
    }

    public function tokenLogin(array $data)
    {
        return $this->authRepository->tokenLogin($data);
    }

    private function uploadFoto(UploadedFile $foto):string
    {
        return $foto->store('pengguna', 'public');
    }
}