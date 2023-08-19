<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class CustomerDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $roles = $user->roles->pluck('role')->toArray();
            
            if ($user) {
                $response = [
                    "details" => [
                        "firstname" => $user->firstname,
                        "lastname" => $user->lastname,
                        "email" => $user->email,
                        "role" => $roles
                    ]
                ];
                
                return response()->json($response);
            }
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
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
