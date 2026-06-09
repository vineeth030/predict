<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameRedeemHistory extends Model
{
    use HasFactory;

    public $table = 'game_redeem_history';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'stars_used',
        'card_id',
        'redeemed_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'stars_used' => 'integer',
        'card_id' => 'integer',
        'redeemed_at' => 'datetime',
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
