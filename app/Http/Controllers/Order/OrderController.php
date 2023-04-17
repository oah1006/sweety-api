<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Requests\Order\UpdateStatusAcceptedOrderRequest;
use App\Http\Requests\Order\UpdateStatusDeliveringOrderRequest;
use App\Http\Requests\Order\UpdateStatusFailedOrderRequest;
use App\Http\Requests\Order\UpdateStatusOrderRequest;
use App\Http\Requests\Order\UpdateStatusPreparedOrderRequest;
use App\Http\Requests\Order\UpdateStatusPreparingOrderRequest;
use App\Http\Requests\Order\UpdateStatusSucceedOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::with(['address', 'items', 'customer', 'saleStaff', 'deliveryStaff']);

        $keywords = $request->keywords;

        $orders->when($keywords, fn (Builder $query)
                    => $query->whereFullText(['code'], $keywords)
                ->orWhereHas('address', fn (Builder $query)
                    => $query->whereFullText(['name', 'address'], $keywords)));


        $orders = $orders->paginate(5);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrderRequest $request)
    {
        $data = $request->validated();

        $order = Order::create($data);

        foreach($data['products'] as $item) {
            $order->items()->create($item);
        }

        $order = $order->fresh();

        $order->calculateSubTotal();
        $order->calculateTotal();

        $order->save();

        return response()->json([
            'data' => $order,
            'order_items' => $order->items
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();

        $order->update($data);

        foreach($data['products'] as $item) {
            $existsOrder = OrderItem::where('id', $item['id'])->first();

            if ($existsOrder) {
                $existsOrder->update($item);
            } else {
                $order->items()->create($item);
            }
        }

        $order = $order->fresh();

        return response()->json([
            'data' => $order,
            'order_items' => $order->items
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->noContent();
    }

    public function updateStatusAccepted(UpdateStatusAcceptedOrderRequest $request, Order $order) {
        if ($order->status === 'pending'
            && auth()->user()->profile->role === 'administrator'
            && auth()->user()->profile->role === 'employee'
            && auth()->user()->profile->role === 'manager') {

            $order->status = 'accepted';

            $order->sale_staff_id = auth()->user()->id;

            $order->save();

            return response()->json([
                'data' => $order->status
            ]);
        }
    }

    public function updateStatusPreparing(UpdateStatusPreparingOrderRequest $request, Order $order) {
        if ($order->status === 'accepted'
            && auth()->user()->profile->role === 'administrator'
            && auth()->user()->profile->role === 'employee'
            && auth()->user()->profile->role === 'manager') {
            $order->status = 'preparing';

            $order->save();

            return response()->json([
                'data' => $order->status
            ]);
        }
    }

    public function updateStatusPrepared(UpdateStatusPreparedOrderRequest $request, Order $order) {
        if ($order->status === 'preparing'
            && auth()->user()->profile->role === 'administrator'
            && auth()->user()->profile->role === 'employee'
            && auth()->user()->profile->role === 'manager') {

            $order->status = 'prepared';

            $order->save();

            return response()->json([
                'data' => $order->status
            ]);
        }
    }

    public function updateStatusDelivering(UpdateStatusDeliveringOrderRequest $request, Order $order) {
        if ($order->status === 'prepared' && auth()->user()->profile->role === 'shipper') {
            $order->status = 'delivering';

            $order->delivery_staff_id = auth()->user()->id;

            $order->save();

            return response()->json([
                'data' => $order->status,
                'id' => $order->delivery_staff_id
            ]);
        }
    }

    public function updateStatusSucceed(UpdateStatusSucceedOrderRequest $request, Order $order) {
        if ($order->status === 'delivering' && auth()->user()->profile->role === 'shipper') {
            $order->status = 'succeed';

            $order->save();

            return response()->json([
                'data' => $order->status
            ]);
        }
    }

    public function updateStatusFailed(UpdateStatusFailedOrderRequest $request, Order $order) {
        if ($order->status === 'delivering' && auth()->user()->profile->role === 'shipper') {
            $order->status = 'failed';

            $order->save();

            return response()->json([
                'data' => $order->status
            ]);
        }
    }
}
