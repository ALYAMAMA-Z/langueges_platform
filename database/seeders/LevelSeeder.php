<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    
    public function run(): void
    {
           $levels = [
            ['name_en' => 'Beginner A1', 'name_ar' => 'مبتدئ A1', 'order' => 1],
            ['name_en' => 'Elementary A2', 'name_ar' => 'ابتدائي A2', 'order' => 2],
            ['name_en' => 'Intermediate B1', 'name_ar' => 'متوسط B1', 'order' => 3],
            ['name_en' => 'Upper Intermediate B2', 'name_ar' => 'فوق متوسط B2', 'order' => 4],
            ['name_en' => 'Advanced C1', 'name_ar' => 'متقدم C1', 'order' => 5],
        ];

        DB::table('levels')->insert($levels);
    }
}
