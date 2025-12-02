<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiTrait
{
    /**
     * Mengembalikan respons JSON sukses.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, string $message = '', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Mengembalikan respons JSON error.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @param  mixed|null  $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode = 400, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}