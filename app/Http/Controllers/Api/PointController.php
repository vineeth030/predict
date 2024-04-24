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
            $totalPoints = Point::where('user_id', $userId)->sum('points');
            $totalWinspredicted = Point::where('user_id', $userId)->where('win_prediction', 1)->count();
            $totalGoalspredicted = Point::where('user_id', $userId)->where('goal_prediction', 3)->count();

            //   dd($totalPoints);
            // Total matches played by the user
            $totalMatches = Game::whereHas('predictions', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->count();

            return response()->json([
                'status' => 'success',
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
            return response()->json([
                'status' => 'success',
                'user1' => [
                    'matches_played' => Point::where('user_id',  $userId1)->count(),
                    'points' => Point::where('user_id', $request->userId1)->sum('points'),
                    'wins'  =>   Point::where('user_id', $userId1)->where('goal_prediction', 3)->count(),
                ],
                'user2' => [
                    'matches_played' => Point::where('user_id',  $userId2)->count(),
                    'points' => Point::where('user_id', $userId2)->sum('points'),
                    'wins'  =>   Point::where('user_id', $userId2)->where('goal_prediction', 3)->count(),
                ],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function allUserPoints()
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
        ->select('users.id', 'users.name', 
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


        return response()->json(['status' => 'success', 'data' => $users]);
    }
}
