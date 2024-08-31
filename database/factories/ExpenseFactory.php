<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'user_id' => fake()->randomElement(User::pluck('id')),
            'category' => fake()->word(),
            'amount' => fake()->randomFloat(2, 1, 1000),
            'date' => fake()->date(),
            'description' => fake()->optional()->sentence(),
            // 'risk_level' => fake()->randomElement(['low', 'medium', 'high']), // مستوى المخاطر
        ];
    }
}
