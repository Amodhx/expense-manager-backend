<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'cost' => $this->faker->randomFloat(2, 2, 300),
            'description' => $this->faker->sentence(3),
            'expense_type' => $this->faker->randomElement(['travel', 'food', 'other']),
        ];
    }
}
