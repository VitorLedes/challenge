<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->insert([
            ['name' => 'Ficção',],
            ['name' => 'Não ficção',],
            ['name' => 'Ficção científica',],
            ['name' => 'Fantasia',],
            ['name' => 'Romance',],
            ['name' => 'Mistério',],
            ['name' => 'Suspense',],
            ['name' => 'Biografia',],
            ['name' => 'História',],
            ['name' => 'Infantil',],
            ['name' => 'Terror',],
        ]);
    }
}
