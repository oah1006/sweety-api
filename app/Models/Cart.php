<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'coupon_id',
        'address_id',
        'total',
        'sub_total',
        'shipping_fee'
    ];

    protected $with = ['coupon'];

    public function cartItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }

    public function calculateShippingFee() {
        $distances  = [];
        $minDistance = null;
        $closestStoreId = null;

        if($this->address_id) {
            foreach(json_decode($this->address->meta, true) as $itemAddress) {
                $distances[] = [$itemAddress['store_id'], $itemAddress['location']];
            }

            foreach($distances as $distanceItem) {
                $storeId = $distanceItem[0];
                $distance = $distanceItem[1];

                if ($minDistance === null || $distance < $minDistance) {
                    $minDistance = $distance;
                    $closestStoreId = $storeId;
                }
            }

            if ($minDistance <= 3) {
                $this->shipping_fee = 15000;
                $this->store_id = $closestStoreId;
            } else if ($minDistance >= 3 && $minDistance < 7) {
                $this->shipping_fee = 35000;
                $this->store_id = $closestStoreId;
            } else {
                return response()->json([
                    'message' => 'Bạn ở quá xa các chi nhánh cửa hàng, chúng tôi không thể nhận đơn để vận chuyển'
                ], 401);
            }
        }

    }

    public function calculateSubTotal() {
        $totalCart = 0;

        foreach($this->cartItems as $cartItem) {
            $totalTopping = 0;

            foreach($cartItem->cartItemOptions as $cartItemOption) {
                $totalTopping += $cartItemOption->topping->price * $cartItemOption->qty;
            }

            $totalCart += (($cartItem->ProductVariant->unit_price * $cartItem->qty) + ($totalTopping * $cartItem->qty));
        }

        $this->sub_total = $totalCart;
    }

    public function calculateTotal() {
        if ($this->coupon_id) {
            $coupon = Coupon::where('id', $this->coupon_id)->first();
            $this->total = ($this->sub_total - ($coupon->is_percent_value / 100 * $this->sub_total)) + $this->shipping_fee;
        } else {
            $this->total = $this->sub_total + $this->shipping_fee;
        }
    }
}
