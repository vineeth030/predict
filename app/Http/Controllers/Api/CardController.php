<?php

namespace App\Http\Controllers\Api;

use App\Models\CardsGame;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;


class CardController extends Controller
{


    public function cardsGame(Request $request)
    {

        try {
            $userId = $request->input('user_id');
            $questionsAsked = $request->input('questions_asked');
            $cardsOpened = $request->input('cards_opened');
            $isQuestionOpened = $request->input('is_question_opened');

            $currentDate = Carbon::now();
            $currentDateFormatted = $currentDate->toDateString();


            $cardsGame = CardsGame::where('user_id', $userId)
                ->first();

            $isSameDay = CardsGame::where('user_id', $userId)
                ->whereDate('last_attended', $currentDateFormatted)
                ->first();

            if (!$cardsGame) {


                CardsGame::create([
                    'user_id' => $userId,
                    'questions_asked' => $questionsAsked,
                    'cards_opened' => $cardsOpened,
                    'last_attended' => $currentDate,
                    'is_question_opened' => 1
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Entry created successfully.',
                ]);
            } else {
                if (!$isSameDay) {
                    $cardsGame->update([
                        'questions_asked' => $questionsAsked,
                        'cards_opened' => $cardsOpened,
                        'last_attended' => $currentDate,
                        'is_question_opened' => $isQuestionOpened
                    ]);

                    return response()->json([
                        'status' => 200,
                        'message' => 'Entry updated successfully.',
                    ]);
                } else {
                    if ($cardsGame->is_question_opened && !$isQuestionOpened) {
                        $cardsGame->update([
                            'questions_asked' => $questionsAsked,
                            'cards_opened' => $cardsOpened,
                            'last_attended' => $currentDate,
                            'is_question_opened' => $isQuestionOpened
                        ]);

                        return response()->json([
                            'status' => 200,
                            'message' => 'Entry updated successfully.',
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Entry rejected: Question Viewed today.',
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function fetchCards(Request $request)
    {

        $userId = $request->input('user_id');
        $currentDate = Carbon::now();

        $cardsGame = CardsGame::where('user_id', $userId)->first();

        if (!$cardsGame) {
            return response()->json([
                'status' => 200,
                'user_id' =>  null,
                'questions_asked' => null,
                'cards_opened' => null,
                'server_time' => $currentDate->timestamp * 1000,
            ]);
        }

        $lastAttended = Carbon::parse($cardsGame->last_attended);
        $isSameDay = $lastAttended->isSameDay($currentDate);

        return response()->json([
            'status' => 200,
            'user_id' => $cardsGame->user_id,
            'questions_asked' => $cardsGame->questions_asked,
            'cards_opened' => $cardsGame->cards_opened,
            'server_time' => $currentDate->timestamp * 1000,
            'is_same_day' => $isSameDay,
        ]);
    }
}
