<?php

namespace App\Http\Controllers\User\OrderTracking;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function checkStatusOrder(Request $request, Order $order) {
        $order->orderTrackings()->get();

        return response()->json([]);
    }
}
