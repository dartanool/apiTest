<?php

namespace Tests\Feature;

use App\Models\Lecture;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_students(): void
    {
        Student::factory()->count(3)->create();

        $response = $this->getJson('/api/students');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'class_id',
                        'class'
                    ]
                ]
            ]);
    }

    public function test_get_specific_student(): void
    {
        $student = Student::factory()->create();

        $response = $this->getJson("/api/students/{$student->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'class_id',
                    'class',
                    'attended_lectures'
                ]
            ]);
    }

    public function test_create_student(): void
    {
        $class = SchoolClass::factory()->create();
        $studentData = [
            'name' => 'Тест Студент',
            'email' => 'test@example.com',
            'class_id' => $class->id
        ];

        $response = $this->postJson('/api/students', $studentData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('students', [
            'name' => 'Тест Студент',
            'email' => 'test@example.com',
            'class_id' => $class->id
        ]);
    }

    public function test_update_student(): void
    {
        $student = Student::factory()->create();
        $newClass = SchoolClass::factory()->create();
        
        $updateData = [
            'name' => 'Обновленное Имя',
            'class_id' => $newClass->id
        ];

        $response = $this->putJson("/api/students/{$student->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Обновленное Имя',
            'class_id' => $newClass->id
        ]);
    }

    public function test_delete_student(): void
    {
        $student = Student::factory()->create();

        $response = $this->deleteJson("/api/students/{$student->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);

        $this->assertDatabaseMissing('students', [
            'id' => $student->id
        ]);
    }

    public function test_get_all_classes(): void
    {
        SchoolClass::factory()->count(3)->create();

        $response = $this->getJson('/api/classes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'students'
                    ]
                ]
            ]);
    }

    public function test_get_specific_class(): void
    {
        $class = SchoolClass::factory()->create();

        $response = $this->getJson("/api/classes/{$class->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'students'
                ]
            ]);
    }

    public function test_get_class_curriculum(): void
    {
        $class = SchoolClass::factory()->create();
        $lectures = Lecture::factory()->count(3)->create();
        
        $curriculumData = [];
        foreach ($lectures as $index => $lecture) {
            $curriculumData[$lecture->id] = ['order' => $index + 1];
        }
        $class->lectures()->attach($curriculumData);

        $response = $this->getJson("/api/classes/{$class->id}/curriculum");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'lectures' => [
                        '*' => [
                            'id',
                            'topic',
                            'description',
                            'pivot' => [
                                'order'
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_create_class(): void
    {
        $classData = [
            'name' => 'Тест Класс'
        ];

        $response = $this->postJson('/api/classes', $classData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('classes', [
            'name' => 'Тест Класс'
        ]);
    }

    public function test_update_class(): void
    {
        $class = SchoolClass::factory()->create();
        
        $updateData = [
            'name' => 'Обновленное Название'
        ];

        $response = $this->putJson("/api/classes/{$class->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('classes', [
            'id' => $class->id,
            'name' => 'Обновленное Название'
        ]);
    }

    public function test_update_curriculum(): void
    {
        $class = SchoolClass::factory()->create();
        $lectures = Lecture::factory()->count(3)->create();
        
        $curriculumData = [
            'lectures' => [
                ['lecture_id' => $lectures[0]->id, 'order' => 1],
                ['lecture_id' => $lectures[1]->id, 'order' => 2],
                ['lecture_id' => $lectures[2]->id, 'order' => 3]
            ]
        ];

        $response = $this->putJson("/api/classes/{$class->id}/curriculum", $curriculumData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);

        $this->assertEquals(3, $class->fresh()->lectures()->count());
    }

    public function test_delete_class(): void
    {
        $class = SchoolClass::factory()->create();
        $student = Student::factory()->create(['class_id' => $class->id]);

        $response = $this->deleteJson("/api/classes/{$class->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);

        $this->assertDatabaseMissing('classes', [
            'id' => $class->id
        ]);

        // Проверяем, что студент откреплен от класса, но не удален
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'class_id' => null
        ]);
    }

    public function test_validation_errors(): void
    {
        $response = $this->postJson('/api/students', [
            'name' => '',
            'email' => 'invalid-email'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    public function test_not_found_errors(): void
    {
        $response = $this->getJson('/api/students/999');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }
}

