<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request) : JsonResponse {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'company_group_id' => 'required'
        ]);

        $validatedData = $request->validate([         
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password' => 'required|min:6',
            'company_group_id' => 'required'
            // Add more validation rules as needed
        ]);
    
        // Check if the validation fails
     /*   if ($validator->fails()) {
            // Return validation errors as JSON response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_group_id' => $request->company_group_id,
            'password' => bcrypt($request->password)
        ]);

        return response()->json($user);  */

  // Generate and send OTP
  $otp = mt_rand(100000, 999999); // Generate a 6-digit OTP


  $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'company_group_id' => $request->company_group_id,
    'password' => bcrypt($request->password),
    'otp' => $otp,
]);


  
  Mail::to($request->email)->send(new VerifyEmail($otp));

  // Store OTP in session or database (not shown here)

  // Return a JSON response indicating success
  return response()->json(['message' => 'OTP sent to your email'], 200);


    }

    public function login(Request $request) : JsonResponse {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if (auth()->attempt($credentials)) {
         

            if (auth::user()->verified) {
              
                // If email is verified, redirect the user to the intended page or return a success response
                $user = User::where('email', $request->email)->first();

                $authToken = $user->createToken('auth-token')->plainTextToken;
        
                return response()->json([
                    'access_token' => $authToken
                ]);
            } else {
                // If email is not verified, log out the user and return an error response
                auth::logout();
                return response()->json(['error' => 'Email not verified'], 401);
            }  

        }
    }


    public function verifyOtp(Request $request)
    {
     
      
  
       // Validate the incoming request data
       $validatedData = $request->validate([
        'email' => 'required|string|email|max:255',
        'otp' => 'required|string|max:6', // Assuming OTP is a string of maximum 6 characters
    ]);

    // Find the user by email and OTP
    $user = User::where('email', $validatedData['email'])
                ->where('otp', $validatedData['otp'])
                ->first();

    // Check if user with the given email and OTP exists
    if ($user) {
        // Update user status or perform any other actions as needed
        $user->update(['verified' => true]); // Example: Mark user as verified

        // Return a success response
        return response()->json(['message' => 'OTP verified successfully'], 200);
    }

    // Return an error response if user with the given email and OTP is not found
    return response()->json(['error' => 'Invalid OTP'], 400);
}
       
    }


