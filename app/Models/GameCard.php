<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameCard extends Model
{
    use HasFactory;

    public $table = 'game_card';

    public const UPDATED_AT = null;

    protected $fillable = [
        'country_id',
        'card_code',
        'card_name',
        'player_name',
        'card_type',
        'card_order',
        'star_value',
        'is_active',
    ];

    protected $casts = [
        'country_id' => 'integer',
        'card_order' => 'integer',
        'star_value' => 'integer',
        'is_active' => 'boolean',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'country_id');
    }
}
