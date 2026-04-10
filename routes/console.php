<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('daily-words:send', function () {
    dispatch(new \App\Jobs\SendDailyWordsJob());
    $this->info('Daily words job dispatched successfully!');
})->describe('Send daily word to all users');


Schedule::command('daily-words:send')->dailyAt('08:00');