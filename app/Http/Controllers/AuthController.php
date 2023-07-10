<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    public function signup(Request $request) {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'max:12', 'min:3'],
            'lastname' => ['required', 'max:12', 'min:3'],
            'email' => ['required', 'email', 'max:40', 'min:6', 'unique:users'],
            'password' => ['required', 'max:12', 'min:6'],
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        
        
        $validatedUser = $validator->validated();
        $validatedUser['password'] = bcrypt($validatedUser['password']);

        User::create($validatedUser);

        return response()->json(['message' => "User Created Successfully", 'user' => $validatedUser], 201);
    }

    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);
    
        if(Auth::attempt($credentials)) {
            $user = Auth::user();
    
            $admin = $user->hasRole('admin');
            $token = $user->createToken('auth-token')->plainTextToken;
            
            return response()->json([
                'token' => $token,
                'user' => $user,
                'isAdmin' => $admin // Changed 'is admin' to 'isAdmin'
            ], 200);
        }
        
        // If authentication fails, return a response indicating the error
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    

    public function logout(Request $request){
        $user = $request->user();

        $user->tokens()->delete();

        return response()->json(['message' => "Logout successful"]);
    }
    
}
