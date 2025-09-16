<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use App\Http\Traits\ApiResponseTrait;
use App\Services\StudentService;
use App\DTOs\StudentDTO;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private StudentService $studentService
    ) {}

    /**
     * получить список всех студентов
     */
    public function index(): JsonResponse
    {
        $students = $this->studentService->getAll();

        return $this->successResponse(
            message: 'Список студентов получен успешно.',
            data: StudentCollection::make($students)
        );
    }

    /**
     * получить информацию о конкретном студенте
     */
    public function show(int $id): JsonResponse
    {
        $student = $this->studentService->get($id);

        return $this->successResponse(
            message: 'Информация о студенте получена успешно.',
            data: new StudentResource($student)
        );
    }

    /**
     * создать студента
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        $dto = StudentDTO::fromArray($request->validated());
        $student = $this->studentService->create($dto);

        return $this->successResponse(
            message: 'Студент успешно создан.',
            data: new StudentResource($student->load('class')),
            status: 201
        );
    }

    /**
     *  обновить студента
     */
    public function update(UpdateStudentRequest $request, int $id): JsonResponse
    {
        $dto = StudentDTO::fromArray($request->validated());
        $student = $this->studentService->update($id, $dto);

        return $this->successResponse(
            message: 'Студент успешно обновлен.',
            data: new StudentResource($student)
        );
    }

    /**
     * удалить студента
     */
    public function destroy(int $id): JsonResponse
    {
        $this->studentService->delete($id);

        return $this->successResponse(
            message: 'Студент успешно удален.'
        );
    }
}

