<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
    
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer',
            'method' => 'required|string|max:20',
            'transaction_id' => 'required|string|max:100',
            'status' => 'required|string|in:pending,completed'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $validatedPayment = $validator->validated();
        $validatedPayment['user_id'] = $user->id;
    
        Payment::create($validatedPayment);
    
        return response()->json(['success' => $validatedPayment], 201);
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
