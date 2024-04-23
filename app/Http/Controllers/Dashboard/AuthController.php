<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function login(Request $request) : RedirectResponse {
       // dd("inside login");

        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if (auth()->attempt($credentials)) {
            return redirect('/games');
        }

        return redirect('/login')->with('errors', 'Invalid data given');
    }

    public function logout() : RedirectResponse {
        
        auth()->logout();

        return redirect('/login');
    }
}
