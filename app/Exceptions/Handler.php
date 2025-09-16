<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Обработка API запросов
        if ($request->is('api/*') || $request->expectsJson()) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle API exceptions
     */
    private function handleApiException(Request $request, Throwable $e): JsonResponse
    {
        if ($e instanceof ModelNotFoundException) {
            return $this->apiResponse(
                success: false,
                message: 'Ресурс не найден.',
                status: 404
            );
        }

        if ($e instanceof ValidationException) {
            return $this->apiResponse(
                success: false,
                message: 'Ошибка валидации данных.',
                errors: $e->errors(),
                status: 422
            );
        }

        // Общая ошибка сервера
        return $this->apiResponse(
            success: false,
            message: 'Внутренняя ошибка сервера.',
            error: config('app.debug') ? $e->getMessage() : 'Произошла ошибка при обработке запроса.',
            status: 500
        );
    }

    /**
     * Create a standardized API response
     */
    private function apiResponse(
        bool $success,
        string $message,
        mixed $data = null,
        mixed $errors = null,
        mixed $error = null,
        int $status = 200
    ): JsonResponse {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        if ($error !== null) {
            $response['error'] = $error;
        }

        return response()->json($response, $status);
    }
}