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
            "delivery_address_id" => 1,
            "customer_id" => 1,
            "staff_id" => 1,
            "total" => 400000,
            "sub_total" => 350000,
            "status" => "pending",
        ]);

        $dataOne = [
            [
                "product_id" => 2,
                "quantity" => 15,
            ],
            [
                "product_id" => 1,
                "quantity" => 30,
            ]
        ];

        foreach ($dataOne as $item) {
            $order->items()->create($item);
        }

        $order->create([
            "coupon_id" => 1,
            "delivery_address_id" => 1,
            "customer_id" => 2,
            "staff_id" => 2,
            "total" => 200000,
            "sub_total" => 250000,
            "status" => "succeed",
        ]);

        $dataTwo = [
            [
                "product_id" => 3,
                "quantity" => 25,
            ],
            [
                "product_id" => 1,
                "quantity" => 30,
            ]
        ];

        foreach ($dataTwo as $item) {
            $order->items()->create($item);
        }
    }
}
