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
          'user_id', 'game_id', 'team_one_goals', 'team_two_goals', 'winning_team_id','first_goal_team_id','final_team_one_id','final_team_two_id'
        
      ];

      public function game()
    {
        return $this->belongsTo(Game::class);
    }

      public function finalTeamOne()
      {
          return $this->belongsTo(Team::class, 'final_team_one_id');
      }
  
      public function finalTeamTwo()
      {
          return $this->belongsTo(Team::class, 'final_team_two_id');
      }


}
