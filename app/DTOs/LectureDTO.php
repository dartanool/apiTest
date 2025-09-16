<?php

namespace App\DTOs;

class LectureDTO
{
    public function __construct(
        public readonly string $topic,
        public readonly string $description,
        public readonly ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            topic: $data['topic'],
            description: $data['description'],
            id: $data['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'topic' => $this->topic,
            'description' => $this->description,
        ];
    }

    public function toArrayWithId(): array
    {
        return array_merge($this->toArray(), [
            'id' => $this->id,
        ]);
    }
}
