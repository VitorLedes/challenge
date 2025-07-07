<?php

namespace Database\Factories;

use App\BookStatusEnum;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'author' => substr($this->faker->name(), 0, 15),
            'genre_id' => random_int(1, 11),
            'created_at' => now(),
            'status_id' => BookStatusEnum::AVAILABLE,
        ];
    }
}
