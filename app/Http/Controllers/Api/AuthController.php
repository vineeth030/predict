<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function register(Request $request) : JsonResponse {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json($user);
    }

    public function login(Request $request) : JsonResponse {
        
        // Steps to setup beo system login.

        // 1. Do laravel validation and attempt login.
        // 2. If it fails, Use deviceId, accessId, blockId, firebaseId and send request to BEO login api and get sessionToken as response.
        // 3. If error is "device not registered", register device with device register API.
        // 4. If error is "invalid credentials", return error message.
        // 5. If success, Use sessionToken, userIdCode and send request to userInfo api and get user details.
        // 6. Store user details in users table.

        //return response()->json($request->all());

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['username', 'password']);

        $user = User::where('username', $request->username)->first();

        if (!auth()->attempt($credentials)) {

            if (!$user) {
                
                return response()->json(
                    $this->loginWithBEOSystem($request->deviceId, $request->username, $request->password)
                );
            }

            return response()->json([
                'message' => 'Invalid data given',
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }

        $user = User::where('username', $request->username)->first();

        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'access_token' => $authToken
        ]);
    }

    private function loginWithBEOSystem (string $deviceId, string $username, string $password) : JsonResponse {
        
        $queryParams = ['deviceId' => $deviceId];

        $bodyParams = [
            'accessId' => base64_encode(openssl_encrypt($username, 'AES-256-CBC', env('BEO_SYSTEM_KEY'), OPENSSL_RAW_DATA, env('BEO_SYSTEM_IV_KEY'))),
            'blockId' => "NDLMeYI/f+rOCIHRbNlcCQ==",//base64_encode(openssl_encrypt($password, 'AES-256-CBC', env('BEO_SYSTEM_KEY'), OPENSSL_RAW_DATA, env('BEO_SYSTEM_IV_KEY'))),
            'firbaseId' => '8clXcfbqdkY77N'
        ];

        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://5.9.218.202/beosystem/api/Login/UserLoginForMobApp?deviceId=861e4f17-230d-48a4-9ce3-98fedc72666a', $bodyParams, $queryParams);

        $body = $response->object();

        // Log::info("Fine so far.", [
        //     $body->sessionToken, $body->userIdCode
        // ]);

        $this->httpRequestToBEOSystemUserDetailsApi($body->sessionToken, $body->userIdCode);

        //Log::info('Data for API: ', [mb_convert_encoding(openssl_encrypt($username, 'AES-256-CBC', env('BEO_SYSTEM_KEY'), OPENSSL_RAW_DATA, env('BEO_SYSTEM_IV_KEY')), "UTF-8", "auto")]);

        return response()->json(true);
        
        // $bodyParams = [
        //     'accessId' => 'Jzzdw4xrEMih45U/Q4KCog==',
        //     'blockId' => 'NDLMeYI/f+rOCIHRbNlcCQ==',
        //     'firbaseId' => '8clXcfbqdkY77N'
        // ];
    }

    private function httpRequestToBEOSystemLoginApi(string $deviceId, string $accessId, string $blockId, string $firebaseId) {
        // TODO : Use deviceId, accessId, blockId, firebaseId and send request to BEO login api and get sessionToken as response.

    }

    private function httpRequestToBEOSystemUserDetailsApi(string $sessionToken, string $userIdCode) {
        // TODO : Use sessionToken, userIdCode and send request to userInfo api and get user details.

        $queryParams = ['sessionToken' => $sessionToken];

        $bodyParams = ['userIdCode' => $userIdCode];

        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false,
        ])->post("http://5.9.218.202/beosystem/api/Login/UserInfoForMobApp?sessionToken=$sessionToken", $bodyParams, $queryParams);

        $body = $response->object();

        Log::info("Fine so far.", [
            $body->firstName, $body->lastName, $body->designation
        ]);
    }

    private function httpRequestToBEOSystemDeviceRegisterApi(string $userToken, string $userIdCode) {
        // TODO : Use device register API.
    }
}
