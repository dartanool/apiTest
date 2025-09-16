<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\Handler;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Создаем Response Macro для API ответов
        \Illuminate\Support\Facades\Response::macro('api', function ($data = null, int $status = 200, string $message = null) {
            $message = $message ?? $this->getDefaultMessage($status);
            
            return response()->json([
                'success' => $status >= 200 && $status < 300,
                'message' => $message,
                'data' => $data,
            ], $status);
        });
    }

    /**
     * Получить сообщение по умолчанию для статус кода
     */
    private function getDefaultMessage(int $statusCode): string
    {
        return match ($statusCode) {
            200 => 'Запрос выполнен успешно.',
            201 => 'Ресурс успешно создан.',
            202 => 'Запрос принят к обработке.',
            204 => 'Ресурс успешно удален.',
            default => 'Операция выполнена успешно.',
        };
    }
}
