<?php

namespace App\Services;

use App\Models\SchoolClass;
use App\Models\Lecture;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ClassService
{
    /**
     * Get all classes with their students.
     */
    public function getAllClasses(): Collection
    {
        return SchoolClass::with('students')->get();
    }

    /**
     * Get a specific class with its students.
     */
    public function getClass(int $id): SchoolClass
    {
        $class = SchoolClass::with('students')->find($id);

        if (!$class) {
            throw new ModelNotFoundException('Класс не найден.');
        }

        return $class;
    }

    /**
     * Get curriculum (lectures) for a specific class.
     */
    public function getClassCurriculum(int $id): SchoolClass
    {
        $class = SchoolClass::with('lectures')->find($id);

        if (!$class) {
            throw new ModelNotFoundException('Класс не найден.');
        }

        return $class;
    }

    /**
     * Create a new class.
     */
    public function createClass(array $data): SchoolClass
    {
        return SchoolClass::create($data);
    }

    /**
     * Update a class.
     */
    public function updateClass(int $id, array $data): SchoolClass
    {
        $class = SchoolClass::find($id);

        if (!$class) {
            throw new ModelNotFoundException('Класс не найден.');
        }

        $class->update($data);

        return $class->fresh();
    }

    /**
     * Delete a class (students will be detached but not deleted).
     */
    public function deleteClass(int $id): bool
    {
        $class = SchoolClass::find($id);

        if (!$class) {
            throw new ModelNotFoundException('Класс не найден.');
        }

        // Detach students from class (set class_id to null)
        $class->students()->update(['class_id' => null]);

        return $class->delete();
    }

    /**
     * Update curriculum for a class.
     */
    public function updateCurriculum(int $classId, array $lectures): SchoolClass
    {
        $class = SchoolClass::find($classId);

        if (!$class) {
            throw new ModelNotFoundException('Класс не найден.');
        }

        DB::transaction(function () use ($class, $lectures) {
            // Remove existing curriculum
            $class->lectures()->detach();

            // Add new curriculum with order
            $curriculumData = [];
            foreach ($lectures as $lecture) {
                $curriculumData[$lecture['lecture_id']] = ['order' => $lecture['order']];
            }

            $class->lectures()->attach($curriculumData);
        });

        return $class->fresh(['lectures']);
    }
}

