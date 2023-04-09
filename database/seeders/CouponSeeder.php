<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'name' => 'Mã khuyến mãi 50%',
            'description' => 'Đơn hàng của bạn tích lũy đạt giá trị từ 500.000 đồng trở lên sẽ đạt được điều kiện này',
            'stock' => 20,
            'is_percent_value' => 50,
            'min_order_total' => 500000,
            'status' => 'active',
            'started_at' => '2023-04-08',
            'expired_at' => '2023-04-09'
        ]);

        Coupon::create([
            'name' => 'Mã khuyến mãi 30%',
            'description' => 'Đơn hàng của bạn tích lũy đạt giá trị từ 300.000 đồng trở lên sẽ đạt được điều kiện này',
            'stock' => 40,
            'is_percent_value' => 30,
            'min_order_total' => 500000,
            'status' => 'active',
            'started_at' => '2023-04-08',
            'expired_at' => '2023-04-09'
        ]);

        Coupon::create([
            'name' => 'Mã khuyến mãi 100%',
            'description' => 'Đơn hàng của bạn tích lũy đạt giá trị từ 1.000.000 đồng trở lên sẽ đạt được điều kiện này',
            'stock' => 10,
            'is_percent_value' => 100,
            'min_order_total' => 1000000,
            'status' => 'active',
            'started_at' => '2023-04-08',
            'expired_at' => '2023-04-09'
        ]);
    }
}
