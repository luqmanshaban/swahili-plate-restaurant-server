<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Auth::user();

        $orders = Orders::with('user')->where('status', 'active')->get();
        return response()->json(['orders' => $orders], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function history(Request $request) {
        Auth::user();
        $orders = Orders::with('user')->where('status', 'completed')->get();
        return response()->json(['orders' => $orders], 200);
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
        // Find the order by its ID
    $order = Orders::findOrFail($id);

    // Validate and update the order's status
    $request->validate([
        'status' => 'required|in:active,processing,completed,cancelled',
    ]);

    $order->status = $request->input('status');
    $order->save();

    return response()->json(['message' => 'Order status updated successfully'],200);
}
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
