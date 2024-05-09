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

      public function game()
    {
        return $this->belongsTo(Game::class);
    }

 /*public function teamOne()
    {
        return $this->belongsTo(Team::class, 'team_one_id');
    }

    // Define the relationship with the team for team two
    public function teamTwo()
    {
        return $this->belongsTo(Team::class, 'team_two_id');
    }

    // Define the relationship with the winning team
    public function winningTeam()
    {
        return $this->belongsTo(Team::class, 'winning_team_id');
    }

    // Define the relationship with the first goal team
    public function firstGoalTeam()
    {
        return $this->belongsTo(Team::class, 'first_goal_team_id');
    }
*/

}
