<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'assessment_id',
        'question_text',
        'question_type',
    ];
    
    public $timestamps = false;
    
    // Relationship with Assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
    
    // Relationship with Options
    public function options()
    {
        return $this->hasMany(Option::class);
    }
    
    // Relationship with UserAnswers
    public function answers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}