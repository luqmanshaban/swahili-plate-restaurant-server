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
        $orders = Orders::where('user_id', $user->id)->get();
        
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
            $validatedOrder['status'] = 'Processing';
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
}
