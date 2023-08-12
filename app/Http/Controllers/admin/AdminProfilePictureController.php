<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AdminProfilePictureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check()) {
            $user = Auth::user();
            $profilePic = $user->image;
            
            return response()->json(["profilePic" => $profilePic]);
        }
        return response()->json(['message' => "Unauthorized"], 401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if (Auth::check()) {
            $user = Auth::user();
    
            // Check if the user has an existing image
            if ($user->image) {
                // Delete the existing image from storage
                $existingImagePath = public_path('storage/images/' . basename($user->image));
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
    
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
    
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/images', $filename);
    
                $user->image = asset('storage/images/' . $filename);
                $user->save();
    
                return response()->json(['message' => 'Image saved successfully']);
            }
    
            return response()->json(['error' => 'No image provided'], 400);
        }
    
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
