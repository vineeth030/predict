<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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

        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid data given',
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'access_token' => $authToken
        ]);
    }

    private function loginToBEOSystem(string $deviceId, string $accessId, string $blockId, string $firebaseId) {
        // TODO : Use deviceId, accessId, blockId, firebaseId and send request to BEO login api and get sessionToken as response.
    }

    private function getUserDetailsFromBEOSystem(string $sessionToken, string $userIdCode) {
        // TODO : Use sessionToken, userIdCode and send request to userInfo api and get user details.
    }

    private function registerDeviceToBEOSystem(string $userToken, string $userIdCode) {
        // TODO : Use device register API.
    }
}
