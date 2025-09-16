<?php

namespace App\Services;

use App\Models\SchoolClass;
use App\Models\Lecture;
use App\DTOs\ClassDTO;
use App\DTOs\CurriculumDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ClassService
{
    /**
     * найти все классы с их студентами
     */
    public function getAll(): Collection
    {
        return SchoolClass::with('students')->get();
    }

    /**
     * найти класс с его студентами
     */
    public function get(int $id): SchoolClass
    {
        $class = SchoolClass::with('students')->findOrFail($id);  
        // ->find($id);

        // if (!$class) {
        //     throw new ModelNotFoundException('Класс не найден.');
        // }

        return $class;
    }

    /**
     * найти учебный план по классу
     */
    public function getCurriculum(int $id): SchoolClass
    {
        $class = SchoolClass::with('lectures')->findOrFail($id);  

        // if (!$class) {
        //     throw new ModelNotFoundException('Класс не найден.');
        // }

        return $class;
    }

    /**
     * создать класс
     */
    public function create(ClassDTO $dto): SchoolClass
    {
        return SchoolClass::create($dto->toArray());
    }

    /**
     * обновить класс
     */
    public function update(int $id, ClassDTO $dto): SchoolClass
    {
        $class = SchoolClass::findOrFail($id);

        $class->update($dto->toArray());

        return $class->fresh();
    }

    /**
     * удалить класс
     */
    public function delete(int $id): bool
    {
        $class = SchoolClass::findOrFail($id);

        // if (!$class) {
        //     throw new ModelNotFoundException('Класс не найден.');
        // }

        // открепить студентов от класса 
        $class->students()->update(['class_id' => null]);

        return $class->delete();
    }

    /**
     * обновить учебный план по классу
     */
    public function updateCurriculum(CurriculumDTO $dto): SchoolClass
    {
        $class = SchoolClass::findOrFail($dto->classId);

        DB::transaction(function () use ($class, $dto) {
            // удалить существующий учебный план
            $class->lectures()->detach();

            // добавить новый учебный план с порядком
            $curriculumData = [];
            foreach ($dto->lectures as $lecture) {
                $curriculumData[$lecture['lecture_id']] = ['order' => $lecture['order']];
            }

            $class->lectures()->attach($curriculumData);
        });

        return $class->fresh(['lectures']);
    }
}

