<?php

namespace App\Http\Controllers\Api;

use App\Models\GameCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
