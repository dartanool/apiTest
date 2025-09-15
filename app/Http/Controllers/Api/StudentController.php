<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function __construct(
        private StudentService $studentService
    ) {}

    /**
     * Get all students.
     */
    public function index(): JsonResponse
    {
        try {
            $students = $this->studentService->getAllStudents();

            return response()->json([
                'success' => true,
                'data' => $students,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении списка студентов.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a specific student.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $student = $this->studentService->getStudent($id);

            return response()->json([
                'success' => true,
                'data' => $student,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Студент не найден.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении информации о студенте.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new student.
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        try {
            $student = $this->studentService->createStudent($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Студент успешно создан.',
                'data' => $student->load('class'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании студента.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a student.
     */
    public function update(UpdateStudentRequest $request, int $id): JsonResponse
    {
        try {
            $student = $this->studentService->updateStudent($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Студент успешно обновлен.',
                'data' => $student,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Студент не найден.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении студента.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a student.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->studentService->deleteStudent($id);

            return response()->json([
                'success' => true,
                'message' => 'Студент успешно удален.',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Студент не найден.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении студента.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

