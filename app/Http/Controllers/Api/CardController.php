<?php

namespace App\Http\Controllers\Api;

use App\Models\GameCard;
use App\Models\GameDailyClaim;
use App\Models\GameNotification;
use App\Models\GameRewardHistory;
use App\Models\GameStar;
use App\Models\GameUserCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    public function gameCards(Request $request)
    {
        try {
            $cards = GameCard::with('country:id,name,short_name,flag')
                ->when($request->filled('country_id'), function ($query) use ($request) {
                    $query->where('country_id', $request->input('country_id'));
                })
                ->where('is_active', true)
                ->orderBy('country_id')
                ->orderBy('card_order')
                ->get()
                ->map(function ($card) {
                    return [
                        'id' => $card->id,
                        'country_id' => $card->country_id,
                        'country_name' => $card->country?->name,
                        'country_short_name' => $card->country?->short_name,
                        'country_flag' => $card->country?->flag,
                        'card_code' => $card->card_code,
                        'card_name' => $card->card_name,
                        'player_name' => $card->player_name,
                        'card_type' => $card->card_type,
                        'card_order' => $card->card_order,
                        'star_value' => $card->star_value,
                        'is_active' => $card->is_active,
                    ];
                });

            if ($request->boolean('group_by_country')) {
                $cards = $cards->groupBy('country_id')->values()->map(function ($countryCards) {
                    $firstCard = $countryCards->first();

                    return [
                        'country_id' => $firstCard['country_id'],
                        'country_name' => $firstCard['country_name'],
                        'country_short_name' => $firstCard['country_short_name'],
                        'country_flag' => $firstCard['country_flag'],
                        'cards' => $countryCards->values(),
                    ];
                });
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $cards,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function dailyClaim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $userId = $request->input('user_id');
            $today = now()->toDateString();

            $alreadyClaimed = GameRewardHistory::where('user_id', $userId)
                ->where('reward_source', 'DAILY')
                ->whereDate('rewarded_at', $today)
                ->exists();

            $alreadyClaimed = $alreadyClaimed || GameDailyClaim::where('user_id', $userId)
                ->where('claim_date', $today)
                ->exists();

            if ($alreadyClaimed) {
                return response()->json([
                    'status' => 400,
                    'message' => 'User already entered today.',
                ]);
            }

            $result = DB::transaction(function () use ($userId, $today) {
                $card = GameCard::whereIn('card_type', ['BRONZE', 'SILVER'])
                    ->where('is_active', true)
                    ->inRandomOrder()
                    ->first();

                if (!$card) {
                    return null;
                }

                $reward = GameRewardHistory::create([
                    'user_id' => $userId,
                    'card_id' => $card->id,
                    'quantity' => 1,
                    'reward_source' => 'DAILY',
                    'rewarded_at' => now(),
                ]);

                $userCard = GameUserCard::where('user_id', $userId)
                    ->where('card_id', $card->id)
                    ->first();

                if ($userCard) {
                    $userCard->increment('quantity');
                    $userCard->refresh();
                } else {
                    $userCard = GameUserCard::create([
                        'user_id' => $userId,
                        'card_id' => $card->id,
                        'quantity' => 1,
                        'first_obtained_at' => now(),
                    ]);
                }

                $starsEarned = $this->starsForCardType($card->card_type);
                $gameStars = GameStar::firstOrCreate(
                    ['user_id' => $userId],
                    ['stars_balance' => 0]
                );
                $gameStars->increment('stars_balance', $starsEarned);
                $gameStars->refresh();

                GameDailyClaim::create([
                    'user_id' => $userId,
                    'claim_date' => $today,
                    'card_id' => $card->id,
                ]);

                $notification = GameNotification::create([
                    'user_id' => $userId,
                    'notification_type' => GameNotification::TYPE_DAILY_REWARD,
                    'reference_id' => $card->id,
                    'title' => 'Daily Reward',
                    'message' => 'Daily Reward',
                    'is_read' => false,
                ]);

                return [
                    'reward' => $reward,
                    'card' => $card,
                    'user_card' => $userCard,
                    'stars_earned' => $starsEarned,
                    'stars_balance' => $gameStars->stars_balance,
                    'notification' => $notification,
                ];
            });

            if (!$result) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No bronze or silver cards available.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Daily claim completed successfully.',
                'data' => [
                    'reward_id' => $result['reward']->id,
                    'user_id' => $userId,
                    'card_id' => $result['card']->id,
                    'card_name' => $result['card']->card_name,
                    'player_name' => $result['card']->player_name,
                    'card_type' => $result['card']->card_type,
                    'quantity' => 1,
                    'user_card_quantity' => $result['user_card']->quantity,
                    'stars_earned' => $result['stars_earned'],
                    'stars_balance' => $result['stars_balance'],
                    'reward_source' => 'DAILY',
                    'claim_date' => $today,
                    'notification_id' => $result['notification']->id,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function userCards(Request $request)
    {
        $userId = $request->input('user_id', $request->user()?->id);

        $validator = Validator::make(['user_id' => $userId], [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $userCards = GameUserCard::with('card.country:id,name,short_name,flag')
                ->where('user_id', $userId)
                ->join('game_card', 'game_user_card.card_id', '=', 'game_card.id')
                ->orderBy('game_card.country_id')
                ->orderBy('game_card.card_order')
                ->select('game_user_card.*')
                ->get()
                ->map(function ($userCard) {
                    $card = $userCard->card;

                    return [
                        'id' => $userCard->id,
                        'user_id' => $userCard->user_id,
                        'card_id' => $userCard->card_id,
                        'quantity' => $userCard->quantity,
                        'first_obtained_at' => $userCard->first_obtained_at,
                        'updated_at' => $userCard->updated_at,
                        // 'country_id' => $card?->country_id,
                        // 'country_name' => $card?->country?->name,
                        // 'country_short_name' => $card?->country?->short_name,
                        // 'country_flag' => $card?->country?->flag,
                        // 'card_code' => $card?->card_code,
                        // 'card_name' => $card?->card_name,
                        // 'player_name' => $card?->player_name,
                        // 'card_type' => $card?->card_type,
                        // 'card_order' => $card?->card_order,
                        // 'star_value' => $card?->star_value,
                        // 'is_active' => $card?->is_active,
                    ];
                });

            if ($request->boolean('group_by_country')) {
                $userCards = $userCards->groupBy('country_id')->values()->map(function ($countryCards) {
                    $firstCard = $countryCards->first();

                    return [
                        'country_id' => $firstCard['country_id'],
                        'country_name' => $firstCard['country_name'],
                        'country_short_name' => $firstCard['country_short_name'],
                        'country_flag' => $firstCard['country_flag'],
                        'cards' => $countryCards->values(),
                    ];
                });
            }

            $starsBalance = GameStar::where('user_id', $userId)->value('stars_balance') ?? 0;
            $rewardHistory = GameRewardHistory::with('card.country:id,name,short_name,flag')
                ->where('user_id', $userId)
                ->orderByDesc('rewarded_at')
                ->orderByDesc('id')
                ->get()
                ->map(function ($reward) {
                    $card = $reward->card;

                    return [
                        'id' => $reward->id,
                        'user_id' => $reward->user_id,
                        'card_id' => $reward->card_id,
                        'quantity' => $reward->quantity,
                        'reward_source' => $reward->reward_source,
                        'is_opened' => $reward->is_opened,
                        'rewarded_at' => $reward->rewarded_at,
                        // 'country_id' => $card?->country_id,
                        // 'country_name' => $card?->country?->name,
                        // 'country_short_name' => $card?->country?->short_name,
                        // 'country_flag' => $card?->country?->flag,
                        // 'card_code' => $card?->card_code,
                        // 'card_name' => $card?->card_name,
                        // 'player_name' => $card?->player_name,
                        // 'card_type' => $card?->card_type,
                        // 'card_order' => $card?->card_order,
                        // 'star_value' => $card?->star_value,
                    ];
                });

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => [
                    'user_id' => (int) $userId,
                    'stars_balance' => (int) $starsBalance,
                    'total_unique_cards' => GameUserCard::where('user_id', $userId)->count(),
                    'total_cards' => GameUserCard::where('user_id', $userId)->sum('quantity'),
                    'cards' => $userCards,
                    'reward_history' => $rewardHistory,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function gameOpened(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:game_reward_history,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            $reward = GameRewardHistory::findOrFail($request->input('id'));
            $wasAlreadyOpened = $reward->is_opened;

            if (!$wasAlreadyOpened) {
                $reward->update([
                    'is_opened' => true,
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => $wasAlreadyOpened
                    ? 'Game reward already opened.'
                    : 'Game reward opened successfully.',
                'data' => [
                    'id' => $reward->id,
                    'user_id' => $reward->user_id,
                    'card_id' => $reward->card_id,
                    'is_opened' => $reward->is_opened,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function starsForCardType(string $cardType): int
    {
        return match (strtoupper($cardType)) {
            'GOLD' => 5,
            'SILVER' => 3,
            default => 2,
        };
    }
}
