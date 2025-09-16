<?php

namespace Database\Seeders;

use App\Models\Lecture;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создать лекции
        $lectures = Lecture::factory(10)->create();

        // Создать классы
        $classes = SchoolClass::factory(3)->create();

        // Создать студентов
        $students = Student::factory(15)->create();

        // Назначить некоторых студентов в классы
        $students->take(12)->each(function ($student, $index) use ($classes) {
            $student->update(['class_id' => $classes->random()->id]);
        });

        // Создать учебный план для каждого класса
        $classes->each(function ($class) use ($lectures) {
            $selectedLectures = $lectures->random(rand(5, 8));
            $curriculumData = [];
            
            foreach ($selectedLectures as $index => $lecture) {
                $curriculumData[$lecture->id] = ['order' => $index + 1];
            }
            
            $class->lectures()->attach($curriculumData);
        });

        // Отметить некоторых студентов как посетивших некоторые лекции
        $students->take(8)->each(function ($student) use ($lectures) {
            $attendedLectures = $lectures->random(rand(2, 5));
            $attendanceData = [];
            
            foreach ($attendedLectures as $lecture) {
                $attendanceData[$lecture->id] = ['attended_at' => now()->subDays(rand(1, 30))];
            }
            
            $student->attendedLectures()->attach($attendanceData);
        });
    }
}

