<?php
declare(strict_types=1);
    
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Class\StoreClassRequest;
use App\Http\Requests\Class\UpdateClassRequest;
use App\Http\Requests\Class\UpdateCurriculumRequest;
use App\Http\Resources\ClassResource;
use App\Http\Resources\ClassCollection;
use App\Services\ClassService;
use App\DTOs\ClassDTO;
use App\DTOs\CurriculumDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClassController extends Controller
{

    public function __construct(
        private ClassService $classService
    ) {}

    /**
     * получить список всех классов
     */
    public function index(): JsonResponse
    {
        $classes = $this->classService->getAll();
        return response()->json(ClassCollection::make($classes));
    }

    /**
     * получить информацию о конкретном классе
     */
    public function show(int $id): JsonResponse
    {
        $class = $this->classService->get($id);
        return response()->json(new ClassResource($class));
    }

    /**
     *  получить учебный план 
     */
    public function curriculum(int $id): JsonResponse
    {
        $class = $this->classService->getCurriculum($id);
        return response()->json(new ClassResource($class));
    }

    /**
     * создать класс
     */
    public function store(StoreClassRequest $request): JsonResponse
    {
        $classDTO = ClassDTO::fromArray($request->validated());
        $class = $this->classService->create($classDTO);
        return response()->json(new ClassResource($class), 201);
    }

    /**
     * обновить класс 
     */
    public function update(UpdateClassRequest $request, int $id): JsonResponse
    {
        $classDTO = ClassDTO::fromArray($request->validated());
        $class = $this->classService->update($id, $classDTO);
        return response()->json(new ClassResource($class));
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
        return response()->json(new ClassResource($class));
    }

    /**
     * удалить класс 
     */
    public function destroy(int $id): JsonResponse
    {
        $this->classService->delete($id);
        return response()->json([], 204);
    }
}