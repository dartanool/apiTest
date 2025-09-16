<?php

namespace App\DTOs;

class ClassDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            id: $data['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function toArrayWithId(): array
    {
        return array_merge($this->toArray(), [
            'id' => $this->id,
        ]);
    }
}
