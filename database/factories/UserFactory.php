<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'last_name' => fake()->lastName(),
            'document' => fake()->numberBetween(1000000000, 1999999999),
            'country' => fake()->country(),
            'address' => fake()->streetAddress(),
            'phone_number' => fake()->numberBetween(3000000000, 3999999999),
            'category_id' => fake()->numberBetween(1, 3)
        ];
    }
}
