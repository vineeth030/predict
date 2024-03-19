<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $table = "teams";
    protected $primaryKey = 'id';
    protected $fillable = [
        'points', 'games_played', 'wins', 'draws', 'losses'
        // Add other match properties as needed
    ];
}
