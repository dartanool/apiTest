<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\LectureController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Студенты
Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index']); // 1) получить список всех студентов
    Route::get('/{id}', [StudentController::class, 'show']); // 2) получить информацию о конкретном студенте
    Route::post('/', [StudentController::class, 'store']); // 3) создать студента
    Route::put('/{id}', [StudentController::class, 'update']); // 4) обновить студента
    Route::delete('/{id}', [StudentController::class, 'destroy']); // 5) удалить студента
});

// Классы
Route::prefix('classes')->group(function () {
    Route::get('/', [ClassController::class, 'index']); // 6) получить список всех классов
    Route::get('/{id}', [ClassController::class, 'show']); // 7) получить информацию о конкретном классе
    Route::get('/{id}/curriculum', [ClassController::class, 'curriculum']); // 8) получить учебный план для конкретного класса
    Route::post('/', [ClassController::class, 'store']); // 10) создать класс
    Route::put('/{id}', [ClassController::class, 'update']); // 11) обновить класс
    Route::put('/{id}/curriculum', [ClassController::class, 'updateCurriculum']); // 9) создать/обновить учебный план
    Route::delete('/{id}', [ClassController::class, 'destroy']); // 12) удалить класс
});

// Лекции
Route::prefix('lectures')->group(function () {
    Route::get('/', [LectureController::class, 'index']); // 13) получить список всех лекций
    Route::get('/{id}', [LectureController::class, 'show']); // 14) получить информацию о конкретной лекции
    Route::post('/', [LectureController::class, 'store']); // 15) создать лекцию
    Route::put('/{id}', [LectureController::class, 'update']); // 16) обновить лекцию
    Route::delete('/{id}', [LectureController::class, 'destroy']); // 17) удалить лекцию
});

