<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'question_id',
        'option_text',
        'score',
    ];
    
    public $timestamps = false;
    
    // Relationship with Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    // Relationship with UserAnswers
    public function answers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}