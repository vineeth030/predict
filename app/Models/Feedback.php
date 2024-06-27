<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    public $table = "feedback";

    protected $fillable = [
      'question_id','user_id','answer','user_name'
    ];
  
    public function feedbacks()
    {
      return $this->hasMany(Feedback::class, 'question_id');
    }
}
