<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Cart\AddCartRequest;
use App\Models\Cart;
use App\Models\CartItemOption;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if($user->profile->cart) {
            $cart = $user->profile->cart->load(['cartItems.cartItemOptions', 'coupon', 'store']);
            $cart->fresh();

            $cart->calculateSubTotal();
            $cart->calculateTotal();
            $cart->calculateShippingFee();

            $cart->save();

            return response()->json([
                'data' => $cart
            ]);
        } else {
            return response()->json([
                'message' => 'no cart'
            ]);
        }


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
    public function store(AddCartRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        $cart = $user->profile->cart()->firstOrCreate();

        $cartItem = $cart->cartItems()->with('cartItemOptions')
            ->where('product_variant_id', $data['product_variant_id'])->get()
            ->filter(function ($item) use ($data) {
                return $item->cartItemOptions->pluck('topping_id')
                        ->diff(collect($data['options'])->pluck('topping_id'))->count() == 0
                    && $item->cartItemOptions->every(function ($option) use ($data) {
                        return $option->qty == collect($data['options'])
                        ->firstWhere('topping_id', $option->topping_id)['qty'];
                    });
            })->first();

        if ($cartItem) {
            $cartItem->increment('qty');

            $cartItem->cartItemOptions()->delete();
            $cartItem->cartItemOptions()->createMany($data['options']);
        } else {
            $cartItem = $cart->cartItems()->create([
                'product_variant_id' => $data['product_variant_id'],
            ]);

            $cartItem->cartItemOptions()->createMany($data['options']);
        }

        $cart = $cart->fresh();

        $cart->calculateSubTotal();
        $cart->calculateTotal();
        $cart->calculateShippingFee();

        $cart->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Cart $cart)
    {

    }
}
