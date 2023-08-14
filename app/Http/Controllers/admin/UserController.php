<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
    
        $formattedUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'image' => $user->image,
                'roles' => $user->roles->pluck('role')->toArray(),
            ];
        });
    
        return response()->json(['users' => $formattedUsers]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->get();
        if($user->count() === 0) {
            return response()->json(['message'=>"User not Found"],404);
        }
        return response()->json(['user'=>$user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'firstname'=>'required|string',
            'lastname'=>'required|string',
            'email'=>'required|email|unique:users,email' .$id,
            'password' => ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
