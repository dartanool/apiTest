<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Class\StoreClassRequest;
use App\Http\Requests\Class\UpdateClassRequest;
use App\Http\Requests\Class\UpdateCurriculumRequest;
use App\Http\Resources\ClassResource;
use App\Http\Resources\ClassCollection;
use App\Services\ClassService;
use App\Http\Traits\ApiResponseTrait;
use App\DTOs\ClassDTO;
use App\DTOs\CurriculumDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClassController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private ClassService $classService
    ) {}

    /**
     * получить список всех классов
     */
    public function index(): JsonResponse
    {
        $classes = $this->classService->getAll();
        return $this->successResponse(
            'Список классов успешно получен.',
            ClassCollection::make($classes)
        );
    }

    /**
     * получить информацию о конкретном классе
     */
    public function show(int $id): JsonResponse
    {
        $class = $this->classService->get($id);
        return $this->successResponse(
            'Информация о классе успешно получена.',
            new ClassResource($class)
        );
    }

    /**
     *  получить учебный план 
     */
    public function curriculum(int $id): JsonResponse
    {
        $class = $this->classService->getCurriculum($id);
        return $this->successResponse(
            'Учебный план успешно получен.',
            new ClassResource($class)
        );
    }

    /**
     * создать класс
     */
    public function store(StoreClassRequest $request): JsonResponse
    {
        $classDTO = ClassDTO::fromArray($request->validated());
        $class = $this->classService->create($classDTO);
        
        return $this->successResponse(
            'Класс успешно создан.',
            new ClassResource($class),
            201
        );
    }

    /**
     * обновить класс 
     */
    public function update(UpdateClassRequest $request, int $id): JsonResponse
    {
        $classDTO = ClassDTO::fromArray($request->validated());
        $class = $this->classService->update($id, $classDTO);
        
        return $this->successResponse(
            'Класс успешно обновлен.',
            new ClassResource($class)
        );
    }

    /**
     * создать/обновить учебный план 
     */
    public function updateCurriculum(UpdateCurriculumRequest $request, int $id): JsonResponse
    {
        $curriculumDTO = CurriculumDTO::fromArray([
            'class_id' => $id,
            'lectures' => $request->validated()['lectures']
        ]);
        $class = $this->classService->updateCurriculum($curriculumDTO);
        
        return $this->successResponse(
            'Учебный план успешно обновлен.',
            new ClassResource($class)
        );
    }

    /**
     * удалить класс 
     */
    public function destroy(int $id): JsonResponse
    {
        $this->classService->delete($id);
        return $this->successResponse('Класс успешно удален.');
    }
}