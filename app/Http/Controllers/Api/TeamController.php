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
    public function index()
    {

        try {
            $result = [
                "status" =>  200,
                "message" => "Success",
                "standings" => [],
                'testKey' => 'arsnteio12345'
            ];

            $teams = DB::table('teams')->orderBy('points', 'asc')->get()->groupBy('group_id');

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
                    //  'id' => $version->id,
                    //  'version_code' => $version->code,
                    //  'version_name' => $version->name,
                    //   'is_mandatory' => $version->is_mandatory,
                    'is_quarter_started' => $version->is_quarter_started,
                    'is_round16_completed' => $version->is_round16_completed,
                    'eu_start_date' => $version->countdown_timer,
                    'eu_end_date' => $version->wc_end_date,
                    'winner' => $version->winner,

                ];
            })->first(); // Get the first (or latest) item




            $teams = [
                ['id' => 1, 'name' => 'Germany'],
                ['id' => 5, 'name' => 'Spain'],
                ['id' => 12, 'name' => 'England'],
                ['id' => 14, 'name' => 'Netherlands'],
                ['id' => 20, 'name' => 'Ukraine'],
                ['id' => 7, 'name' => 'Italy'],
                ['id' => 6, 'name' => 'Croatia'],
                ['id' => 16, 'name' => 'France']
            ];

            return response()->json([
                'message' => 'success',
                'status' => 200,
                'finalist_teams' => $teams,
                'app_data' => $latestAndroidVersion,
                // 'ios' => $latestIosVersion,


            ], self::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
