<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index(){
        
        try {
            $result = [
                "status" =>  200,
                "message" => "Success",
                "standings" => [],
                'testKey' => 'arsnteio12345'
            ];

            $teams = DB::table('teams')->orderBy('points', 'desc')->get()->groupBy('group_id');
           
            foreach ($teams as $key => $team) {
                $result["standings"][] = ['group_id' => $key, 'table' => $team];
            }

            return response()->json($result, 200);

        } catch (\Exception $e) {

            return response()->json("Error", 400);
        }
    }

public function finalTeams() 
{

 // Simulated data for demonstration purposes
 $teams = [
    ['id' => 1, 'name' => 'Team A'],
    ['id' => 2, 'name' => 'Team B'],
    ['id' => 3, 'name' => 'Team C'],
    ['id' => 4, 'name' => 'Team D'],
    ['id' => 5, 'name' => 'Team E'],
    ['id' => 6, 'name' => 'Team F'],
    ['id' => 7, 'name' => 'Team G'],
    ['id' => 8, 'name' => 'Team H']
];

//return response()->json($teams);

return response()->json(['status' => 200, 'data' => $teams]);

}

}
