<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;


class QuestionController extends Controller
{

    public function questions()
    {       
        $questions = Question::all();
        return response()->json(['status' => 200, 'message' => 'success', 'data' => $questions]);
    }
}
