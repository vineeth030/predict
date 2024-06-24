<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Models\User;
use App\Models\Point;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Point::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function pointsBreakdown(Request $request)
    public function pointsBreakdown(Request $request)
    {
        // dd("inside");      

        try {

            $userId = $request->userId;
            $gameId = $request->gameId;
            // $userId = 16;
            // $gameId = 6;


            $pointsBreakdown = Point::where('user_id', $userId)
                ->where('game_id', $gameId)
                ->select('points', 'win_prediction', 'goal_prediction', 'first_goal_prediction')
                ->first();

            return response()->json(['status' =>  200, 'data' => $pointsBreakdown]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
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
    public function show(Point $point)
    {
        return $point->select('game_id', 'points')->where('user_id', auth()->user()->id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Point $point)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Point $point)
    {
        //
    }

    public function getTotalPointsForUser($userId)
    {


        try {
            // Total points earned by the user
            $totalPoints = (int) Point::where('user_id', $userId)->sum('points');
            $totalWinspredicted = Point::where('user_id', $userId)->where('win_prediction', 1)->count();
            $totalGoalspredicted = Point::where('user_id', $userId)->where('goal_prediction', 3)->count();

            //   dd($totalPoints);
            // Total matches played by the user
            $totalMatches = Game::whereHas('predictions', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->count();

            return response()->json([
                'status' => 200,
                'data' => [
                    'UserID' => $userId,
                    'TotalPoints' => $totalPoints,
                    'TotalMatchesPlayed' => $totalMatches,
                    'Win_prediction' => $totalWinspredicted,
                    'Goal_prediction' => $totalGoalspredicted,
                ]
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function headtoHead(Request $request)
    {
        try {
            $userId1 = $request->userId1;
            $userId2 = $request->userId2;

            $user1Email = User::where('id', $userId1)->pluck('email');
            $user2Email = User::where('id', $userId2)->pluck('email');

            $user1MatchesPlayed = Point::where('user_id', $userId1)->count();
            $user1Wins = Point::where('user_id', $userId1)->where('win_prediction', 1)->count();
            $user1Points = Point::where('user_id', $userId1)->sum('points');
            $user1WinPercentage = $user1MatchesPlayed > 0 ? ($user1Wins / $user1MatchesPlayed) * 100 : 0;

            $user2MatchesPlayed = Point::where('user_id', $userId2)->count();
            $user2Wins = Point::where('user_id', $userId2)->where('win_prediction', 1)->count();
            $user2Points = Point::where('user_id', $userId2)->sum('points');
            $user2WinPercentage = $user2MatchesPlayed > 0 ? ($user2Wins / $user2MatchesPlayed) * 100 : 0;

            return response()->json([
                'message' => 'success',
                'status' => 200,
                'user1' => [
                    'user_id' =>  $userId1,
                    'matches_played' => $user1MatchesPlayed,
                    'points' => "$user1Points",
                    'wins' => Point::where('user_id', $userId1)->where('win_prediction', 1)->count(),
                    'win_percentage' => round($user1WinPercentage, 0),
                    'score_predicted' => Point::where('user_id', $userId1)->where('goal_prediction', 3)->count(),
                    'first_goal_predicted' => Point::where('user_id', $userId1)->where('first_goal_prediction', 1)->count(),
                    'win_predicted' => Point::where('user_id', $userId1)->where('win_prediction', 1)->count(),
                    'email' => $user1Email[0],
                ],
                'user2' => [
                    'user_id' =>  $userId2,
                    'matches_played' => $user2MatchesPlayed,
                    'points' => "$user2Points",
                    'wins' => Point::where('user_id', $userId2)->where('win_prediction', 1)->count(),
                    'win_percentage' => round($user2WinPercentage, 0),
                    'score_predicted' => Point::where('user_id', $userId2)->where('goal_prediction', 3)->count(),
                    'first_goal_predicted' => Point::where('user_id', $userId2)->where('first_goal_prediction', 1)->count(),
                    'win_predicted' => Point::where('user_id', $userId2)->where('win_prediction', 1)->count(),
                    'email' => $user2Email[0],
                ],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /*  public function allUserPoints()
    {
        $companyGroupId = auth()->user()->company_group_id;

        $users = User::leftJoin('points', 'users.id', '=', 'points.user_id')
            ->leftJoin('cards_game', 'users.id', '=', 'cards_game.user_id')
            ->select(
                'users.id',
                'users.image',
                'users.fav_team',
                'users.name',
                DB::raw('CAST(COALESCE(SUM(points.points), 0) AS UNSIGNED) as total_points'),
                DB::raw('CAST(COALESCE(users.old_rank, 0) AS UNSIGNED) as old_rank'),
                DB::raw('CAST(COALESCE(users.new_rank, 0) AS UNSIGNED) as new_rank'),
                DB::raw('IFNULL(LENGTH(cards_game.cards_opened) - LENGTH(REPLACE(cards_game.cards_opened, ",", "")) + 1, 0) as stars_collected')

            )
            ->where('users.company_group_id', $companyGroupId)
            ->where('users.verified', 1)
            ->groupBy('users.id', 'users.name', 'users.image', 'users.old_rank', 'users.new_rank', 'users.fav_team', 'stars_collected')
            ->orderBy('total_points', 'desc')
            ->get();

        $baseImagePath = url('storage/profile_images/');

        foreach ($users as $user) {
            $rankChange =$user->old_rank  - $user->new_rank;
            $user->rank_change = $rankChange > 0 ? '+1' : ($rankChange < 0 ? '-1' : '0');
            $user->image = $user->image ? $baseImagePath . '/' . $user->image : null;
        }

        return response()->json(['status' => 200, 'message' => 'success', 'data' => $users]);
    }  */


    public function allUserPoints()
    {
        $companyGroupId = auth()->user()->company_group_id;

        // Retrieve users with total points
        $users = User::leftJoin('points', 'users.id', '=', 'points.user_id')
            ->leftJoin('games', 'points.game_id', '=', 'games.id')
            ->leftJoin('predictions', function ($join) {
                $join->on('users.id', '=', 'predictions.user_id')
                    ->on('games.id', '=', 'predictions.game_id')
                    ->where('games.game_type', 'final-prediction');
            })
            ->leftJoin('cards_game', 'users.id', '=', 'cards_game.user_id')
            ->select(
                'users.id',
                'users.image',
                'users.fav_team',
                'users.name',
                DB::raw('CAST(COALESCE(SUM(points.points), 0) AS UNSIGNED) as total_points'),
                DB::raw('CAST(COALESCE(SUM(CASE WHEN games.game_type = "final-prediction" THEN points.points ELSE 0 END), 0) AS UNSIGNED) as final_prediction_points'),
                DB::raw('CAST(COALESCE(users.old_rank, 0) AS UNSIGNED) as old_rank'),
                DB::raw('CAST(COALESCE(users.new_rank, 0) AS UNSIGNED) as new_rank'),
                DB::raw('IFNULL(LENGTH(cards_game.cards_opened) - LENGTH(REPLACE(cards_game.cards_opened, ",", "")) + 1, 0) as stars_collected')
            )
            ->where('users.company_group_id', $companyGroupId)
            ->where('users.verified', 1)
            ->groupBy('users.id', 'users.name', 'users.image', 'users.old_rank', 'users.new_rank', 'users.fav_team', 'stars_collected')
            ->orderBy('total_points', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        $predictions = DB::table('predictions')
            ->leftJoin('games', 'predictions.game_id', '=', 'games.id')
            ->select(
                'predictions.user_id',
                'predictions.final_team_one_id',
                'predictions.final_team_two_id',
                'predictions.winning_team_id'
            )
            ->where('games.game_type', 'final-prediction')
            ->get();

        foreach ($users as $user) {
            $prediction = $predictions->firstWhere('user_id', $user->id);

            if ($prediction) {
                $user->final_team_one_id = $prediction->final_team_one_id;
                $user->final_team_two_id = $prediction->final_team_two_id;
                $user->winning_team_id = $prediction->winning_team_id;
            } else {
                $user->final_team_one_id = null;
                $user->final_team_two_id = null;
                $user->winning_team_id = null;
            }
        }



        // Separate users with 0 points
        $usersWithPoints = $users->filter(function ($user) {
            return $user->total_points > 0;
        });
        $usersWithZeroPoints = $users->filter(function ($user) {
            return $user->total_points == 0;
        });

        // Merge users with points and those with zero points
        $sortedUsers = $usersWithPoints->merge($usersWithZeroPoints);

        // Initialize variables
        $baseImagePath = url('storage/profile_images/');
        $rank = 1;
        $previousPoints = null;
        $adjustedRank = 1;

        foreach ($sortedUsers as $user) {
            $userModel = User::find($user->id);

            // Set old rank to current new rank before updating
            $user->old_rank = (int)$userModel->new_rank;

            // If the current user's points are the same as the previous user's points, they share the same rank
            if ($previousPoints !== null && $user->total_points == $previousPoints) {
                $user->new_rank = $adjustedRank;
            } else {
                $user->new_rank = $rank;
                $adjustedRank = $rank;
            }
            // Calculate rank change
            $rankChange = $userModel->new_rank - $userModel->old_rank;
            $user->rank_change = $rankChange > 0 ? '-1' : ($rankChange < 0 ? '+1' : '0');


            // Update image path
            $user->image = $user->image ? $baseImagePath . '/' . $user->image : null;

            // Save updated rank in the User model
            //  $userModel->old_rank = $userModel->new_rank;
            $userModel->new_rank = $user->new_rank;
            $userModel->save();

            // Update previous points and increment rank
            $previousPoints = $user->total_points;
            $rank++;
        }

        return response()->json(['status' => 200, 'message' => 'success', 'data' => $sortedUsers]);
    }

    public function userPredictions($game_id)
    {

        $companyGroupId = auth()->user()->company_group_id;
        $kickoffTime = DB::table('games')
            ->where('id', $game_id)
            ->value('kick_off_time');
        $currentTime = (int) round(microtime(true) * 1000);
        if ($currentTime > $kickoffTime) {
            $userPredictions = DB::table('predictions')
                ->join('users', 'predictions.user_id', '=', 'users.id')
                ->join('games', 'predictions.game_id', '=', 'games.id')
                ->leftJoin('points', function ($join) {
                    $join->on('predictions.user_id', '=', 'points.user_id')
                        ->on('predictions.game_id', '=', 'points.game_id');
                })
                ->select(
                    'users.name as username',
                    'predictions.user_id',
                    'predictions.game_id',
                    'games.game_type',
                    'predictions.winning_team_id',
                    'predictions.team_one_goals',
                    'predictions.team_two_goals',
                    'predictions.first_goal_team_id',
                    DB::raw('COALESCE(points.points, 0) as points_earned')

                )
                ->where('users.company_group_id', $companyGroupId)
                ->where('users.verified', 1)
                ->where('predictions.game_id', $game_id)
                ->orderBy('points_earned', 'desc')
                ->orderBy('users.name')
                ->get();
            return response()->json(['status' => 200, 'message' => 'success', 'data' => $userPredictions]);
        } else {
            return response()->json(['status' => 200, 'message' => 'success', 'data' => null]);
        }
    }

    public function userMatchesAll($user_id)
    {


        $games = Game::where('match_status', 'completed')->where("game_type", "!=", "final-prediction")->orderBy('id', 'desc')->get();

        $predictions = [];
        foreach ($games as $game) {
            $prediction = Prediction::where('game_id', $game->id)->where('user_id', $user_id)->first();
            $point = Point::where('game_id', $game->id)->where('user_id', $user_id)->first();
            if ($prediction) {
                $prediction = [
                    'game_id' => $game->id,
                    'games_team_one_id' => $game->team_one_id,
                    'games_team_two_id' => $game->team_two_id,
                    'completed_match_team_one_score' => $game->team_one_goals,
                    'completed_match_team_two_score' => $game->team_two_goals,
                    'completed_match_winning_team_id' => $game->winning_team_id,
                    'completed_match_first_goal_team_id' => $game->first_goal_team_id,
                    'predictions_team_one_goals' => $prediction->team_one_goals,
                    'predictions_team_two_goals' => $prediction->team_two_goals,
                    'predictions_winning_team_id' => $prediction->winning_team_id,
                    'predictions_first_goal_team_id' => $prediction->first_goal_team_id,
                    'points' => $point->points,
                ];
            } else {
                $prediction = [
                    'game_id' => $game->id,
                    'games_team_one_id' => $game->team_one_id,
                    'games_team_two_id' => $game->team_two_id,
                    'completed_match_team_one_score' => $game->team_one_goals,
                    'completed_match_team_two_score' => $game->team_two_goals,
                    'completed_match_winning_team_id' => $game->winning_team_id,
                    'completed_match_first_goal_team_id' => $game->first_goal_team_id,
                    'predictions_team_one_goals' => null,
                    'predictions_team_two_goals' => null,
                    'predictions_winning_team_id' => null,
                    'predictions_first_goal_team_id' => null,
                    'points' => null,


                ];
            }
            $predictions[] = $prediction;
        }

        return response()->json(['status' => 200, 'message' => 'success', 'data' => $predictions]);
    }
}
