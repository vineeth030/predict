<?php

namespace App\Http\Controllers\Api;

use App\Models\Point;
use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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

try{

    $userId = $request->userId;
    $gameId = $request->gameId;
   // $userId = 16;
   // $gameId = 6;


   $pointsBreakdown = Point::where('user_id', $userId)
   ->where('game_id', $gameId)
   ->select('points', 'win_prediction', 'goal_prediction', 'first_goal_prediction')
   ->first();

   return response()->json(['status' =>  200, 'data' => $pointsBreakdown]);

}catch(\Exception $e){
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
    
            $user1MatchesPlayed = Point::where('user_id', $userId1)->count();
            $user1Wins = Point::where('user_id', $userId1)->where('goal_prediction', 3)->count();
            $user1Points = Point::where('user_id', $userId1)->sum('points');
            $user1WinPercentage = $user1MatchesPlayed > 0 ? ($user1Wins / $user1MatchesPlayed) * 100 : 0;
    
            $user2MatchesPlayed = Point::where('user_id', $userId2)->count();
            $user2Wins = Point::where('user_id', $userId2)->where('goal_prediction', 3)->count();
            $user2Points = Point::where('user_id', $userId2)->sum('points');
            $user2WinPercentage = $user2MatchesPlayed > 0 ? ($user2Wins / $user2MatchesPlayed) * 100 : 0;
    
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'user1' => [
                    'user_id' =>  $userId1,
                    'matches_played' => $user1MatchesPlayed,
                    'points' => "$user1Points",
                    'wins' => $user1Wins,
                    'win_percentage' => round($user1WinPercentage, 0),
                    'score_predicted' => Point::where('user_id', $userId1)->where('goal_prediction', 3)->count(),
                    'first_goal_predicted' => Point::where('user_id', $userId1)->where('first_goal_prediction', 1)->count(),
                    'win_predicted' => Point::where('user_id', $userId1)->where('win_prediction', 1)->count(),
                ],
                'user2' => [
                    'user_id' =>  $userId2,
                    'matches_played' => $user2MatchesPlayed,
                    'points' => "$user2Points",
                    'wins' => $user2Wins,
                    'win_percentage' => round($user2WinPercentage, 0),
                    'score_predicted' => Point::where('user_id', $userId2)->where('goal_prediction', 3)->count(),
                    'first_goal_predicted' => Point::where('user_id', $userId2)->where('first_goal_prediction', 1)->count(),
                    'win_predicted' => Point::where('user_id', $userId2)->where('win_prediction', 1)->count(),
                ],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

  /*  public function allUserPoints()
    {
        $companyGroupId = auth()->user()->company_group_id;
       // dd($companyGroupId);
       // Calculate the sum of points for each user ID
        $userPoints = Point::select('user_id', DB::raw('SUM(points) as total_points'))
            ->join('users', 'points.user_id', '=', 'users.id')
            ->where('users.company_group_id', $companyGroupId)
            ->where('users.verified', 1)
            ->groupBy('user_id')
            ->orderBy('total_points', 'desc')
            ->get();

        // Assign ranks based on the order of users' total points
        // $rank = 1;
        // foreach ($userPoints as $userPoint) {
        //     $user = User::find($userPoint->user_id);
        //     $user->old_rank = $user->new_rank; // Save the old rank
        //     $user->new_rank = $rank++;
        //     $user->save();
        // }

        $users = User::leftJoin('points', 'users.id', '=', 'points.user_id')
        ->select('users.id', 'users.name', 'users.image',
            DB::raw('SUM(points.points) as total_points'), 
            'users.old_rank', 'users.new_rank')
            ->where('users.company_group_id', $companyGroupId)
            ->where('users.verified', 1)
        ->groupBy('users.id', 'users.name', 'users.old_rank', 'users.new_rank')
        ->get();

        foreach ($users as $user) {
            $rankChange = $user->new_rank - $user->old_rank;
            $user->rank_change = $rankChange > 0 ? '+1' : ($rankChange < 0 ? '-1' : '0');
        }


        return response()->json(['status' => 200,'message' =>'success' ,'data' => $users]);
    }    */

   public function allUserPoints()
    {
        $companyGroupId = auth()->user()->company_group_id;
    
        $users = User::leftJoin('points', 'users.id', '=', 'points.user_id')
            ->select('users.id', 'users.image','users.fav_team','users.name',
            DB::raw('COALESCE(SUM(points.points), 0) as total_points'), 
                DB::raw('CAST(COALESCE(users.old_rank, 0) AS UNSIGNED) as old_rank'),
                DB::raw('CAST(COALESCE(users.new_rank, 0) AS UNSIGNED) as new_rank'))
            ->where('users.company_group_id', $companyGroupId)
            ->where('users.verified', 1)
            ->groupBy('users.id', 'users.name', 'users.image', 'users.old_rank', 'users.new_rank','users.fav_team')
            ->orderBy('total_points', 'desc')
            ->orderBy('name', 'asc')
            ->get();

            $baseImagePath = url('storage/profile_images/');
    
        foreach ($users as $user) {
            $rankChange = $user->new_rank - $user->old_rank;
            $user->rank_change = $rankChange > 0 ? '+1' : ($rankChange < 0 ? '-1' : '0');
            $user->image = $user->image ? $baseImagePath . '/' . $user->image : null;
        }
    
        return response()->json(['status' => 200, 'message' => 'success', 'data' => $users]);
    } 
/*    public function allUserPoints()
{
    $companyGroupId = auth()->user()->company_group_id;

    $users = User::leftJoin('points', 'users.id', '=', 'points.user_id')
        ->select(
            'users.id',
            'users.name',
            'users.image',
            'users.fav_team',
            DB::raw('COALESCE(SUM(points.points), 0) as total_points'),
            DB::raw('CAST(COALESCE(users.old_rank, 0) AS UNSIGNED) as old_rank'),
            DB::raw('CAST(COALESCE(users.new_rank, 0) AS UNSIGNED) as new_rank')
        )
        ->where('users.company_group_id', $companyGroupId)
        ->where('users.verified', 1)
        ->groupBy('users.id', 'users.name', 'users.image', 'users.old_rank', 'users.new_rank')
        ->orderBy('total_points', 'desc')
        ->orderBy('name', 'asc')
        ->get();

    // Initialize rank variables
    $currentRank = 0;
    $previousPoints = null;
    $rankCounter = 0;

    foreach ($users as $user) {
        // Cast total_points to integer
        $user->total_points = (int) $user->total_points;

        // Compute rank
        if ($previousPoints !== $user->total_points) {
            $currentRank = $rankCounter + 1;
        }
        $user->rank = $currentRank;

        // Update previousPoints and rankCounter
        $previousPoints = $user->total_points;
        $rankCounter++;

        // Calculate rank change
        $rankChange = $user->new_rank - $user->old_rank;
        $user->rank_change = $rankChange > 0 ? '+1' : ($rankChange < 0 ? '-1' : '0');
    }

    return response()->json(['status' => 200, 'message' => 'success', 'data' => $users]);
}
*/
    
    
}
