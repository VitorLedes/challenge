<?php

namespace Database\Factories;

use App\LoanStatusEnum;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'loan_date' => now(),
            'return_date' => random_int(1, 3) == 1 ? now()->subDays(fake()->numberBetween(4, 10)) : now()->addDays(fake()->numberBetween(1, 30)),
            'status_id' => LoanStatusEnum::PENDING,
        ];
    }
}
