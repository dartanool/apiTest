<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecture\StoreLectureRequest;
use App\Http\Requests\Lecture\UpdateLectureRequest;
use App\Services\LectureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function __construct(
        private readonly LectureService $lectureService
    ) {}

    /**
     * Display a listing of lectures.
     */
    public function index(): JsonResponse
    {
        try {
            $lectures = $this->lectureService->getAllLectures();
            
            return response()->json([
                'success' => true,
                'data' => $lectures
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve lectures',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified lecture with classes and students.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $lecture = $this->lectureService->getLectureById($id);
            
            if (!$lecture) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lecture not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $lecture
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve lecture',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created lecture.
     */
    public function store(StoreLectureRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $lecture = $this->lectureService->createLecture($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Lecture created successfully',
                'data' => $lecture
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create lecture',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified lecture.
     */
    public function update(UpdateLectureRequest $request, int $id): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $lecture = $this->lectureService->updateLecture($id, $validatedData);

            if (!$lecture) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lecture not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Lecture updated successfully',
                'data' => $lecture
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update lecture',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified lecture.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->lectureService->deleteLecture($id);

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lecture not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Lecture deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete lecture',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
