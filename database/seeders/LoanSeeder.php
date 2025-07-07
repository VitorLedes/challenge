<?php

namespace Database\Seeders;

use App\BookStatusEnum;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booksToLoan = Book::inRandomOrder()->take(20)->get();

        foreach ($booksToLoan as $book) {
            Loan::factory()->create([
                'book_id' => $book->id,
            ]);

            $book->update(['status_id' => BookStatusEnum::BORROWED]);
        }

    }
}
