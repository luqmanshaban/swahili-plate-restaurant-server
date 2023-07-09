<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function activeOrders() {
        $activeOrders = Orders::where('status','active')->get();

        if($activeOrders->count() === 0) {
            return response()->json(['message' => "NO ACTIVE ORDERS FOUND"], 404);
        }
        return response()->json(['active orders' => $activeOrders], 200);
    }
}
