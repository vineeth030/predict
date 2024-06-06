<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CardsGame;


class ProfileController extends Controller
{
    /*   public function update(Request $request)
    {
        //  dd("inside profile");

        // Validate the request data
        $validator = Validator::make($request->all(), [
             'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'fav_team' => 'nullable|string|max:255',

            // 'employee_id' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);


        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle profile picture upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageName, 'public');
            // Update the user's profile picture path in the database
            /** @var \App\Models\User $user **/
    /*     $user = auth()->user();
            $user->image = $imageName;
            $user->save();
        }

        try {
            $user = auth()->user();
              /** @var \App\Models\User $user **/
    /*     $user->designation = $request->input('designation');
            $user->name = $request->input('name');
            $user->fav_team = $request->input('fav_team');
            $user->save();
        
            // Handle other updates or actions if needed
        
            return response()->json(['message' => 'Profile updated successfully','status' =>200]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(),'status' =>500]);
        }
    }   */

    public function update(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'designation' => 'nullable|string|max:255',
                'fav_team' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            ]);

            // Check if the validation fails
            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray())->status(422);
            }

            // Handle profile picture upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('profile_images', $imageName, 'public');
            }

            // Update the user's profile
            $user = auth()->user();
            $user->name = $request->input('name');
            $user->designation = $request->input('designation');
            $user->fav_team = $request->input('fav_team');

            if (isset($imageName)) {
                $user->image = $imageName;
            }
            /** @var \App\Models\User $user **/
            $user->save();

            return response()->json(['message' => 'Profile updated successfully', 'status' => 200]);
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



    public function profile(Request $request)
    {


        $user = $request->user();
        $userId = $user->id;

        $imageUrl = $user->image ? asset('storage/profile_images/' . $user->image) : null;



        $cardsGame = CardsGame::where('user_id', $userId)->first();
        $starsCollected = 0;
        if ($cardsGame && !is_null($cardsGame->cards_opened)) {
            $starsCollected = substr_count($cardsGame->cards_opened, ',') + 1;
        }
        $rankChange = (int) $user->new_rank - (int) $user->old_rank;
        $rankChangeMessage = $rankChange > 0 ? '+1' : ($rankChange < 0 ? '-1' : '0');

        $userData = $user->toArray();
        $userData['image_url'] = $imageUrl;
        $userData['stars_collected'] = $starsCollected;
        $userData['rank_change'] = $rankChangeMessage;



        return response()->json(['message' => 'success', 'status' => 200, 'data' => $userData]);
    }

    public function changePassword(Request $request)
    {


        //   dd(request()->all());
        try {
            $user = Auth::user();

            // Validate input
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|string',
                'new_password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 400, 'message' => $validator->errors()->first()], 400);
            }

            // Check if the old password is correct
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['status' => 400, 'message' => 'Old password is incorrect'], 400);
            }

            // Check if the new password is different from the old password
            if (Hash::check($request->new_password, $user->password)) {
                return response()->json(['status' => 400, 'message' => 'New password cannot be the same as the old password'], 400);
            }
            /** @var \App\Models\User $user **/
            // Update the password
            $user->password = bcrypt($request->new_password);
            $user->save();

            return response()->json(['status' => 200, 'message' => 'Password updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()], 500);
        }
    }
}
