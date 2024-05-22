<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';
    public $table = "games";
  
      protected $fillable = [
          'team_one_id', 'team_two_id', 'kick_off_time', 'winning_team_id', 'team_one_goals', 'team_two_goals','first_goal_team_id','game_type','match_status','stadium_name'
          // Add other match properties as needed
      ];

      public function predictions()
      {
          return $this->hasMany(Prediction::class);
      }

      public function teamOne()
      {
          return $this->belongsTo(Team::class, 'team_one_id');
      }
  
      public function teamTwo()
      {
          return $this->belongsTo(Team::class, 'team_two_id');
      }
      public function winningTeam()
      {
          return $this->belongsTo(Team::class, 'winning_team_id');
      }
      public function firstGoalTeam()
      {
          return $this->belongsTo(Team::class, 'first_goal_team_id');
      }

}
