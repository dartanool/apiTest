<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Create a successful API response
     */
    protected function successResponse(
        string $message,
        mixed $data = null,
        int $status = 200
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    /**
     * Create an error API response
     */
    protected function errorResponse(
        string $message,
        mixed $errors = null,
        mixed $error = null,
        int $status = 400
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        if ($error !== null) {
            $response['error'] = $error;
        }

        return response()->json($response, $status);
    }
}
