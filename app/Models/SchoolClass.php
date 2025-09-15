<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
    ];

    /**
     * Get the students for the class.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    /**
     * Get the lectures for the class curriculum.
     */
    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class, 'class_lectures', 'class_id', 'lecture_id')
            ->withPivot('order')
            ->orderBy('class_lectures.order');
    }
}
