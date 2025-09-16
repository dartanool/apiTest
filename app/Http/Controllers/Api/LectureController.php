<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecture\StoreLectureRequest;
use App\Http\Requests\Lecture\UpdateLectureRequest;
use App\Http\Resources\LectureResource;
use App\Http\Resources\LectureCollection;
use App\Services\LectureService;
use App\DTOs\LectureDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LectureController extends Controller
{

    public function __construct(
        private readonly LectureService $lectureService
    ) {}

    /**
     * получить список всех лекций
     */
    public function index(): JsonResponse
    {
        $lectures = $this->lectureService->getAll();
        return response()->json(LectureCollection::make($lectures));
    }

    /**
     * получить информацию о конкретной лекции
     */
    public function show(int $id): JsonResponse
    {
        $lecture = $this->lectureService->getById($id);
        return response()->json(new LectureResource($lecture));
    }

    /**
     *  создать лекцию
     */
    public function store(StoreLectureRequest $request): JsonResponse
    {
        $lectureDTO = LectureDTO::fromArray($request->validated());
        $lecture = $this->lectureService->create($lectureDTO);
        return response()->json(new LectureResource($lecture), 201);
    }

    /**
     *  обновить лекцию
     */
    public function update(UpdateLectureRequest $request, int $id): JsonResponse
    {
        $lectureDTO = LectureDTO::fromArray($request->validated());
        $lecture = $this->lectureService->update($id, $lectureDTO);
        return response()->json(new LectureResource($lecture));
    }

    /**
     * удалить лекцию
     */
    public function destroy(int $id): JsonResponse
    {
        $this->lectureService->delete($id);
        return response()->json([], 204);
    }
}
