<?php

namespace Database\Seeders;

use App\BookStatusEnum;
use App\LoanStatusEnum;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory()->count(50)->create();
    }
}
