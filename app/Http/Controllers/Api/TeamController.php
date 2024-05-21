<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_OK = 200;
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


        try {
            // Fetch all versions
            $versions = Version::all();
    
            // Get the latest version for Android
            $latestAndroidVersion = $versions->filter(function ($version) {
                return $version->platform === 'android';
            })->map(function ($version) {
                return [
                    'id' => $version->id,
                    'version_code' => $version->code,
                    'version_name' => $version->name,
                    'is_mandatory' => $version->is_mandatory,
                    'is_quarter_started' => $version->is_quarter_started,
                    'is_round16_completed' => $version->is_round16_completed,
                    'eu_start_date' => $version->countdown_timer,
                    'eu_end_date' => $version->wc_end_date,
                    'winner' => $version->winner,
                    'created_at' => $version->created_at,
                    'updated_at' => $version->updated_at,
                ];
            })->first(); // Get the first (or latest) item
    
            // Get the latest version for iOS
            $latestIosVersion = $versions->filter(function ($version) {
                return $version->platform === 'ios';
            })->map(function ($version) {
                return [
                    'id' => $version->id,
                    'version_code' => $version->code,
                    'version_name' => $version->name,
                    'is_mandatory' => $version->is_mandatory,
                    'is_quarter_started' => $version->is_quarter_started,
                    'is_round16_completed' => $version->is_round16_completed,
                    'eu_start_date' => $version->countdown_timer,
                    'eu_end_date' => $version->wc_end_date,
                    'winner' => $version->winner,
                    'created_at' => $version->created_at,
                    'updated_at' => $version->updated_at,
                ];
            })->first(); // Get the first (or latest) item
       //     $countdownTimer = $versions->first()->countdown_timer ?? null;


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
    
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
               
                'android' => $latestAndroidVersion,
                'ios' => $latestIosVersion,
                'finalist_teams' => $teams,
            
            ], self::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    




}
