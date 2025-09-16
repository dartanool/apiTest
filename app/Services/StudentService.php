<?php

namespace App\Services;

use App\Models\Student;
use App\Models\SchoolClass;
use App\DTOs\StudentDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentService
{
    /**
     * найти все студентов с информацией о классе
     */
    public function getAll(): Collection
    {
        return Student::with('class')->get();
    }

    /**
     * найти студента по ID с информацией о классе и посещенных лекциях
     */
    public function get(int $id): Student
    {
        return Student::with(['class', 'attendedLectures'])
            ->findOrFail($id);
    }

    /**
     * создать студента
     */
    public function create(StudentDTO $dto): Student
    {
        return Student::create($dto->toArray());
    }

    /**
     * обновить студента
     */
    public function update(int $id, StudentDTO $dto): Student
    {
        $student = Student::findOrFail($id);

        $student->update($dto->toArray());

        return $student->fresh(['class']);
    }

    /**
     * удалить студента
     */
    public function delete(int $id): bool
    {
        $student = Student::findOrFail($id);

        return $student->delete();
    }

    /**
    * отметить студента как посетившего лекцию
     */
    public function markLectureAttended(int $studentId, int $lectureId): void
    {
        $student = Student::findOrFail($studentId);

        $student->attendedLectures()->syncWithoutDetaching([
            $lectureId => ['attended_at' => now()]
        ]);
    }
}

