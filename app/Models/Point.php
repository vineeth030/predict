<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $primaryKey = 'id';
    public $table = "points";
  
      protected $fillable = [
          'user_id', 'game_id', 'points','win_prediction','goal_prediction','first_goal_prediction'
         
      ];
}
