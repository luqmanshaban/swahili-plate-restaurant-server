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
        $paymentTimeFrame = now()->subMinutes(10);

        $payment = Payment::where('user_id', $user->id)
        ->where('created_at', '>=', $paymentTimeFrame)
        ->orderBy('created_at', 'desc')
        ->first();

        if($payment){
          return response()->json(["payment" => $payment]);
        }else {
            return response()->json(['message' => 'Payment not found']);
        }
        
    }
    
    public function confirmPayment(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:100',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $transactionId = $validator->validated()['id'];
    
        // Retrieve the payment record based on the 'transaction_id'
        $payment = Payment::where('transaction_id', $transactionId)->first();
    
        if ($payment) {
            // Access the ID of the found payment record
            return response()->json(['id' => $payment->id]);
            // Now, $id contains the ID of the payment record where the specified transaction_id is stored
        } else {
            // Handle the case where the transaction_id is not found
            return response()->json(['id' => null]); // Set 'id' to null or any other desired value
        }
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
            'status' => 'required|string'
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
