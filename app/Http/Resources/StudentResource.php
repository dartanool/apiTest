<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'email' => $this->email,
            'class_id' => $this->class_id,
            'class' => $this->whenLoaded('class', function () {
                return [
                    'id' => $this->class->id,
                    'name' => $this->class->name,
                ];
            }),
            'attended_lectures' => $this->whenLoaded('attendedLectures', function () {
                return $this->attendedLectures->map(function ($lecture) {
                    return [
                        'id' => $lecture->id,
                        'topic' => $lecture->topic,
                        'description' => $lecture->description,
                        'attended_at' => $lecture->pivot->attended_at,
                    ];
                });
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
