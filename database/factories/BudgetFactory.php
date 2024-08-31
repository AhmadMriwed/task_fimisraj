<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition()
    {
        return [
            'user_id' => fake()->randomElement(User::pluck('id')),
            'category' => fake()->word(),
            'amount' => fake()->randomFloat(2, 1, 5000), 
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }
}
