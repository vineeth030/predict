<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    
    public $table = "versions";

    protected $fillable = [
      'code', 'name', 'is_mandatory','is_quarter_started'
    ];
  
      // Example relationships: a user points entry belongs to a user and a match
}
