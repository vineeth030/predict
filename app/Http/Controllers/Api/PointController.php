<?php

namespace App\Http\Controllers\Api;

use App\Models\Point;
use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /*   public function headtoHead(Request $request)
    {
        $userId1 = $request->userId1;
        $userId2 = $request->userId2;

        $response = [
            'user1' => [

                'matches_played' =>  Game::whereHas('predictions', function ($query) use ($userId1) {
                    $query->where('user_id', $userId1);
                })->count(),
                'points' => Point::where('user_id', $request->userId1)->sum('points'),
                'wins'  => Point::where('user_id', $userId1)->where('win_prediction', 1)->count(),
            ],
            'user2' => [

                'matches_played' =>  Game::whereHas('predictions', function ($query) use ($userId2) {
                    $query->where('user_id', $userId2);
                })->count(),
                'points' => Point::where('user_id', $userId1)->sum('points'),

                'wins'  => Point::where('user_id', $userId2)->where('win_prediction', 1)->count(),
            ],
        ];
        return response()->json($response);
    } */


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
}
