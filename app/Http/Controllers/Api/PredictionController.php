<?php

namespace App\Http\Controllers\Api;

use App\Models\Prediction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PredictionController extends Controller
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_OK = 200;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Prediction::all();
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
    public function show()
    {
        $prediction = Prediction::where('user_id', auth()->user()->id)->get();

        if(count($prediction) > 0) {
            return $prediction;
        }else{
            return response()->json(['message' => 'No predictions found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prediction $prediction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prediction $prediction)
    {
        try {
            $userId = auth()->user()->id;
            $gameId = $request->input('game_id');

            // Find the prediction for the given match ID and user ID
            $prediction = Prediction::where('user_id', $userId)
                ->where('game_id', $gameId)
                ->first();

            if ($prediction) {
                // Prediction exists, update the existing prediction
                $prediction->update([
                    'winning_team_id' => $request->input('winning_team_id'),
                    'team_one_goals' => $request->input('team_one_goals'),
                    'team_two_goals' => $request->input('team_two_goals'),
                    'first_goal_team_id' => $request->input('first_goal_team_id'),
                ]);
            } else {
                // Prediction does not exist, create a new prediction
                Prediction::create([
                    'user_id' => $userId,
                    'game_id' => $gameId,
                    'winning_team_id' => $request->input('winning_team_id'),
                    'team_one_goals' => $request->input('team_one_goals'),
                    'team_two_goals' => $request->input('team_two_goals'),
                    'first_goal_team_id' => $request->input('first_goal_team_id'),
                ]);
            }

            return response()->json(['status' => 'success', 'message' => 'Prediction updated or created successfully'], self::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prediction $prediction)
    {
        //
    }
}
