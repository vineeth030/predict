<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {

        return view('games', [
            'games' => Game::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $game = Game::findOrFail($id);
            // dd($game);
            $game->update($request->only(['winning_team_id', 'team_one_goals', 'team_two_goals','first_goal_team_id']));
            $this->calculateUserPoints($game);
            return redirect()->back()->with('success', 'Match result updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update match result. ' . $e->getMessage());
        }
    }

    private function calculateUserPoints($game)
    {


        $predictions = $game->predictions;
      //  dd($predictions);
        foreach ($predictions as $prediction) {
            $pointsEarned = 0;
            $correctWinpredicted  = 0;
            $correctGoalpredicted  = 0;
            $firstGoalprediction= 0;
            if ($game->winning_team_id == $prediction->winning_team_id) {
                // Correct outcome prediction
                $pointsEarned += 1;
                $correctWinpredicted  += 1;

                if ($game->team_one_goals == $prediction->team_one_goals && $game->team_two_goals == $prediction->team_two_goals) {
                    // Correct team1 goals prediction
                    $pointsEarned += 3;
                    $correctGoalpredicted  += 3;
                }

                if ($game->first_goal_team_id == $prediction->first_goal_team_id) {
                    // Correct team2 goals prediction
                    $pointsEarned += 1;
                    $firstGoalprediction += 1;
                }
            }
            // Find existing user points or create new if not exist
            $userPoint = Point::where('user_id', $prediction->user_id)
                ->where('game_id', $game->id)
                ->first();

            //dd($userPoint);

            if ($userPoint) {
                // Update existing user points
                // $userPoint->update(['PointsEarned' => $pointsEarned]);
                Point::where('user_id', $prediction->user_id)
                    ->where('game_id', $game->id)
                    ->update(['points' => $pointsEarned,
                   'win_prediction' => $correctWinpredicted,
                    'goal_prediction' => $correctGoalpredicted,
                    'first_goal_prediction' => $firstGoalprediction]);
            } else {
                // Create new user points record
                Point::create([
                    'user_id' => $prediction->user_id,
                    'game_id' => $game->id,
                    'points' => $pointsEarned,
                    'win_prediction' => $correctWinpredicted,
                    'goal_prediction' => $correctGoalpredicted,
                    'first_goal_prediction' => $firstGoalprediction
                ]);
            }
        }
    }
}
