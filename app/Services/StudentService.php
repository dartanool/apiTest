<?php

namespace App\Services;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentService
{
    /**
     * Get all students with their class information.
     */
    public function getAllStudents(): Collection
    {
        return Student::with('class')->get();
    }

    /**
     * Get a specific student with class and attended lectures.
     */
    public function getStudent(int $id): Student
    {
        $student = Student::with(['class', 'attendedLectures'])
            ->find($id);

        if (!$student) {
            throw new ModelNotFoundException('Студент не найден.');
        }

        return $student;
    }

    /**
     * Create a new student.
     */
    public function createStudent(array $data): Student
    {
        return Student::create($data);
    }

    /**
     * Update a student.
     */
    public function updateStudent(int $id, array $data): Student
    {
        $student = Student::find($id);

        if (!$student) {
            throw new ModelNotFoundException('Студент не найден.');
        }

        $student->update($data);

        return $student->fresh(['class']);
    }

    /**
     * Delete a student.
     */
    public function deleteStudent(int $id): bool
    {
        $student = Student::find($id);

        if (!$student) {
            throw new ModelNotFoundException('Студент не найден.');
        }

        return $student->delete();
    }

    /**
     * Mark a student as attended a lecture.
     */
    public function markLectureAttended(int $studentId, int $lectureId): void
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new ModelNotFoundException('Студент не найден.');
        }

        $student->attendedLectures()->syncWithoutDetaching([
            $lectureId => ['attended_at' => now()]
        ]);
    }
}

