<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';
    public $table = "predictions";
  
      protected $fillable = [
          'user_id', 'game_id', 'team_one_goals', 'team_two_goals', 'winning_team_id','first_goal_team_id'
        
      ];
}
