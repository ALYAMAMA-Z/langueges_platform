<?php

namespace App\Console\Commands;

use App\Jobs\SendDailyWordsJob;
use Illuminate\Console\Command;

class SendDailyWords extends Command
{
    protected $signature = 'daily-words:send';
    protected $description = 'Send daily word to all users';

    public function handle(): void
    {
        $this->info('Starting to send daily words...');
        SendDailyWordsJob::dispatch();
        $this->info('Daily words job dispatched successfully!');
    }
}