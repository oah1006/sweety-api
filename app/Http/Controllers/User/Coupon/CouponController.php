<?php

namespace App\Http\Controllers\User\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $coupon = Coupon::where('is_deleted', 0)->where('status', 'active')->get();

        return response()->json([
            'data' => $coupon
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
    public function destroy($id)
    {
        //
    }

    public function applyCoupon(Request $request, Coupon $coupon) {
        $user = $request->user();

        if ($coupon->stock === 0) {
            $user->profile->cart->coupon()->update([
                'status' => 'expired'
            ]);
        }

        $user->profile->cart()->update([
            'customer_id' => $user->profile->id,
            'coupon_id' => $coupon->id
        ]);

        $user->profile->cart->coupon()->update([
            'stock' => $coupon->stock - 1
        ]);



        $user->profile->cart->calculateSubTotal();
        $user->profile->cart->calculateTotal();
        $user->profile->cart->calculateShippingFee();

        $user->profile->cart->save();
    }

    public function removeCoupon(Request $request, Cart $cart) {
        $user = $request->user();

        $user->profile->cart()->update([
            'coupon_id' => null
        ]);

        $user->profile->cart->calculateSubTotal();
        $user->profile->cart->calculateTotal();
        $user->profile->cart->calculateShippingFee();

        $user->profile->cart->save();
    }
}
