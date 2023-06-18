<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function addQty(CartItem $cartItem) {
        $cartItem->qty += 1;
        $cartItem->save();

        $cartItem->cart->calculateSubTotal();
        $cartItem->cart->calculateTotal();
        $cartItem->cart->calculateShippingFee();

        $cartItem->cart->save();

        return response()->json([
            'data' => $cartItem->cart
        ]);
    }

    public function minusQty(CartItem $cartItem) {
        if ($cartItem->qty == 1) {
            $cartItem->delete();
        } else {
            $cartItem->qty -= 1;
            $cartItem->save();
        }

        $cartItem->cart->calculateSubTotal();
        $cartItem->cart->calculateTotal();
        $cartItem->cart->calculateShippingFee();

        $cartItem->cart->save();

        return response()->json([
            'data' => $cartItem->cart
        ]);
    }
}
