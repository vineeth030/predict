<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index() : View {
        
        return view('teams', [
            'teams' => \App\Models\Team::all()
        ]);
    }

    public function update() : View {
        
        // TODO: Implement update() method.

        return view('teams', [
            'teams' => \App\Models\Team::all()
        ]);
    }
}
