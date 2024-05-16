<?php

namespace App\Http\Controllers\Api;

use App\Models\Version;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VersionController extends Controller
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_OK = 200;
    public function index() {
        
        try {
            $versions = Version::all()->map(function ($version) {
                return [
                    'id' => $version->id,
                    'platform' => $version->platform,
                    'version_code' => $version->code,
                    'version_name' => $version->name,
                    'is_mandatory' => $version->is_mandatory,
                    'is_quarter_started' => $version->is_quarter_started,
                    'countdown_timer' => $version->countdown_timer,
                    'created_at' => $version->created_at,
                    'updated_at' => $version->updated_at,
                ];
            });
    
            return response()->json(['status' => 'success', 'status_code' => 200, 'data' => $versions], self::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
