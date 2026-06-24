<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::paginate(50); // 10 users per page

        $userIds = $users->getCollection()->pluck('id')->all();

        $cardsCollectedByUser = empty($userIds)
            ? collect()
            : DB::table('game_user_card')
                ->join('game_card', 'game_user_card.card_id', '=', 'game_card.id')
                ->join('teams', 'game_card.country_id', '=', 'teams.id')
                ->whereIn('game_user_card.user_id', $userIds)
                ->where('game_user_card.quantity', '>', 0)
                ->where('game_card.is_active', true)
                ->select('game_user_card.user_id', 'game_card.country_id', 'teams.name as country_name', 'game_user_card.card_id')
                ->orderBy('game_card.country_id')
                ->orderBy('game_user_card.card_id')
                ->get()
                ->groupBy('user_id')
                ->map(function ($userCards) {
                    return $userCards
                        ->groupBy('country_id')
                        ->map(function ($countryCards, $countryId) {
                            return [
                                'country_id' => (int) $countryId,
                                'country_name' => $countryCards->first()->country_name,
                                'card_ids' => $countryCards
                                    ->pluck('card_id')
                                    ->unique()
                                    ->values()
                                    ->implode(', '),
                            ];
                        })
                        ->values();
                });

        $users->getCollection()->transform(function ($user) use ($cardsCollectedByUser) {
            $user->cards_collected_by_country = $cardsCollectedByUser->get($user->id, collect());

            return $user;
        });

        return view('users', compact('users'));
    }
}
