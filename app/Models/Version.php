<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    
    public $table = "versions";
    protected $primaryKey = 'platform';

    protected $fillable = [
    'platform',  'code', 'name', 'is_mandatory','is_quarter_started','countdown_timer','is_round16_completed','wc_end_date','winner'
    ];
  
      // Example relationships: a user points entry belongs to a user and a match
}
