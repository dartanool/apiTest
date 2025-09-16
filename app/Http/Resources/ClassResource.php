<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'students' => $this->whenLoaded('students', function () {
                return StudentResource::collection($this->students);
            }),
            'lectures' => $this->whenLoaded('lectures', function () {
                return LectureResource::collection($this->lectures);
            }),
            'students_count' => $this->when(isset($this->students_count), $this->students_count),
            'lectures_count' => $this->when(isset($this->lectures_count), $this->lectures_count),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
