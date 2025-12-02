<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Endpoint publik untuk
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Endpoint yang dilindungi (membutuhkan token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rute API untuk role tertentu
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // GET /api/admin/test
        Route::get('/test', fn () => response()->json(['message' => 'Admin API works']));
    });

    Route::middleware('role:verifikator')->prefix('verifikator')->group(function () {
        // GET /api/verifikator/test
        Route::get('/test', fn () => response()->json(['message' => 'Verifikator API works']));
    });

    Route::middleware('role:user')->prefix('user')->group(function () {
        // GET /api/user/test
        Route::get('/test', fn () => response()->json(['message' => 'User API works']));
    });
});