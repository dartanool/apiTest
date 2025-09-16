<?php

namespace App\Services;

use App\Models\Lecture;
use App\DTOs\LectureDTO;
use Illuminate\Database\Eloquent\Collection;

class LectureService
{
    /**
     * найти все лекции
     */
    public function getAll(): Collection
    {
        return Lecture::all();
    }

    /**
     * найти лекцию по ID с классами и студентами
     */
    public function getById(int $id): Lecture
    {
        return Lecture::with(['classes', 'students'])
            ->findOrFail($id);
    }

    /**
     * создать лекцию
     */
    public function create(LectureDTO $dto): Lecture
    {
        return Lecture::create($dto->toArray());
    }

    /**
     * обновить лекцию
     */
    public function update(int $id, LectureDTO $dto): Lecture
    {
        $lecture = Lecture::findOrFail($id);
        
        $lecture->update($dto->toArray());
        return $lecture->fresh();
    }

    /**
     * удалить лекцию
     */
    public function delete(int $id): bool
    {
        $lecture = Lecture::findOrFail($id);
        
        return $lecture->delete();
    }
}
