<?php

namespace App\Services;

use App\Models\Lecture;
use Illuminate\Database\Eloquent\Collection;

class LectureService
{
    /**
     * Get all lectures.
     */
    public function getAllLectures(): Collection
    {
        return Lecture::all();
    }

    /**
     * Get lecture by ID with classes and students.
     */
    public function getLectureById(int $id): ?Lecture
    {
        return Lecture::with(['classes', 'students'])
            ->find($id);
    }

    /**
     * Create a new lecture.
     */
    public function createLecture(array $data): Lecture
    {
        return Lecture::create($data);
    }

    /**
     * Update lecture.
     */
    public function updateLecture(int $id, array $data): ?Lecture
    {
        $lecture = Lecture::find($id);
        
        if (!$lecture) {
            return null;
        }

        $lecture->update($data);
        return $lecture->fresh();
    }

    /**
     * Delete lecture.
     */
    public function deleteLecture(int $id): bool
    {
        $lecture = Lecture::find($id);
        
        if (!$lecture) {
            return false;
        }

        return $lecture->delete();
    }
}
