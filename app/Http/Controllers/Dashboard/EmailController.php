<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\EmailExtension;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Prediction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{


    public function domain()
    {
        $emailExtensions = EmailExtension::all();
        return view('manage-domain',compact('emailExtensions'));
    }

    public function addDomain(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "company_group_id" => "integer",         
            "domain" => "string",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => $validator->errors()->first(),
                ],
                400
            );
        }

        $email = EmailExtension::create($request->all());
        
      //  return response()->json(["status" => "success", "data" => $email], 201);
        return redirect()->route('domain')->with('success', 'Domain added successfully');
     
    }


}
