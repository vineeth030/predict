<?php

namespace App\Http\Controllers\Api;

use App\Models\Version;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VersionController extends Controller
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_OK = 200;
    public function index()
    {
        try {
            // Fetch all versions
            $versions = Version::all();

         //  dd($versions);

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
                ];
            })->first(); // Get the first (or latest) item
            //     $countdownTimer = $versions->first()->countdown_timer ?? null;




            return response()->json([
                'message' => 'success',
                'status' => 200,

                'android' => $latestAndroidVersion,
                'ios' => $latestIosVersion,


            ], self::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
