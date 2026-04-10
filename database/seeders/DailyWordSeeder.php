<?php

namespace Database\Seeders;

use App\Models\DailyWord;
use Illuminate\Database\Seeder;

class DailyWordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            [
                'word_en' => 'Awesome',
                'word_ar' => 'رائع',
                'definition_en' => 'Extremely impressive or daunting; inspiring awe.',
                'definition_ar' => 'مثير للإعجاب بشكل كبير؛ ملهم للرهبة.',
                'example_en' => 'The view from the mountain is awesome!',
                'example_ar' => 'المنظر من الجبل رائع!',
                'scheduled_for' => now()->format('Y-m-d'),
            ],
            [
                'word_en' => 'Challenge',
                'word_ar' => 'تحدي',
                'definition_en' => 'A task or situation that tests someones abilities.',
                'definition_ar' => 'مهمة أو موقف يختبر قدرات شخص ما.',
                'example_en' => 'Learning a new language is a great challenge.',
                'example_ar' => 'تعلم لغة جديدة هو تحدٍ رائع.',
                'scheduled_for' => now()->addDay()->format('Y-m-d'),
            ],
        ];

        foreach ($words as $word) {
            DailyWord::create($word);
        }
    }
}