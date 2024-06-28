<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Feedback;
use App\Models\Question;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class FeedbackController extends Controller
{

    public function index(Request $request)

    {
        $feedbacks = DB::table('feedback')
            ->join('questions', 'feedback.question_id', '=', 'questions.id')
            ->select('feedback.user_id', 'feedback.user_name', 'questions.question', 'feedback.answer','feedback.created_at','feedback.updated_at')->orderBy('feedback.updated_at', 'desc')
            ->get();

        return view('feedback', compact('feedbacks'));
    }



    public function feedback(Request $request)
    {

        try {

            $userId = $request->input('user_id');
            $feedback = Feedback::where('user_id', $userId)
                ->first();
            if ($feedback) {

                $data = $request->input('data');

                $questionId = $data[0]['question_id'];
                $answer = $data[0]['answer'];

                $feedback = Feedback::where('user_id', $userId)->where('question_id', $questionId)->first();
                $feedback->where('user_id',$userId)->where('question_id', $questionId)->update([

                    'answer' => $answer . " | " . $feedback->answer,
                ]);
                return response()->json(['status' => 200, 'message' => 'Feedback submitted successfully'], 200);
            } else {
                $request->validate([
                    'user_id' => 'required|integer',
                    'user_name' => 'required|string',
                    'data' => 'required|array',
                    'data.*.question_id' => 'required|integer',
                    'data.*.answer' => 'required|string',

                ]);

                $userId = $request->input('user_id');
                $userName = $request->input('user_name');
                $data = $request->input('data');

                foreach ($data as $feedbackData) {
                    Feedback::create([
                        'user_id' => $userId,
                        'user_name' => $userName,
                        'question_id' => $feedbackData['question_id'],
                        'answer' => $feedbackData['answer'],
                    ]);
                }

                return response()->json(['status' => 200, 'message' => 'Feedback submitted successfully'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()],);
        }
    }
}
