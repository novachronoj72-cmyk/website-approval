<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiTrait;

    /**
     * Registrasi user baru.
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::USER, // Default role
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse(
            [
                'token' => $token,
                'user' => $user,
            ],
            'Registrasi berhasil.'
        );
    }

    /**
     * Login user.
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial tidak valid.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse(
            [
                'token' => $token,
                'user' => $user,
            ],
            'Login berhasil.'
        );
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Logout berhasil.');
    }
}