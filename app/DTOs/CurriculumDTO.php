<?php

namespace App\DTOs;

class CurriculumDTO
{
    public function __construct(
        public readonly int $classId,
        public readonly array $lectures,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            classId: $data['class_id'],
            lectures: $data['lectures'],
        );
    }

    public function toArray(): array
    {
        return [
            'class_id' => $this->classId,
            'lectures' => $this->lectures,
        ];
    }
}
