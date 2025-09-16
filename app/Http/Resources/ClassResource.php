<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'students' => $this->whenLoaded('students', function () {
                return $this->students->map(function ($student) {
                    return [
                        'id' => $student->id,
                        'name' => $student->name,
                        'email' => $student->email,
                        'class_id' => $student->class_id,
                    ];
                });
            }),
            'lectures' => $this->whenLoaded('lectures', function () {
                return $this->lectures->map(function ($lecture) {
                    return [
                        'id' => $lecture->id,
                        'topic' => $lecture->topic,
                        'description' => $lecture->description,
                        'order' => $lecture->pivot->order,
                    ];
                });
            }),
            'students_count' => $this->when(isset($this->students_count), $this->students_count),
            'lectures_count' => $this->when(isset($this->lectures_count), $this->lectures_count),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
