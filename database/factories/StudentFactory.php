<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'class_id' => SchoolClass::factory(),
        ];
    }

    /**
     * Indicate that the student is not assigned to any class.
     */
    public function withoutClass(): static
    {
        return $this->state(fn (array $attributes) => [
            'class_id' => null,
        ]);
    }
}

