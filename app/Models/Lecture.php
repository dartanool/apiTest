<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'description',
    ];

    /**
     * Get the classes that have this lecture in their curriculum.
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_lectures', 'lecture_id', 'class_id')
            ->withPivot('order')
            ->orderBy('class_lectures.order');
    }

    /**
     * Get the students who have attended this lecture.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_lectures')
            ->withPivot('attended_at')
            ->withTimestamps();
    }
}
