<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Models\Point;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Prediction;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_OK = 200;

    public function index()
    {
        try {
         
            $userId = auth()->user()->id;
        //  $userId = 27;
           /// dd($userId);
            $currentTime = now()->timestamp * 1000;

           $games = Game::with(['predictions' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
            ->get(['id', 'game_type', 'team_one_id', 'team_two_id', 'team_one_goals', 'team_two_goals', 'winning_team_id', 'first_goal_team_id', 'kick_off_time', 'match_status']);

            // Fetch all games
            // $games = Game::with('predictions')
            //     ->get(['id', 'game_type', 'team_one_id', 'team_two_id', 'team_one_goals', 'team_two_goals', 'winning_team_id', 'first_goal_team_id', 'kick_off_time', 'match_status']);
            $games = Game::with(['predictions' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
                ->get(['id', 'game_type', 'team_one_id', 'team_two_id', 'team_one_goals', 'team_two_goals', 'winning_team_id', 'first_goal_team_id', 'kick_off_time', 'match_status']);


            $upcomingGames = [];
            $completedGames = [];
            $ongoingGames = [];

            foreach ($games as $game) {

                if ($game->match_status !== 'completed') {
                    $upcomingGames[] = $this->prepareGameData($game, $currentTime);
                } elseif ($game->match_status === 'completed') {
                    $completedGames[] = $this->prepareGameData($game, $currentTime);

                 //   $completedMatchPredictions[$game->id] = $game->predictions;

                  //  dd($game->predictions);
                } elseif ($game->kick_off_time <= $currentTime && $game->match_status !== 'completed') {
                    $ongoingGames[] = $this->prepareGameData($game, $currentTime);
                }
            }

            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'upcoming_games' => $upcomingGames,
                'completed_games' => $completedGames,
                'ongoing_games' => $ongoingGames,
            ], self::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function prepareGameData($game, $currentTime)
    {
        $userId = auth()->user()->id;
        $predictions = $game->predictions;
        $isStarted = $game->kick_off_time <= $currentTime;
    
        $game->team_one_name = $game->teamOne ? $game->teamOne->name : null;
        $game->team_two_name = $game->teamTwo ? $game->teamTwo->name : null;
        $game->winning_team_name = $game->winningTeam ? $game->winningTeam->name : null;
        $game->firstgoal_team_name = $game->firstGoalTeam ? $game->firstGoalTeam->name : null;
       // $game->team_one_flag = $game->teamOne ? asset('storage/' . $game->teamOne->flag) : null;    
      //  $game->team_two_flag = $game->teamTwo ? asset('storage/' . $game->teamTwo->flag) : null;      
       // $game->winning_team_flag = $game->winningTeam ? asset('storage/' . $game->winningTeam->flag) : null;    
       // $game->first_goal_team_flag = $game->firstGoalTeam ? asset('storage/' . $game->firstGoalTeam->flag) : null;

       if ($game->match_status === 'completed') {
        $totalPoints = Point::where('game_id', $game->id)->where('user_id',$userId)->sum('points');
        $game->points =(int) $totalPoints;
    } else {
        $game->points = null; // Set points to null for upcoming and ongoing games
    }
        $game->isStarted = $isStarted;

        $game->team_one_flag = $game->teamOne ? $game->teamOne->flag : null;
        if (!is_null($game->team_one_flag)) {
            $game->team_one_flag = asset('storage/' . $game->team_one_flag);
        }

        $game->team_two_flag = $game->teamTwo ? $game->teamTwo->flag : null;
        if (!is_null($game->team_two_flag)) {
            $game->team_two_flag = asset('storage/' . $game->team_two_flag);
        }
        $game->winning_team_flag = $game->winningTeam ? $game->winningTeam->flag : null;
        if (!is_null($game->winning_team_flag)) {
            $game->winning_team_flag = asset('storage/' . $game->winning_team_flag);
        }
        $game->first_goal_team_flag = $game->firstGoalTeam ? $game->firstGoalTeam->flag : null;
        if (!is_null($game->first_goal_team_flag)) {
            $game->first_goal_team_flag = asset('storage/' . $game->first_goal_team_flag);
        }

    
        foreach ($predictions as $prediction) {
            $game->predicted_team_one_goals = $prediction->team_one_goals ?? null;
            $game->predicted_team_two_goals = $prediction->team_two_goals ?? null;
            $game->predicted_winning_team_id = $prediction->winning_team_id ?? null;
            $game->predicted_first_goal_id = $prediction->first_goal_team_id ?? null;
            $game->is_score_predicted = !is_null($prediction->team_one_goals && $prediction->team_two_goals);
            $game->is_first_goal_predicted = !is_null($prediction->winning_team_id);
        }
        $game->top_predictions = $this->getTopPredictions($game->id);
        
    
        unset($game->teamOne, $game->teamTwo, $game->winningTeam, $game->firstGoalTeam, $game->predictions);
    
        return $game;
    }
    

    private function getTopPredictions($gameId)
    {

        $totalPredictions = DB::table('predictions')
            ->where('game_id', $gameId)
            ->count();

        return DB::table('predictions')
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
    }

    public function index1()
    {

       // dd("inside");
        $games = Game::all();
        return response()->json(['status' => 'success', 'data' => $games], 200);
    }
    
    public function show($id)
    {
        $game = Game::findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $game], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_one_id' => 'required|integer',
            'team_two_id' => 'required|integer',
            'game_type' => 'required|string',
            'match_status' => 'required|string',
            'kick_off_time' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 400);
        }
    
        $game = Game::create($request->all());
        return response()->json(['status' => 'success', 'data' => $game], 201);
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'team_one_id' => 'required|integer',
            'team_two_id' => 'required|integer',
            'game_type' => 'required|string',
            'match_status' => 'required|string',
            'kick_off_time' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 400);
        }
    
        $game = Game::findOrFail($id);
        $game->update($request->all());
        return response()->json(['status' => 'success', 'data' => $game], 200);
    }
    
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();
        return response()->json(['status' => 'success', 'message' => 'Game deleted successfully'], 200);
    }

 

}
