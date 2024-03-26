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
          'team_one_id', 'team_two_id', 'kick_off_time', 'winning_team_id', 'team_one_goals', 'team_two_goals','first_goal_team_id'
          // Add other match properties as needed
      ];

      public function predictions()
      {
          return $this->hasMany(Prediction::class);
      }

}
