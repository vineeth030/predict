<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Team;

class TeamController extends Controller
{
    public function index() : View {
        
        return view('teams', [
            'teams' => \App\Models\Team::all()
        ]);
    }

    public function update(Request $request)
    {

        try {

            $validatedData = $request->validate([
                'teams.*.points' => 'integer',
                'teams.*.games_played' => 'integer',
                'teams.*.wins' => 'integer',
                'teams.*.draws' => 'integer',
                'teams.*.losses' => 'integer',
                'teams.*.GF' => 'integer',
                'teams.*.GD' => 'integer',
                'teams.*.GA' => 'integer',
            ]);

            // Update standings data based on form input
            foreach ($validatedData['teams'] as $teamid => $data) {

              
                $team = Team::findOrFail($teamid);
                $team->update($data);
            }

            return redirect()->route('teams.index')->with('success', 'Standings updated successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('teams.index')->with('error', 'Failed to update standings. ' . $e->getMessage());
        }
    }
       
    }
