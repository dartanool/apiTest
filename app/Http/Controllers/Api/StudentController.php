<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use App\Services\StudentService;
use App\DTOs\StudentDTO;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{

    public function __construct(
        private StudentService $studentService
    ) {}

    /**
     * получить список всех студентов
     */
    public function index(): JsonResponse
    {
        $students = $this->studentService->getAll();
        return response()->json(StudentCollection::make($students));
    }

    /**
     * получить информацию о конкретном студенте
     */
    public function show(int $id): JsonResponse
    {
        $student = $this->studentService->get($id);
        return response()->json(new StudentResource($student));
    }

    /**
     * создать студента
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        $dto = StudentDTO::fromArray($request->validated());
        $student = $this->studentService->create($dto);
        return response()->json(new StudentResource($student->load('class')), 201);
    }

    /**
     *  обновить студента
     */
    public function update(UpdateStudentRequest $request, int $id): JsonResponse
    {
        $dto = StudentDTO::fromArray($request->validated());
        $student = $this->studentService->update($id, $dto);
        return response()->json(new StudentResource($student));
    }

    /**
     * удалить студента
     */
    public function destroy(int $id): JsonResponse
    {
        $this->studentService->delete($id);
        return response()->json([], 204);
    }
}

