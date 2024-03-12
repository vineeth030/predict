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
            $versions = Version::all();
            return response()->json(['status' => 'success', 'data' => $versions], self::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], self::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
