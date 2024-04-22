<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class LabController extends Controller
{
    public function sendRequest() : Response {
        
        $queryParams = [
            'deviceId' => '861e4f17-230d-48a4-9ce3-98fedc72666a',
        ];

        $bodyParams = [
            'accessId' => 'Jzzdw4xrEMih45U/Q4KCog==',
            'blockId' => 'NDLMeYI/f+rOCIHRbNlcCQ==',
            'firbaseId' => '8clXcfbqdkY77N'
        ];

        // $bodyParams = [
        //     'accessId' => "Jzzdw4xrEMih45U/Q4KCog==",
        //     'blockId' => "NDLMeYI/f+rOCIHRbNlcCQ==",
        //     'firbaseId' => '8clXcfbqdkY77N'
        // ];
        //base64_encode(openssl_encrypt($username, 'AES-256-CBC', env('BEO_SYSTEM_KEY'), OPENSSL_RAW_DATA, env('BEO_SYSTEM_IV_KEY'))),

        return Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://5.9.218.202/beosystem/api/Login/UserLoginForMobApp?deviceId=861e4f17-230d-48a4-9ce3-98fedc72666a', $bodyParams, $queryParams);
    }
}
