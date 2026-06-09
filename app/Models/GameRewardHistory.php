<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameRewardHistory extends Model
{
    use HasFactory;

    public $table = 'game_reward_history';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'card_id',
        'quantity',
        'reward_source',
        'rewarded_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'card_id' => 'integer',
        'quantity' => 'integer',
        'rewarded_at' => 'datetime',
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
