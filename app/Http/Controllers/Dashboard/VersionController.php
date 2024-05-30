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

        $androidWinner = Version::where('platform', 'android')->first();
        $iosWinner = Version::where('platform', 'ios')->first();


        $androdIsQuarterStarted = Version::where('platform', 'android')->first();
        $iosIsQuarterStarted = Version::where('platform', 'ios')->first();

        $androdisRound16Completed = Version::where('platform', 'android')->first();
        $iosisRound16Completed = Version::where('platform', 'ios')->first();

        $androidEuroStartDate = Version::where('platform', 'android')->first();
        $iosEuroStartDate = Version::where('platform', 'android')->first();

        $androidEuroEndDate = Version::where('platform', 'android')->first();
        $iosEuroEndDate = Version::where('platform', 'android')->first();




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

            'androdisRound16Completed' =>  $androdisRound16Completed ? $androdisRound16Completed->is_round16_completed : 'N/A',
            'iosisRound16Completed' => $iosisRound16Completed ? $iosisRound16Completed->is_round16_completed : 'N/A',

            'androidWinner' => $androidWinner ? $androidWinner->winner : 'N/A',
            'iosWinner' => $iosWinner ? $iosWinner->winner : 'N/A',


            'androdEuroStartDate' => $androidEuroStartDate ? $androidEuroStartDate->countdown_timer : 'N/A',
            'iosEuroStartDate' => $iosEuroStartDate ? $iosEuroStartDate->countdown_timer : 'N/A',

            'androdEuroEndDate' => $androidEuroEndDate ? $androidEuroEndDate->wc_end_date : 'N/A',
            'iosEuroEndDate' => $iosEuroEndDate ? $iosEuroEndDate->wc_end_date : 'N/A',


        ]);
    }

    public function updateversion(Request $request)
    {

        // $eu_start_date = $request->input('eu_start_date');
        // $euStartDate = Carbon::parse($eu_start_date);
        // $wc_start_date = $euStartDate->timestamp * 1000;




        // $eu_end_date = $request->input('eu_end_date');
        // $euEndDate = Carbon::parse($eu_end_date);
        // $wc_end_date = $euEndDate->timestamp * 1000;

      
        //dd('uuu');

        $validated = $request->validate([
            'platform' => 'required|in:android,ios',
            'code' => 'required|string',
            'name' => 'required|string',
            'is_mandatory' => 'required|string',
            'is_round16_completed' => 'required|string',
            'is_quarter_started' => 'required|string',
            'eu_start_date' => 'required|string',
            'eu_end_date' => 'required|string',


        ]);



       

        // Update the version in the database, creating a new row if it does not exist
        Version::where('platform', $request->get('platform'))->update(

            [
                'code' => $validated['code'], // Values to update or insert
                'name' => $validated['name'], // Values to update or insert
                'is_mandatory' => $validated['is_mandatory'],
                'is_round16_completed' => $validated['is_round16_completed'],
                'is_quarter_started' => $validated['is_quarter_started'],
                'winner' => $request->winner,
                'countdown_timer' =>  $validated['eu_start_date'],
                'wc_end_date' =>  $validated['eu_end_date'],
            ] // Values to update or insert
        );

        // Redirect back with a success message
        return back()->with('success', 'Version updated successfully.');
    }
}
