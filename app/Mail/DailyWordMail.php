<?php

namespace App\Mail;

use App\Models\DailyWord;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyWordMail extends Mailable
{
    use Queueable, SerializesModels;

    public DailyWord $dailyWord;
    public User $user;

    public function __construct(DailyWord $dailyWord, User $user)
    {
        $this->dailyWord = $dailyWord;
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📖 Word of the Day - ' . $this->dailyWord->word_en,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily-word',
        );
    }
}