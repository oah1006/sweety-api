<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateStatusCanceledOrderRequest;
use App\Http\Requests\User\Order\CreateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = auth()->user()->profile->order();

        if ($request->filled('status')) {
            $status = $request->status;

            if ($status == 'processing') {
                $orders->whereIn('status', ['pending', 'accepted', 'preparing', 'prepared']);
            } else if ($status == 'failed') {
                $orders->whereIn('status', ['failed', 'canceled']);
            } else {
                $orders->where('status', $status);
            }
        }

        $orders->orderBy('created_at', 'desc');

        $orders = $orders->paginate(4);

        return response()->json([
            'data' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $cart = $user->profile->cart;

        if ($cart->address_id) {
            $order = Order::create([
                'coupon_id' => $cart->coupon_id,
                'address_id' => $cart->address_id,
                'customer_id' => $user->profile->id,
                'sub_total' => $cart->sub_total,
                'total' => $cart->total,
                'shipping_fee' => $cart->shipping_fee
            ]);
        } else {
            return response()->json([
                'message' => 'Địa chỉ chưa được chọn!'
            ], 401);
        }



        $order->orderTrackings()->create([
            'status' => 'pending'
        ]);

        foreach ($cart->cartItems as $itemCart) {
            $orderItem = $order->items()->create([
                'product_id' => $itemCart->product_id,
                'product_variant_id' => $itemCart->product_variant_id,
                'qty' => $itemCart->qty,
                'unit_price' => $itemCart->productVariant->unit_price
            ]);

            foreach ($itemCart->cartItemOptions as $itemCartOption) {
                $orderItem->orderItemOptions()->create([
                    'topping_id' => $itemCartOption->topping_id,
                    'qty' => $itemCartOption->qty,
                    'price' => $itemCartOption->topping->price
                ]);
            }
        }

        $cart->delete();

        return response()->json([
            'data' => $order,
            'order_items' => $orderItem,
            'order_item_options' => $orderItem->orderItemOptions
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        $order->load('address');

        $order->load('customer');

        $order->load('saleStaff');

        $order->load('deliveryStaff');

        $order->load('items');

        $order->load('coupon');

        $order->load('orderTrackings');

        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatusCanceled(UpdateStatusCanceledOrderRequest $request, Order $order) {
        if ($order->status === 'pending') {
            $order->status = 'canceled';
            $order->save();

            $order->orderTrackings()->create([
                'status' => 'canceled',
            ]);



            return response()->json([
                'data' => $order->status
            ]);
        }
    }
}
