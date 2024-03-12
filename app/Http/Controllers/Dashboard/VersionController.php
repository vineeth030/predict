<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index() {
        
        return view('versions', [
            'versions' => \App\Models\Version::all()
        ]);
    }
}
