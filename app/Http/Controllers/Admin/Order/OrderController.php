<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\CreateOrderRequest;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use App\Http\Requests\Admin\Order\UpdateStatusAcceptedOrderRequest;
use App\Http\Requests\Admin\Order\UpdateStatusDeliveringOrderRequest;
use App\Http\Requests\Admin\Order\UpdateStatusFailedOrderRequest;
use App\Http\Requests\Admin\Order\UpdateStatusPreparedOrderRequest;
use App\Http\Requests\Admin\Order\UpdateStatusPreparingOrderRequest;
use App\Http\Requests\Admin\Order\UpdateStatusSucceedOrderRequest;
use App\Http\Requests\Order\UpdateStatusOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
                    => $query->whereFullText(['code'], $keywords));

        $orders->orderBy('created_at', 'desc');

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
    public function create(Request $request)
    {

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

        $order->orderTrackings()->create([
            'status' => $order->status
        ]);

        foreach($data['products'] as $item) {
            $product = Product::where('id', $item['product_id'])->first();


            $order->items()->create([
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'unit_price' => $product->price
            ]);
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
            && (auth()->user()->profile->role === 'administrator'
            || auth()->user()->profile->role === 'employee'
            || auth()->user()->profile->role === 'manager')) {

            $order->status = 'accepted';

            $order->sale_staff_id = auth()->user()->profile->id;

            $order->save();

            $order->orderTrackings()->create([
                'status' => 'accepted',
            ]);

            return response()->json([
                'data' => $order->status
            ]);
        }
    }

    public function updateStatusPreparing(UpdateStatusPreparingOrderRequest $request, Order $order) {
        if ($order->status === 'accepted'
            && (auth()->user()->profile->role === 'administrator'
                || auth()->user()->profile->role === 'employee'
                || auth()->user()->profile->role === 'manager')) {

            $order->status = 'preparing';

            $order->save();

            $order->orderTrackings()->create([
                'status' => 'preparing',
            ]);

            return response()->json([
                'data' => $order->status
            ]);
        }
    }

    public function updateStatusPrepared(UpdateStatusPreparedOrderRequest $request, Order $order) {
        if ($order->status === 'preparing'
            && (auth()->user()->profile->role === 'administrator'
                || auth()->user()->profile->role === 'employee'
                || auth()->user()->profile->role === 'manager')) {

            $order->status = 'prepared';
            $order->save();

            $order->orderTrackings()->create([
                'status' => 'prepared',
            ]);

            return response()->json([
                'data' => $order->status
            ]);
        }
    }

    public function updateStatusDelivering(UpdateStatusDeliveringOrderRequest $request, Order $order) {
        if ($order->status === 'prepared'
            && (auth()->user()->profile->role === 'shipper'
                || auth()->user()->profile->role === 'administrator'
                || auth()->user()->profile->role === 'manager')) {

            $order->status = 'delivering';
            $order->delivery_staff_id = auth()->user()->profile->id;
            $order->save();

            $order->orderTrackings()->create([
                'status' => 'delivering',
            ]);

            return response()->json([
                'data' => $order->status,
                'id' => $order->delivery_staff_id
            ]);
        }
    }

    public function updateStatusSucceed(UpdateStatusSucceedOrderRequest $request, Order $order) {
        if ($order->status === 'delivering'
            && (auth()->user()->profile->role === 'shipper'
                || auth()->user()->profile->role === 'administrator'
                || auth()->user()->profile->role === 'manager')) {

            $order->status = 'succeed';
            $order->save();

            $order->orderTrackings()->create([
                'status' => 'succeed',
            ]);

            return response()->json([
                'data' => $order->status
            ]);
        }
    }

    public function updateStatusFailed(UpdateStatusFailedOrderRequest $request, Order $order) {
        if ($order->status === 'delivering'
            && (auth()->user()->profile->role === 'shipper'
                || auth()->user()->profile->role === 'administrator'
                || auth()->user()->profile->role === 'manager')) {

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
