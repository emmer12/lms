<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $table = 'quizs';
    protected $guarded = [];

    public function log()
    {
        return  $this->hasMany(QuizLog::class, 'quiz_id');
    }
}
