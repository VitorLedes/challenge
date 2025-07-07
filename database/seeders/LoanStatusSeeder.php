<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('loan_statuses')->insert([
            ['name' => 'Pendente'],
            ['name' => 'Atrasado'],
            ['name' => 'Devolvido'],
        ]);
    }
}
