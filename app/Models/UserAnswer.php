<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'session_id',
        'question_id',
        'option_id',
    ];
    
    public $timestamps = false;
    
    // Relationship with UserAssessmentSession
    public function session()
    {
        return $this->belongsTo(UserAssessmentSession::class, 'session_id');
    }
    
    // Relationship with Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    // Relationship with Option
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}