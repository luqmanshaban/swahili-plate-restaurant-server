<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Payment;
use Auth;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Orders::where('user_id', $user->id)->whereIn(
            'status', ['completed', 'cancelled']
        )->get();
        
        return response()->json(['orders' => $orders]);
    }

    public function activeOrders() {
        $user = Auth::user();
        $orders = Orders::where('user_id', $user->id)->where(
            'status', 'active'
        )->get();
        
        return response()->json(['orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $ordersArray = $request->input('orders');

        $storedOrders = [];

        foreach ($ordersArray as $orderData) {
            $validateOrder = Validator::make($orderData, [
                'name' => 'required|string',
                'img' => 'required|string',
                'quantity' => 'required|integer',
                'total' => 'required|integer',
                'contact' => 'nullable|string',
            ]);

            if ($validateOrder->fails()) {
                return response()->json(['errors' => $validateOrder->errors()], 400);
            }

            $validatedOrder = $validateOrder->validated();
            $validatedOrder['user_id'] = $user->id;
            $validatedOrder['status'] = 'active';
            $validatedOrder['delivery_address'] = 'North View Rd - Pangani';

            $payment = Payment::where('user_id', $user->id)->first();

            if (!$payment) {
                return response()->json(['message' => 'Payment not found for the authenticated user.'], 404);
            }

            $validatedOrder['payment_id'] = $payment->id;

            $createdOrder = Orders::create($validatedOrder);
            $storedOrders[] = $createdOrder;
        }

        return response()->json(['message' => "Orders Created Successfully", 'orders' => $storedOrders],201);
    }

    // Other methods remain unchanged...

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $order = Orders::where('user_id', $user->id)->find($id);
    
        if (!$order) {
            return response()->json(['message' => 'Order not found for the authenticated user.'], 404);
        }
    
        $status = $request->status;
    
        if (!in_array($status, ['active', 'completed', 'cancelled'])) {
            return response()->json(['message' => 'Invalid status provided.'], 400);
        }
    
        $order->status = $status;
        $order->save();
    
        return response()->json(['message' => 'Order status updated successfully.', 'order' => $order]);
    }

    public function cancelOrder($id) {
        $order = Orders::findOrFail($id);

        $order->status = 'cancelled';
        $order->save();
        return response()->json(['message' => 'Order status updated successfully.', 'order' => $order]);
    }

}
