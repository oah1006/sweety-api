<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = Order::create([
            "coupon_id" => 1,
            "address_id" => 6,
            "customer_id" => 4,
            "status" => "pending",
        ]);

        $dataOne = [
            [
                "product_id" => 1,
                "qty" => 15,
            ],
            [
                "product_id" => 2,
                "qty" => 30,
            ]
        ];

        foreach ($dataOne as $item) {
            $order->items()->create($item);
        }

        $order = $order->fresh();

        $order->calculateSubTotal();
        $order->calculateTotal();

        $order->save();

        $order = $order->create([
            "coupon_id" => 1,
            "address_id" => 5,
            "customer_id" => 4,
            "status" => "succeed",
        ]);

        $dataTwo = [
            [
                "product_id" => 1,
                "qty" => 25,
            ],
            [
                "product_id" => 2,
                "qty" => 30,
            ]
        ];

        foreach ($dataTwo as $item) {
            $order->items()->create($item);
        }

        $order = $order->fresh();

        $order->calculateSubTotal();
        $order->calculateTotal();

        $order->save();
    }
}
