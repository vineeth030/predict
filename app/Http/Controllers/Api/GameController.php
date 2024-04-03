<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Prediction;

class GameController extends Controller
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_OK = 200;

    public function index()
    {
        try {



            $games = Game::all('id', 'team_one_id', 'team_two_id', 'team_one_goals', 'team_two_goals', 'winning_team_id', 'kick_off_time', 'first_goal_team_id');



            foreach ($games as $game) {
                $gameId = $game->id;


                $game->team_one_name = $game->teamOne->name ? $game->teamOne->name : null;
                $game->team_one_flag = $game->teamOne->flag? 'storage/' . $game->teamOne->flag : null;
                $game->team_two_name = $game->teamTwo->name ? $game->teamTwo->name : null;
                $game->team_two_flag = $game->teamTwo->flag ? 'storage/' . $game->teamTwo->flag : null;
                $game->winning_team_name = $game->winningTeam->name ? $game->winningTeam->name : null;
                $game->winning_team_flag = $game->winningTeam->flag ? 'storage/' .  $game->winningTeam->flag : null;
                $game->firstgoal_team_name = $game->firstGoalTeam->name ? $game->firstGoalTeam->name : null;
                $game->first_goal_team_flag = $game->firstGoalTeam->flag ? 'storage/' .  $game->firstGoalTeam->flag : null;

           // dd($game->firstGoalTeam->name ? $game->firstGoalTeam->name : null);
                unset($game->teamOne, $game->teamTwo, $game->winningTeam , $game->firstGoalTeam);

                // Retrieve top 3 predictions for the current match
                $totalPredictions = DB::table('predictions')
                    ->where('game_id', $gameId)
                    ->count();

                $topPredictions = DB::table('predictions')
                    ->select(
                        'team_one_goals',
                        'team_two_goals',
                        DB::raw('COUNT(*) as prediction_count'),
                        DB::raw('(COUNT(*) / ' . $totalPredictions . ') * 100 as percentage')
                    )
                    ->where('game_id', $gameId)
                    ->groupBy('team_one_goals', 'team_two_goals')
                    ->orderByDesc('prediction_count')
                    ->take(4)
                    ->get();


                $game->top_predictions = $topPredictions;
            }



            return response()->json(['status' => 'success', 'data' => $games], self::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
