<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Models\Team;
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
            $currentTime = now()->timestamp * 1000;
    
            // Fetch all games
            $games = Game::with('predictions') 
                        ->get(['id', 'game_type', 'team_one_id', 'team_two_id', 'team_one_goals', 'team_two_goals', 'winning_team_id', 'first_goal_team_id', 'kick_off_time','match_status']);
    
            $upcomingGames = [];
            $completedGames = [];
            $ongoingGames = [];
    
            foreach ($games as $game) {
               
                if ( $game->match_status !== 'completed') {
                    $upcomingGames[] = $this->prepareGameData($game, $currentTime);
                }
              
                elseif ($game->match_status === 'completed') {
                    $completedGames[] = $this->prepareGameData($game, $currentTime);
                }
              
                elseif ($game->kick_off_time <= $currentTime && $game->match_status !== 'completed') {
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
        $predictions = $game->predictions;
        $isStarted = $game->kick_off_time <= $currentTime;
      
    
       
        $game->team_one_name = $game->teamOne->name ?? null;
        $game->team_one_flag = $game->teamOne->flag ? asset('storage/' . $game->teamOne->flag) : null;
        $game->team_two_name = $game->teamTwo->name ?? null;
        $game->team_two_flag = $game->teamTwo->flag ? asset('storage/' . $game->teamTwo->flag) : null;
        $game->winning_team_name = $game->winningTeam->name ?? null;
        $game->winning_team_flag = $game->winningTeam->flag ? asset('storage/' . $game->winningTeam->flag) : null;
        $game->firstgoal_team_name = $game->firstGoalTeam->name ?? null;
        $game->first_goal_team_flag = $game->firstGoalTeam->flag ? asset('storage/' . $game->firstGoalTeam->flag) : null;
        $game->isStarted = $isStarted;
       
        foreach ($predictions as $prediction) {
            // $predictedTeamOne = Team::find($prediction->team_one_id);
            // $predictedTeamTwo = Team::find($prediction->team_two_id);
            // $predictedWinningTeam = Team::find($prediction->winning_team_id);
            // $predictedFirstGoalTeam = Team::find($prediction->first_goal_team_id);
                
            $game->predicted_team_one_goals = $prediction->team_one_goals;
          //  $game->predicted_team_one_name = $predictedTeamOne ? $predictedTeamOne->name : null;
            $game->predicted_team_two_goals = $prediction->team_two_goals;
          //  $game->predicted_team_two_name = null ;
            $game->predicted_winning_team_id = $prediction->winning_team_id;
           // $game->predicted_winning_team_name = null ;
            $game->predicted_first_goal_id = $prediction->first_goal_team_id;
          //  $game->predicted_first_goal_name = null ;
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
