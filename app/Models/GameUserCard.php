<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

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

    public static function completedCountrySetsQuery(): QueryBuilder
    {
        return DB::table('game_user_card')
            ->join('game_card', 'game_user_card.card_id', '=', 'game_card.id')
            ->where('game_user_card.quantity', '>', 0)
            ->where('game_card.is_active', true)
            ->select('game_user_card.user_id', 'game_card.country_id')
            ->groupBy('game_user_card.user_id', 'game_card.country_id')
            ->havingRaw('COUNT(DISTINCT game_user_card.card_id) = (
                SELECT COUNT(*)
                FROM game_card AS country_cards
                WHERE country_cards.country_id = game_card.country_id
                    AND country_cards.is_active = 1
            )');
    }

    public static function starsCollectedQuery(): QueryBuilder
    {
        return DB::query()
            ->fromSub(static::completedCountrySetsQuery(), 'completed_country_sets')
            ->select('user_id', DB::raw('COUNT(*) as stars_collected'))
            ->groupBy('user_id');
    }

    public static function starsCollectedForUser(int $userId): int
    {
        return (int) DB::query()
            ->fromSub(static::completedCountrySetsQuery(), 'completed_country_sets')
            ->where('user_id', $userId)
            ->count();
    }
}
