<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordEmail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\EmailExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    'unique:users,email', // Check if the email is unique
                    // Custom rule to check if the email exists in the database
                    function ($attribute, $value, $fail) {
                        $user = User::where('email', $value)->first();
                        // if ($user) {
                        //     $fail('The email has already been taken.');
                        // }
                        
                        if($user && !$user->verified){
                            throw ValidationException::withMessages(['email' => 'The email has already been registered but not verified.'])->status(300);
                        }
                    },
                ],
                'password' => 'required|min:6',
               // 'company_group_id' => 'required',
            ]);



            // Check if the validation fails
            if ($validator->fails()) {
                // Throw a ValidationException with custom error code
                throw ValidationException::withMessages($validator->errors()->toArray())->status(422);
            }

            $emailDomain = substr(strrchr($request->email, "@"), 1);
            $emailExtension = EmailExtension::where('domain', $emailDomain)->first();
            if (!$emailExtension) {
               // return response()->json(['message' => 'Invalid Email.', 'status' => 400], 400);
               $emailExtension = EmailExtension::create(['domain' => $emailDomain, 'company_group_id' => $this->generateCompanyGroupId($emailDomain)]);

            }

            // Generate and send OTP
            $otp = mt_rand(100000, 999999); // Generate a 6-digit OTP

            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'company_group_id' => $emailExtension->company_group_id,
                'password' => bcrypt($request->password),
                'otp' => $otp,
            ]);

            // Send OTP to the user's email
            Mail::to($request->email)->send(new VerifyEmail($otp));

            // Return a JSON response indicating success
            return response()->json(['message' => 'OTP sent to your email', 'status' => 200]);
        } catch (ValidationException $e) {
            // Return the error response with custom error code
            // return response()->json(['errors' => $e->errors(), 'code' => $e->status], $e->status);
            // Get the validation errors from the exception
            $errors = $e->validator->errors()->toArray();
            // dd($errors);

            // Get the first error message
            $errorMessage = Arr::first($errors);

            // Return the error response with custom error code
            $response = [
                'message' => $errorMessage[0],
                'status' => $e->status,
            ];
            return response()->json($response, $e->status);
        }
    }

    private function generateCompanyGroupId($emailDomain)
    {
        $nextCompanyGroupId = EmailExtension::max('company_group_id') + 1;


        $emailExtension = EmailExtension::create([
            'domain' => $emailDomain,
            'company_group_id' => $nextCompanyGroupId,
        ]);
       // return uniqid();
    }

    public function login(Request $request): JsonResponse
    {
        try {
            // Validate the request data
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Check if the email exists in the database
            $user = User::where('email', $request->email)->first();
            if (!$user) {
              
                throw ValidationException::withMessages(['error' => 'Email is not registered.'])->status(422);
            }

            // Attempt to authenticate the user
            $credentials = $request->only('email', 'password');
            if (auth()->attempt($credentials)) {
                // Check if the email is verified
                if ($user->verified) {
                    // Generate an access token
                    $authToken = $user->createToken('auth-token')->plainTextToken;

                    // Return the access token in the response
                    return response()->json(['access_token' => $authToken, 'status' => 200, 'user_id' => $user->id, 'result' => "Login Success",]);
                } else {
                    // Log out the user if email is not verified
                    auth()->logout();
                    return response()->json(['message' => 'Email not verified', 'status' => 401]);
                }
            } else {
                // Return an error response if authentication fails
                throw ValidationException::withMessages(['error' => 'The provided password is incorrect.', 'status' => 422]);
            }
        } 
        catch (ValidationException $e) {
            // Return the error response with custom error messages and status code
            $errorMessage = $e->errors()['error'][0];
            $statusCode = $e->status;
            return response()->json(['result' => $errorMessage, 'status' => $statusCode], $statusCode);
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
          //  $this->assignRank($user->company_group_id);

            // Return a success response
            return response()->json(['message' => 'OTP verified successfully','status' => 200], 200);
        }

        // Return an error response if user with the given email and OTP is not found
        return response()->json(['message' => 'Invalid OTP','status' => 400], 400);
    }



    private function assignRank($companyGroupId)
    {

        // Retrieve users in this company group, sorted by total points descending
        $users = User::leftJoin('points', 'users.id', '=', 'points.user_id')
            ->select(
                'users.id',
                'users.company_group_id',
                DB::raw('COALESCE(SUM(points.points), 0) as total_points')
            )
            ->where('users.company_group_id', $companyGroupId)
            ->where('users.verified', 1)
            ->groupBy('users.id', 'users.company_group_id')
            ->orderBy(DB::raw('CAST(total_points as UNSIGNED)'), 'desc')
            ->get();
    
        // Initialize rank variables
        $rank = 1;
        $previousPoints = null;
        $adjustedRank = 1;
    
        foreach ($users as $user) {
            $userModel = User::find($user->id);
    
            // Set old rank to current new rank before updating
            $userModel->old_rank = $userModel->new_rank;
    
            // If the current user's points are the same as the previous user's points, they share the same rank
            if ($previousPoints !== null && $user->total_points == $previousPoints) {
                $userModel->new_rank = $adjustedRank;
            } else {
                $userModel->new_rank = $rank;
                $adjustedRank = $rank;
            }
    
            // Save updated rank in the User model
            $userModel->save();
    
            // Update previous points and increment rank
            $previousPoints = $user->total_points;
            $rank++;
        }
    }
    



    public function resendOtp(Request $request): JsonResponse
    {
        try {

            // dd("inside resend otp");
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            // Check if the validation fails
            if ($validator->fails()) {
                // Throw a ValidationException with custom error code
                throw ValidationException::withMessages($validator->errors()->toArray())->status(422);
            }

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            // If user not found, return error response
            if (!$user) {
                return response()->json(['message' => 'User not found','status' => 404]);
            }

            // Generate a new OTP
            $otp = mt_rand(100000, 999999);

            // Update user's OTP
            $user->otp = $otp;
            $user->save();

            // Send OTP to the user's email
            Mail::to($user->email)->send(new VerifyEmail($otp));

            // Return success response
            return response()->json(['message' => 'OTP sent to your email','status' => 200], 200);
        } catch (ValidationException $e) {
            // Return the error response with custom error code
            $errors = $e->validator->errors()->toArray();
            // dd($errors);

            // Get the first error message
            $errorMessage = Arr::first($errors);

            // Return the error response with custom error code
            $response = [
                'message' => $errorMessage[0],
                'status' => $e->status,
            ];
            return response()->json($response, $e->status);
        }
    }


    public function forgotPassword(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);
    
            // Check if the email exists in the database
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                throw ValidationException::withMessages(['email' => 'This email does not exist in our records.']);
            }
    
            // Generate OTP
            $otp = rand(100000, 999999);
    
            // Store the OTP in the database
            $user->password_reset_otp = $otp;
            $user->save();
    
            // Send the OTP to the user's email
            Mail::to($request->email)->send(new ForgotPasswordEmail($otp));
    
            // Return a response indicating success
            return response()->json(['message' => 'OTP sent to your email','status' => 200], 200);
        } catch (\Exception $e) {
            // Handle any exceptions, such as mail sending failures
            return response()->json(['message' => $e->getMessage(),'status'=>500], 500);
        }
    }

    public function resetPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6',
        ]);

        // Check if the OTP matches the one stored in the database
        $user = User::where('email', $request->email)
            ->where('password_reset_otp', $request->otp)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid OTP','status' => 422], 422);
        }

        // Update the user's password
        $user->password = bcrypt($request->password);
        $user->save();

        // Clear the OTP
        $user->password_reset_otp = null;
        $user->save();

        // Return a response indicating success
        return response()->json(['message' => 'Password reset successfully','status' => 200], 200);
    }
}
