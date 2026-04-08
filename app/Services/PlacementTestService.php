<?php

namespace App\Services;

use App\Models\Question;
use App\Models\UserLevelTest;
use App\Models\Level;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlacementTestService
{
    /**
     * جلب جميع الأسئلة
     */
    public function getAllQuestions()
    {
        return Question::with('level')->get();
    }

    /**
     * جلب عدد الأسئلة
     */
    public function getQuestionsCount(): int
    {
        return Question::count();
    }

    /**
     * حساب نتيجة الاختبار وتحديد المستوى
     */
    public function calculateResult(array $answers, int $userId): array
    {
        $totalQuestions = $this->getQuestionsCount();
        $correctCount = 0;

        // حساب الإجابات الصحيحة
        foreach ($answers as $questionId => $userAnswer) {
            $question = Question::find($questionId);
            if ($question && $question->correct_option === $userAnswer) {
                $correctCount++;
            }
        }

        // حساب النسبة المئوية
        $percentage = ($correctCount / $totalQuestions) * 100;

        // تحديد المستوى بناءً على النسبة
        $level = $this->determineLevel($percentage);

        // حفظ النتيجة
        $this->saveResult($userId, $correctCount, $level->id);

        Log::info('تم إكمال اختبار تحديد المستوى', [
            'user_id' => $userId,
            'score' => $correctCount,
            'total' => $totalQuestions,
            'level_id' => $level->id,
            'level_name' => $level->name_ar
        ]);

        return [
            'correct_count' => $correctCount,
            'total_count' => $totalQuestions,
            'percentage' => $percentage,
            'level' => $level
        ];
    }

    /**
     * تحديد المستوى حسب النسبة المئوية
     */
    private function determineLevel(float $percentage): Level
    {
        if ($percentage >= 80) {
            return Level::where('order', 5)->first(); // C1
        } elseif ($percentage >= 60) {
            return Level::where('order', 4)->first(); // B2
        } elseif ($percentage >= 40) {
            return Level::where('order', 3)->first(); // B1
        } elseif ($percentage >= 20) {
            return Level::where('order', 2)->first(); // A2
        } else {
            return Level::where('order', 1)->first(); // A1
        }
    }

    /**
     * حفظ نتيجة الاختبار
     */
    private function saveResult(int $userId, int $score, int $levelId): void
    {
        DB::transaction(function () use ($userId, $score, $levelId) {
            UserLevelTest::updateOrCreate(
                ['user_id' => $userId],
                [
                    'score' => $score,
                    'level_id' => $levelId,
                    'completed_at' => now(),
                ]
            );

            // تحديث مستوى المستخدم
            $user = \App\Models\User::find($userId);
            $user->level_id = $levelId;
            $user->save();
        });
    }

    /**
     * التحقق مما إذا كان المستخدم قد أجرى الاختبار بالفعل
     */
    public function hasTakenTest(int $userId): bool
    {
        return UserLevelTest::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->exists();
    }

    /**
     * جلب نتيجة الاختبار للمستخدم
     */
    public function getUserTestResult(int $userId): ?UserLevelTest
    {
        return UserLevelTest::with('level')
            ->where('user_id', $userId)
            ->first();
    }
}