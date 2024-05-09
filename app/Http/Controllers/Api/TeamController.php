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
}
