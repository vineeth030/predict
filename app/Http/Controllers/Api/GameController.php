<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use App\Models\Point;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Prediction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_OK = 200;

    public function index()
    {
        try {
            $userId = auth()->user()->id;

            $currentTime = now()->timestamp * 1000;

            $games = Game::with([
                "predictions" => function ($query) use ($userId) {
                    $query->where("user_id", $userId);
                },
            ])->get([
                "id",
                "game_type",
                "team_one_id",
                "team_two_id",
                "team_one_goals",
                "team_two_goals",
                "winning_team_id",
                "first_goal_team_id",
                "kick_off_time",
                "match_status",
                "stadium_name",
            ]);

            $upcomingGames = [];
            $completedGames = [];
            $ongoingGames = [];

            foreach ($games as $game) {
                if ($game->match_status !== "completed") {
                    $upcomingGames[] = $this->prepareGameData(
                        $game,
                        $currentTime
                    );
                } elseif ($game->match_status === "completed") {
                    $completedGames[] = $this->prepareGameData(
                        $game,
                        $currentTime
                    );
                } elseif (
                    $game->kick_off_time <= $currentTime &&
                    $game->match_status !== "completed"
                ) {
                    $ongoingGames[] = $this->prepareGameData(
                        $game,
                        $currentTime
                    );
                }
            }

            return response()->json(
                [
                    "status" => "success",
                    "status_code" => 200,
                    "upcoming_games" => $upcomingGames,
                    "completed_games" => $completedGames,
                    "ongoing_games" => $ongoingGames,
                ],
                self::HTTP_OK
            );
        } catch (\Exception $e) {
            return response()->json(
                ["status" => "error", "message" => $e->getMessage()],
                self::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function prepareGameData($game, $currentTime)
    {
        $userId = auth()->user()->id;
        $predictions = $game->predictions;

        $isStarted = $game->kick_off_time <= $currentTime;

        $game->team_one_name = $game->teamOne ? $game->teamOne->name : null;
        $game->team_two_name = $game->teamTwo ? $game->teamTwo->name : null;
        $game->winning_team_name = $game->winningTeam
            ? $game->winningTeam->name
            : null;
        $game->firstgoal_team_name = $game->firstGoalTeam
            ? $game->firstGoalTeam->name
            : null;





        if ($game->match_status === "completed") {
            $totalPoints = Point::where("game_id", $game->id)
                ->where("user_id", $userId)
                ->sum("points");
            $game->points = (int) $totalPoints;
        } else {
            $game->points = null; // Set points to null for upcoming and ongoing games
        }
        $game->isStarted = $isStarted;

        if (count($predictions) == 0) {
            $game->predicted_team_one_goals = null;
            $game->predicted_team_two_goals = null;
            $game->predicted_winning_team_id = null;
            $game->predicted_first_goal_id = null;
            $game->predicted_final_team_one_id = null;
            $game->predicted_final_team_two_id = null;
            $game->final_predicted_team_two_name = null;
            $game->final_predicted_team_one_name = null;
            $game->is_score_predicted = false;

            $game->is_first_goal_predicted = false;
        } else {
            foreach ($predictions as $prediction) {
                $game->predicted_team_one_goals =
                    $prediction->team_one_goals ?? null;
                $game->predicted_team_two_goals =
                    $prediction->team_two_goals ?? null;
                $game->predicted_winning_team_id =
                    $prediction->winning_team_id ?? null;
                $game->predicted_first_goal_id =
                    $prediction->first_goal_team_id ?? null;
                $game->predicted_final_team_one_id =
                    $prediction->final_team_one_id ?? null;
                $game->predicted_final_team_two_id =
                    $prediction->final_team_two_id ?? null;

                $game->final_predicted_team_one_name = $prediction->finalTeamOne
                    ? $prediction->finalTeamOne->name
                    : null;

                $game->final_predicted_team_two_name = $prediction->finalTeamTwo
                    ? $prediction->finalTeamTwo->name
                    : null;

                $game->is_score_predicted = !is_null(
                    $prediction->team_one_goals && $prediction->team_two_goals
                );
                $game->is_first_goal_predicted = !is_null(
                    $prediction->first_goal_team_id
                );
            }
        }

        $game->top_predictions = $this->getTopPredictions($game->id);

        unset(
            $game->teamOne,
            $game->teamTwo,
            $game->winningTeam,
            $game->firstGoalTeam,
            $game->predictions
        );

        return $game;
    }

    private function getTopPredictions($gameId)
    {
        $totalPredictions = DB::table("predictions")
            ->where("game_id", $gameId)
            ->count();

        return DB::table("predictions")
            ->select(
                "team_one_goals",
                "team_two_goals",
                DB::raw("COUNT(*) as prediction_count"),
                DB::raw(
                    "(COUNT(*) / " . $totalPredictions . ") * 100 as percentage"
                )
            )
            ->where("game_id", $gameId)
            ->groupBy("team_one_goals", "team_two_goals")
            ->orderByDesc("prediction_count")
            ->take(4)
            ->get();
    }

    public function index1()
    {
        // dd("inside");
        $games = Game::all();
        return response()->json(["status" => "success", "data" => $games], 200);
    }

    public function show($id)
    {
        $game = Game::findOrFail($id);
        return response()->json(["status" => "success", "data" => $game], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "team_one_id" => "integer",
            "team_two_id" => "integer",
            "game_type" => "string",
            "match_status" => "string",
            "kick_off_time" => "string",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => $validator->errors()->first(),
                ],
                400
            );
        }

        $game = Game::create($request->all());
        return response()->json(["status" => "success", "data" => $game], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "team_one_id" => "integer",
            "team_two_id" => "integer",
            "game_type" => "string",
            "match_status" => "string",
            "kick_off_time" => "string",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => $validator->errors()->first(),
                ],
                400
            );
        }

        $game = Game::findOrFail($id);
        $game->update($request->all());
        return response()->json(["status" => "success", "data" => $game], 200);
    }

    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();
        return response()->json(
            ["status" => "success", "message" => "Game deleted successfully"],
            200
        );
    }

    public function summary($userId)
    {
        try {
            $totalGames = Game::where(
                "game_type",
                "!=",
                "final-prediction"
            )->count();

            $predictedGamesCount = Prediction::where("user_id", $userId)
                ->whereHas("game", function ($query) {
                    $query->where("game_type", "!=", "final-prediction");
                })
                ->distinct("game_id")
                ->count("game_id");

            return response()->json(
                [
                    "status" => "success",
                    "data" => [
                        "total_games" => $totalGames,
                        "predicted_games" => $predictedGamesCount,
                    ],
                    "status_code" => 200,
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => $e->getMessage(),
                    "status_code" => 500,
                ],
                500
            );
        }
    }



    public function deleteUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::find($request->user_id);

        if ($user) {
            DB::transaction(function () use ($user) {
                // Delete user's predictions
                Prediction::where('user_id', $user->id)->delete();

                // Delete user's points
                Point::where('user_id', $user->id)->delete();

                // Delete the user
                $user->delete();
            });

            // Recalculate ranks after user deletion
            $this->assignRank();

            return response()->json([
                'status' => 200,
                'message' => 'User deleted successfully',
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'User not found',
        ]);
    }

    private function assignRank()
    {

        // Get all company_group_ids
        $companyGroupIds = User::select('company_group_id')->distinct()->pluck('company_group_id');

        foreach ($companyGroupIds as $companyGroupId) {
            // Retrieve users in this company group, sorted by total points descending
            $users = User::leftJoin('points', 'users.id', '=', 'points.user_id')
                ->select(
                    'users.id',
                    'users.company_group_id',
                    DB::raw('COALESCE(SUM(points.points), 0) as total_points')
                )
                ->where('users.company_group_id', $companyGroupId)
                ->where('users.verified', 1)
                ->groupBy('users.id', 'users.company_group_id')
                ->orderBy('total_points', 'desc')
                ->get();

            // Assign ranks
            $rank = 1;
            foreach ($users as $user) {
                $userModel = User::find($user->id);
                $userModel->old_rank = $userModel->new_rank;
                $userModel->new_rank = $rank;
                $userModel->save();

                $rank++;
            }
        }
    }
}
