<?php

namespace App\Http\Controllers;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\PenggunaResource;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $perngguna = $this->authService->register($request->validated());
        return response()->json(['message' => 'Pengguna berhasil register', 'pengguna' => $pengguna], 201);
    }
    
    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }

    public function tokenLogin(LoginRequest $request)
    {
        return $this->authService->tokenLogin($request->validated());
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function pengguna(Request $request)
    {
        return response()->json(new PenggunaResource($request->pengguna()));
    }
}
