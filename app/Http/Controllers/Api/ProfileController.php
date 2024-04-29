<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
    public function update(Request $request)
    {
        //  dd("inside profile");

        // Validate the request data
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
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
            $user = auth()->user();
            $user->image = $imageName;
            $user->save();
        }

        try {
            $user = auth()->user();
              /** @var \App\Models\User $user **/
            $user->designation = $request->input('designation');
            $user->save();
        
            // Handle other updates or actions if needed
        
            return response()->json(['message' => 'Profile updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function profile(Request $request)
    {
        //dd("inside user view ");

        $user = $request->user(); // Retrieve the authenticated user

        // Return the user's profile as a JSON response
        return response()->json(['profile' => $user]);
    }
}
