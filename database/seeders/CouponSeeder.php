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
            'description' => 'Cửa hàng Sweety trân trọng tặng mã khuyến mãi với giá trị hơn 50%',
            'stock' => 20,
            'is_percent_value' => 50,
            'min_order_total' => 500000,
            'status' => 'active',
            'started_at' => '2023-04-08',
            'expired_at' => '2023-04-09',
        ]);

        Coupon::create([
            'name' => 'Mã khuyến mãi 30%',
            'description' => 'Cửa hàng Sweety trân trọng tặng mã khuyến mãi với giá trị hơn 30%',
            'stock' => 40,
            'is_percent_value' => 30,
            'min_order_total' => 500000,
            'status' => 'active',
            'started_at' => '2023-04-08',
            'expired_at' => '2023-04-09',
        ]);

        Coupon::create([
            'name' => 'Mã khuyến mãi 100%',
            'description' => 'Cửa hàng Sweety trân trọng tặng mã khuyến mãi với giá trị hơn 100%',
            'stock' => 10,
            'is_percent_value' => 100,
            'min_order_total' => 1000000,
            'status' => 'active',
            'started_at' => '2023-04-08',
            'expired_at' => '2023-04-09',
        ]);
    }
}
