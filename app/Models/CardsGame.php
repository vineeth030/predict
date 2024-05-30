<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardsGame extends Model
{
    use HasFactory;

    public $table = "cards_game";

    protected $fillable = [
      'user_id','questions_asked','cards_opened','last_attended','is_question_opened'
    ];
  
}
