<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateStatusCanceledOrderRequest;
use App\Models\Order;
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
        //
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

            return response()->json([
                'data' => $order->status
            ]);
        }
    }
}
