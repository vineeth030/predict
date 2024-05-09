<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Version;
use Carbon\Carbon;

class VersionController extends Controller
{
    public function index()
    {

        $androidVersion = Version::where('platform', 'android')->first();
        $iosVersion = Version::where('platform', 'ios')->first();

        $androidName = Version::where('platform', 'android')->first();
        $iosName = Version::where('platform', 'ios')->first();

        $androidIsMandatory = Version::where('platform', 'android')->first();
        $iosIsMandatory = Version::where('platform', 'ios')->first();

        $androdIsQuarterStarted = Version::where('platform', 'android')->first();
        $iosIsQuarterStarted = Version::where('platform', 'ios')->first();

        $versions = Version::all();
        return view('versions', [
            'androidVersion' => $androidVersion ? $androidVersion->code : 'N/A',
            'iosVersion' => $iosVersion ? $iosVersion->code : 'N/A',

            'androidName' => $androidName ? $androidName->name : 'N/A',
            'iosName' => $iosName ? $iosName->name : 'N/A',

            'androidIsMandatory' => $androidIsMandatory ? $androidIsMandatory->is_mandatory : 'N/A',
            'iosIsMandatory' => $iosIsMandatory ? $iosIsMandatory->is_mandatory : 'N/A',

            'androdIsQuarterStarted' =>  $androdIsQuarterStarted ? $androdIsQuarterStarted->is_quarter_started : 'N/A',
            'iosIsQuarterStarted' => $iosIsQuarterStarted ? $iosIsQuarterStarted->is_quarter_started : 'N/A',

        ]);
    }

    public function updateversion(Request $request)
    {

        $kickoff_time = $request->input('kickoff_time');
      //  $kickoff_time = "2024-06-14 21:00";
       // dd($kickoff_time);
        $carbonDatetime = Carbon::parse($kickoff_time);
    
       // $utcDatetime = $carbonDatetime->utc();
        $milliseconds = $carbonDatetime->timestamp * 1000;
     // dd($milliseconds);

        $validated = $request->validate([
            'platform' => 'required|in:android,ios',
            'code' => 'required|string',
            'name' => 'required|string',
            'is_mandatory' => 'required|string',
          
        ]);

        //dd( $validated);

        // Update the version in the database, creating a new row if it does not exist
        Version::where('platform', $request->get('platform'))->update(

            [
                'code' => $validated['code'], // Values to update or insert
                'name' => $validated['name'], // Values to update or insert
                'is_mandatory' => $validated['is_mandatory'],
                'countdown_timer' => $milliseconds
            ] // Values to update or insert
        );

        // Redirect back with a success message
        return back()->with('success', 'Version updated successfully.');
    }
}
