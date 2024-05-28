<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailExtension extends Model
{
    use HasFactory;

    public $table = "email_extensions";

    protected $fillable = [
      'domain', 'company_group_id',
    ];
  
}
