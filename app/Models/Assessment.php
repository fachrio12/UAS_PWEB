<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'date_created', 
    ];

    public const NAMES = [
        'Minat Bakat',
        'Motivasi Belajar',
        'Gaya Belajar',
        'Kecenderungan Otak (Kanan/Kiri)',
    ];

    public static function getNameOptions()
    {
        return self::NAMES;
    }

    protected $casts = [
        'is_active' => 'boolean',
        'date_created' => 'datetime', 
    ];

    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function sessions()
    {
        return $this->hasMany(UserAssessmentSession::class);
    }
}
