<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'session_id',
        'feedback_text',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    const UPDATED_AT = null;
    
    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relationship with UserAssessmentSession
    public function session()
    {
        return $this->belongsTo(UserAssessmentSession::class, 'session_id');
    }
}