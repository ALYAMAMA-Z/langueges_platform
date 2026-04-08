<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // مستوى A1 (مبتدئ) - أسئلة سهلة
            [
                'level_id' => 1,
                'question_text_en' => 'What is the correct greeting in English?',
                'question_text_ar' => 'ما هي التحية الصحيحة في الإنجليزية؟',
                'option_a_en' => 'Hello',
                'option_a_ar' => 'هلو',
                'option_b_en' => 'Goodbye',
                'option_b_ar' => 'وداعاً',
                'option_c_en' => 'Thank you',
                'option_c_ar' => 'شكراً',
                'correct_option' => 'a',
            ],
            [
                'level_id' => 1,
                'question_text_en' => 'How do you say "كتاب" in English?',
                'question_text_ar' => 'كيف تقول "كتاب" في الإنجليزية؟',
                'option_a_en' => 'Pen',
                'option_a_ar' => 'قلم',
                'option_b_en' => 'Book',
                'option_b_ar' => 'كتاب',
                'option_c_en' => 'Table',
                'option_c_ar' => 'طاولة',
                'correct_option' => 'b',
            ],
            [
                'level_id' => 1,
                'question_text_en' => 'What is the color of the sky?',
                'question_text_ar' => 'ما هو لون السماء؟',
                'option_a_en' => 'Red',
                'option_a_ar' => 'أحمر',
                'option_b_en' => 'Green',
                'option_b_ar' => 'أخضر',
                'option_c_en' => 'Blue',
                'option_c_ar' => 'أزرق',
                'correct_option' => 'c',
            ],
            
            // مستوى A2 (ابتدائي)
            [
                'level_id' => 2,
                'question_text_en' => 'Which sentence is correct?',
                'question_text_ar' => 'أي جملة صحيحة؟',
                'option_a_en' => 'She go to school',
                'option_a_ar' => 'هي تذهب إلى المدرسة',
                'option_b_en' => 'She goes to school',
                'option_b_ar' => 'هي تذهب إلى المدرسة',
                'option_c_en' => 'She going to school',
                'option_c_ar' => 'هي ذاهبة إلى المدرسة',
                'correct_option' => 'b',
            ],
            [
                'level_id' => 2,
                'question_text_en' => 'What is the past tense of "eat"?',
                'question_text_ar' => 'ما هو الماضي من "يأكل"؟',
                'option_a_en' => 'Eated',
                'option_a_ar' => 'إيتد',
                'option_b_en' => 'Ate',
                'option_b_ar' => 'آيت',
                'option_c_en' => 'Eating',
                'option_c_ar' => 'إيتينغ',
                'correct_option' => 'b',
            ],
            
            // مستوى B1 (متوسط)
            [
                'level_id' => 3,
                'question_text_en' => 'Choose the correct sentence:',
                'question_text_ar' => 'اختر الجملة الصحيحة:',
                'option_a_en' => 'If I will see him, I will tell him',
                'option_a_ar' => 'إذا سأراه، سأخبره',
                'option_b_en' => 'If I see him, I will tell him',
                'option_b_ar' => 'إذا رأيته، سأخبره',
                'option_c_en' => 'If I saw him, I will tell him',
                'option_c_ar' => 'إذا رأيته، سأخبره',
                'correct_option' => 'b',
            ],
            [
                'level_id' => 3,
                'question_text_en' => 'What does "frustrated" mean?',
                'question_text_ar' => 'ماذا تعني كلمة "محبط"؟',
                'option_a_en' => 'Happy',
                'option_a_ar' => 'سعيد',
                'option_b_en' => 'Angry',
                'option_b_ar' => 'غاضب',
                'option_c_en' => 'Disappointed',
                'option_c_ar' => 'خائب الأمل',
                'correct_option' => 'c',
            ],
            
            // مستوى B2 (فوق متوسط)
            [
                'level_id' => 4,
                'question_text_en' => 'Which word is a synonym for "difficult"?',
                'question_text_ar' => 'أي كلمة مرادفة لـ "صعب"؟',
                'option_a_en' => 'Easy',
                'option_a_ar' => 'سهل',
                'option_b_en' => 'Hard',
                'option_b_ar' => 'صعب',
                'option_c_en' => 'Simple',
                'option_c_ar' => 'بسيط',
                'correct_option' => 'b',
            ],
            [
                'level_id' => 4,
                'question_text_en' => 'Choose the correct passive form: "They build houses"',
                'question_text_ar' => 'اختر صيغة المبني للمجهول الصحيحة: "هم يبنون المنازل"',
                'option_a_en' => 'Houses are built by them',
                'option_a_ar' => 'المنازل تُبنى بواسطتهم',
                'option_b_en' => 'Houses is built by them',
                'option_b_ar' => 'المنازل تُبنى بواسطتهم',
                'option_c_en' => 'Houses were built by them',
                'option_c_ar' => 'المنازل بُنيت بواسطتهم',
                'correct_option' => 'a',
            ],
            
            // مستوى C1 (متقدم)
            [
                'level_id' => 5,
                'question_text_en' => 'What does "ubiquitous" mean?',
                'question_text_ar' => 'ماذا تعني كلمة "موجود في كل مكان"؟',
                'option_a_en' => 'Rare',
                'option_a_ar' => 'نادر',
                'option_b_en' => 'Everywhere',
                'option_b_ar' => 'في كل مكان',
                'option_c_en' => 'Nowhere',
                'option_c_ar' => 'لا مكان',
                'correct_option' => 'b',
            ],
            [
                'level_id' => 5,
                'question_text_en' => 'Choose the correct idiom: "To cry over spilled milk" means...',
                'question_text_ar' => 'ماذا يعني المثل "البكاء على الحليب المسكوب"؟',
                'option_a_en' => 'To be very happy',
                'option_a_ar' => 'أن تكون سعيداً جداً',
                'option_b_en' => 'To complain about something that cannot be changed',
                'option_b_ar' => 'التذمر من شيء لا يمكن تغييره',
                'option_c_en' => 'To celebrate success',
                'option_c_ar' => 'الاحتفال بالنجاح',
                'correct_option' => 'b',
            ],
        ];

        DB::table('questions')->insert($questions);
    }
}