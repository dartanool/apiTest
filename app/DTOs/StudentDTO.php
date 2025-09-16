<?php

declare(strict_types=1);

namespace App\DTOs;

class StudentDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly int $classId,
        public readonly ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'] ?? '',
            classId: $data['class_id'] ?? 0,
            id: $data['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'class_id' => $this->classId,
        ];
    }

    public function toArrayWithId(): array
    {
        return array_merge($this->toArray(), [
            'id' => $this->id,
        ]);
    }
}
