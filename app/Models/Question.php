<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $table = "questions";

    protected $fillable = [
      'question','type','options'
    ];

    public function question()
    {
      return $this->hasMany(Feedback::class, 'question_id');
  
}
}