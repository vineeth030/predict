<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameCard;
use App\Models\GameNotification;
use App\Models\GameRedeemHistory;
use App\Models\GameRewardHistory;
use App\Models\GameStar;
use App\Models\GameUserCard;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            $game->update($request->only(['winning_team_id', 'team_one_goals', 'team_two_goals', 'first_goal_team_id']));
            $game->update(['match_status' => 'completed']);
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
            $firstGoalprediction = 0;


            if ($game->game_type !== 'final-prediction') {

                if ($game->winning_team_id == $prediction->winning_team_id) {
                    // Correct outcome prediction
                    $pointsEarned += 1;
                    $correctWinpredicted  += 1;
                }

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
            } else {
                //  dd("inside final-prediction");
                $userPrediction = [$prediction->final_team_one_id, $prediction->final_team_two_id];
                sort($userPrediction);
                // dd($userPrediction);
                $normalizedPrediction = implode(' vs ', $userPrediction);


                $actualWinningTeams = [$game->team_one_id, $game->team_two_id];
                sort($actualWinningTeams);


                $normalizedWinningTeam = implode(' vs ', $actualWinningTeams);

                if ($game->winning_team_id == $prediction->winning_team_id) {

                    $pointsEarned += 5;
                    $correctWinpredicted  = +5;
                    if ($normalizedPrediction === $normalizedWinningTeam) {

                        $pointsEarned += 5;
                    }
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
                    ->update([
                        'points' => $pointsEarned,
                        'win_prediction' => $correctWinpredicted,
                        'goal_prediction' => $correctGoalpredicted,
                        'first_goal_prediction' => $firstGoalprediction
                    ]);
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

            $this->awardPredictionCards($game, $prediction->user_id, $pointsEarned);
        }

        $this->assignRank();
    }

    private function awardPredictionCards(Game $game, int $userId, int $pointsEarned): void
    {
        if ($game->game_type === 'final-prediction' || $pointsEarned <= 0) {
            return;
        }

        $alreadyRewarded = GameNotification::where('user_id', $userId)
            ->where('notification_type', GameNotification::TYPE_CORRECT_PREDICTION)
            ->where('reference_id', $game->id)
            ->exists();

        if ($alreadyRewarded) {
            return;
        }

        $cardTypeGroups = $pointsEarned >= 5
            ? [['GOLD'], ['BRONZE', 'SILVER']]
            : [['BRONZE', 'SILVER'],['BRONZE', 'SILVER']];

        DB::transaction(function () use ($game, $userId, $cardTypeGroups) {
            $alreadyRewarded = GameNotification::where('user_id', $userId)
                ->where('notification_type', GameNotification::TYPE_CORRECT_PREDICTION)
                ->where('reference_id', $game->id)
                ->lockForUpdate()
                ->exists();

            if ($alreadyRewarded) {
                return;
            }

            foreach ($cardTypeGroups as $cardTypes) {
                $card = GameCard::whereIn('card_type', $cardTypes)
                    ->where('is_active', true)
                    ->inRandomOrder()
                    ->first();

                if (!$card) {
                    continue;
                }

                $reward = $this->awardPredictionCard($userId, $card);

                GameNotification::create([
                    'user_id' => $userId,
                    'notification_type' => GameNotification::TYPE_CORRECT_PREDICTION,
                    'reference_id' => $game->id,
                    'title' => 'Prediction Win!',
                    'message' => 'You guessed right! Your victory reward has been successfully added.',
                    'star_points' => $reward['star_points'],
                    'is_read' => false,
                ]);
            }
        });
    }

    private function awardPredictionCard(int $userId, GameCard $card): array
    {
        $userCard = GameUserCard::where('user_id', $userId)
            ->where('card_id', $card->id)
            ->lockForUpdate()
            ->first();

        if ($userCard) {
            $userCard->quantity += 1;
            $userCard->save();
            $userCard->refresh();
        } else {
            $userCard = GameUserCard::create([
                'user_id' => $userId,
                'card_id' => $card->id,
                'quantity' => 1,
                'first_obtained_at' => now(),
            ]);
        }

        $starPoints = $userCard->quantity > 1
            ? $this->starsForCardType($card->card_type)
            : 0;

        $gameStars = $this->getOrCreateUserStars($userId);

        if ($starPoints > 0) {
            $gameStars->stars_balance += $starPoints;
            $gameStars->save();
        }

        $reward = GameRewardHistory::create([
            'user_id' => $userId,
            'card_id' => $card->id,
            'quantity' => 1,
            'star_points' => $starPoints,
            'reward_source' => 'PREDICTION',
            'rewarded_at' => now(),
        ]);

        return [
            'reward' => $reward,
            'user_card' => $userCard,
            'star_points' => $starPoints,
        ];
    }

    private function starsForCardType(string $cardType): int
    {
        return match (strtoupper($cardType)) {
            'GOLD' => 5,
            'SILVER' => 3,
            default => 2,
        };
    }

    private function getOrCreateUserStars(int $userId): GameStar
    {
        $gameStars = GameStar::where('user_id', $userId)
            ->lockForUpdate()
            ->first();

        if ($gameStars) {
            return $gameStars;
        }

        return GameStar::create([
            'user_id' => $userId,
            'stars_balance' => $this->calculateInitialStarsBalance($userId),
        ]);
    }

    private function calculateInitialStarsBalance(int $userId): int
    {
        $earnedStars = (int) GameRewardHistory::where('user_id', $userId)->sum('star_points');
        $redeemedStars = (int) GameRedeemHistory::where('user_id', $userId)->sum('stars_used');

        return max($earnedStars - $redeemedStars, 0);
    }

    /*    private function assignRank()
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
    }*/
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
            // Initialize rank variables
            $rank = 1;
            $previousPoints = null;
            $adjustedRank = 1;

            foreach ($users as $user) {
                $userModel = User::find($user->id);

                // Set old rank to current new rank before updating
                $userModel->old_rank = $userModel->new_rank;

                // If the current user's points are the same as the previous user's points, they share the same rank
                if ($previousPoints !== null && $user->total_points == $previousPoints) {
                    $userModel->new_rank = $adjustedRank;
                } else {
                    $userModel->new_rank = $rank;
                    $adjustedRank = $rank;
                }

                // Save updated rank in the User model
                $userModel->save();

                // Update previous points and increment rank
                $previousPoints = $user->total_points;
                $rank++;
            }
        }
    }







    public function edit()
    {
        return view('edit-games');
    }

    public function manage(Request $request)
    {

        $game = Game::create($request->all());

        return redirect()->route('edit')->with('success', 'Game added successfully');
    }

    public function delete(Request $request)
    {

        // dd("inside");
        $request->validate([
            'game_id' => 'required|integer|exists:games,id',
        ]);

        $game = Game::find($request->game_id);
        if ($game) {
            $game->delete();
            return redirect()->route('edit')->with('success', 'Game deleted successfully');
        }

        return redirect()->route('edit')->with('error', 'Game not found');
    }

    public function editgame(Request $request)
    {

        $game = Game::findOrFail($request->game_id);
        $game->team_one_id = $request->input('team_one_id');
        $game->team_two_id = $request->input('team_two_id');
        $game->winning_team_id = $request->input('winning_team_id');
        $game->first_goal_team_id = $request->input('first_goal_team_id');
        $game->game_type = $request->input('game_type');
        $game->match_status = $request->input('match_status');
        $game->stadium_name = $request->input('stadium_name');
        $game->kick_off_time = $request->input('kick_off_time');
        $game->save();

        return redirect()->route('edit')->with('success', 'Game editted successfully');
    }

    public function deleteUser(Request $request)
    {
        dd("inside delete");
    }
}
