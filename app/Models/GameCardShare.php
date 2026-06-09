<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameCardShare extends Model
{
    use HasFactory;

    public $table = 'game_card_share';

    public $timestamps = false;

    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'card_id',
        'quantity',
        'shared_at',
    ];

    protected $casts = [
        'sender_user_id' => 'integer',
        'receiver_user_id' => 'integer',
        'card_id' => 'integer',
        'quantity' => 'integer',
        'shared_at' => 'datetime',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(GameCard::class, 'card_id');
    }
}
