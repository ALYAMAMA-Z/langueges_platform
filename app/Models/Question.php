<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'level_id', 'question_text_en', 'question_text_ar',
        'option_a_en', 'option_a_ar', 'option_b_en', 'option_b_ar',
        'option_c_en', 'option_c_ar', 'correct_option'
    ];
    
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    
    public function getOptionsArray(string $lang = 'en'): array
    {
        return [
            'a' => $this->{"option_a_{$lang}"},
            'b' => $this->{"option_b_{$lang}"},
            'c' => $this->{"option_c_{$lang}"},
        ];
    }
    
    public function getQuestionText(string $lang = 'en'): string
    {
        return $this->{"question_text_{$lang}"};
    }
}