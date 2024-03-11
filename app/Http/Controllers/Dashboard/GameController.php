<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index() : View {
        
        return view('games', [
            'games' => Game::all()
        ]);
    }

    public function update() : View {
        // TODO: Implement update() method.

        return view('games', [
            'games' => Game::all()
        ]);
    }
}
