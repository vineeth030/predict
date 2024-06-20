<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::paginate(50); // 10 users per page
        return view('users', compact('users'));
    }
}
