<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::user();
        $validateOrder = $request->validate([
           'total' => 'required|integer',
           'status' => 'required|string',
           'delivery_address' => 'required|string',
           'contact' => 'nullable|string',
           'payment_id' => 'required|exists:payments,id'
        ]);

        $order = Orders::create([
            'user_id' => $userId,
            'total' => $validateOrder['total'],
            'status' => $validateOrder['status'],
            'delivery_address' => $validateOrder['delivery_address'],
            'contact' => $validateOrder['contact'],
            'payment_id' => $validateOrder['payment_id']
        ]);

        return response()->json(['message' => "Order Created Successfully", 'order' => $order]);
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
