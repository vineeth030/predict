<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameDailyClaim extends Model
{
    use HasFactory;

    public $table = 'game_daily_claim';

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'claim_date',
        'card_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'claim_date' => 'date',
        'card_id' => 'integer',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(GameCard::class, 'card_id');
    }
}
