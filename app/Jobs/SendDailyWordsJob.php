<?php

namespace App\Jobs;

use App\Models\DailyWord;
use App\Models\User;
use App\Mail\DailyWordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDailyWordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public function handle(): void
    {
        $dailyWord = DailyWord::where('is_sent', false)
            ->whereDate('scheduled_for', '<=', now())
            ->orderBy('scheduled_for')
            ->first();

        if (!$dailyWord) {
            Log::info('No new word to send today');
            return;
        }

        $users = User::all();

        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new DailyWordMail($dailyWord, $user));
                $dailyWord->users()->attach($user->id, ['sent_at' => now()]);
                
                Log::info('Daily word sent to user', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'word' => $dailyWord->word_en,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send daily word', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $dailyWord->update(['is_sent' => true]);
        
        Log::info('Daily word sent to all users', [
            'word' => $dailyWord->word_en,
            'users_count' => $users->count(),
        ]);
    }
}