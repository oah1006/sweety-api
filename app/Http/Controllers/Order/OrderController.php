<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
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
        $orders = Order::with(['deliveryAddress', 'items', 'customer', 'staff']);

        $keywords = $request->keywords;

        $orders->when($keywords, fn (Builder $query)
                    => $query->whereFullText(['code'], $keywords)
                ->orWhereHas('addresses', fn (Builder $query)
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
        $order->load('deliveryAddress');

        $order->load('customer');

        $order->load('staff');

        $order->load('items');


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
}
