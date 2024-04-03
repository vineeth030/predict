<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Team extends Model
{
    use HasFactory;

    public $table = "teams";
    protected $primaryKey = 'id';
    protected $fillable = [
        'points', 'games_played', 'wins', 'draws', 'losses','flag'
        // Add other match properties as needed
    ];
}
