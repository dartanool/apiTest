<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
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
            'topic' => $this->topic,
            'description' => $this->description,
            'classes' => $this->whenLoaded('classes', function () {
                return $this->classes->map(function ($class) {
                    return [
                        'id' => $class->id,
                        'name' => $class->name,
                        'order' => $class->pivot->order,
                    ];
                });
            }),
            'students' => $this->whenLoaded('students', function () {
                return $this->students->map(function ($student) {
                    return [
                        'id' => $student->id,
                        'name' => $student->name,
                        'email' => $student->email,
                        'attended_at' => $student->pivot->attended_at,
                    ];
                });
            }),
            'classes_count' => $this->when(isset($this->classes_count), $this->classes_count),
            'students_count' => $this->when(isset($this->students_count), $this->students_count),
            'attended_students_count' => $this->when(isset($this->attended_students_count), $this->attended_students_count),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
