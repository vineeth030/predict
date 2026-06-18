<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
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

    public static function cardsCollectedByCountryQuery(array $userIds): QueryBuilder
    {
        return DB::table('game_user_card')
            ->join('game_card', 'game_user_card.card_id', '=', 'game_card.id')
            ->whereIn('game_user_card.user_id', $userIds)
            ->where('game_user_card.quantity', '>', 0)
            ->where('game_card.is_active', true)
            ->select(
                'game_user_card.user_id',
                'game_card.country_id',
                DB::raw('COUNT(DISTINCT game_user_card.card_id) as cards_collected')
            )
            ->groupBy('game_user_card.user_id', 'game_card.country_id');
    }

    public static function starsCollectedForUsers(array $userIds): Collection
    {
        $userIds = collect($userIds)
            ->map(fn ($userId) => (int) $userId)
            ->filter(fn ($userId) => $userId > 0)
            ->unique()
            ->values();

        if ($userIds->isEmpty()) {
            return collect();
        }

        $countryCardCounts = DB::table('game_card')
            ->where('is_active', true)
            ->select('country_id', DB::raw('COUNT(*) as total_cards'))
            ->groupBy('country_id')
            ->orderBy('country_id')
            ->get();

        $cardsCollected = static::cardsCollectedByCountryQuery($userIds->all())
            ->get()
            ->groupBy('user_id')
            ->map(fn ($userCards) => $userCards->keyBy('country_id'));

        return $userIds->mapWithKeys(function ($userId) use ($countryCardCounts, $cardsCollected) {
            $userCardsCollected = $cardsCollected->get($userId, collect());

            $starsCollected = $countryCardCounts->map(function ($country) use ($userCardsCollected) {
                $cardsCollected = (int) ($userCardsCollected->get($country->country_id)?->cards_collected ?? 0);

                return [
                    'country_id' => (int) $country->country_id,
                    'cards_collected' => min($cardsCollected, (int) $country->total_cards),
                ];
            })->values()->all();

            return [$userId => $starsCollected];
        });
    }

    public static function starsCollectedForUser(int $userId): array
    {
        return static::starsCollectedForUsers([$userId])->get($userId, []);
    }
}
