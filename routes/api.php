<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ClassController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Student routes
Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index']); // 1) получить список всех студентов
    Route::get('/{id}', [StudentController::class, 'show']); // 2) получить информацию о конкретном студенте
    Route::post('/', [StudentController::class, 'store']); // 3) создать студента
    Route::put('/{id}', [StudentController::class, 'update']); // 4) обновить студента
    Route::delete('/{id}', [StudentController::class, 'destroy']); // 5) удалить студента
});

// Class routes
Route::prefix('classes')->group(function () {
    Route::get('/', [ClassController::class, 'index']); // 6) получить список всех классов
    Route::get('/{id}', [ClassController::class, 'show']); // 7) получить информацию о конкретном классе
    Route::get('/{id}/curriculum', [ClassController::class, 'curriculum']); // 8) получить учебный план для конкретного класса
    Route::post('/', [ClassController::class, 'store']); // 10) создать класс
    Route::put('/{id}', [ClassController::class, 'update']); // 11) обновить класс
    Route::put('/{id}/curriculum', [ClassController::class, 'updateCurriculum']); // 9) создать/обновить учебный план
    Route::delete('/{id}', [ClassController::class, 'destroy']); // 12) удалить класс
});

