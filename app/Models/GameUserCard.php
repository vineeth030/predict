<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameUserCard extends Model
{
    use HasFactory;

    public $table = 'game_user_card';

    public const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'card_id',
        'quantity',
        'first_obtained_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'card_id' => 'integer',
        'quantity' => 'integer',
        'first_obtained_at' => 'datetime',
        'updated_at' => 'datetime',
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
