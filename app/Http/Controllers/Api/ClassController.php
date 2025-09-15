<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Class\StoreClassRequest;
use App\Http\Requests\Class\UpdateClassRequest;
use App\Http\Requests\Class\UpdateCurriculumRequest;
use App\Services\ClassService;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClassController extends Controller
{
    public function __construct(
        private ClassService $classService
    ) {}

    /**
     * Get all classes.
     */
    public function index(): JsonResponse
    {
        try {
            $classes = $this->classService->getAllClasses();

            return response()->json([
                'success' => true,
                'data' => $classes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении списка классов.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a specific class.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $class = $this->classService->getClass($id);

            return response()->json([
                'success' => true,
                'data' => $class,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Класс не найден.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении информации о классе.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get curriculum for a specific class.
     */
    public function curriculum(int $id): JsonResponse
    {
        try {
            $class = $this->classService->getClassCurriculum($id);

            return response()->json([
                'success' => true,
                'data' => $class,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Класс не найден.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении учебного плана.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new class.
     */
    public function store(StoreClassRequest $request): JsonResponse
    {
        try {
            $class = $this->classService->createClass($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Класс успешно создан.',
                'data' => $class,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании класса.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a class.
     */
    public function update(UpdateClassRequest $request, int $id): JsonResponse
    {
        try {
            $class = $this->classService->updateClass($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Класс успешно обновлен.',
                'data' => $class,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Класс не найден.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении класса.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update curriculum for a class.
     */
    public function updateCurriculum(UpdateCurriculumRequest $request, int $id): JsonResponse
    {
        try {
            $class = $this->classService->updateCurriculum($id, $request->validated()['lectures']);

            return response()->json([
                'success' => true,
                'message' => 'Учебный план успешно обновлен.',
                'data' => $class,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Класс не найден.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении учебного плана.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a class.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->classService->deleteClass($id);

            return response()->json([
                'success' => true,
                'message' => 'Класс успешно удален.',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Класс не найден.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении класса.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

