<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Customer $customer)
    {
        $customer->deliveryAddresses()->create([
            'name' => 'Ánh Hằng',
            'address' => 'Châu Thế, Thủ Đức',
            'phone_number' => '0931395361',
            'customer_id' => 1,
            'is_default' => 1,
        ]);

        $customer->deliveryAddresses()->create([
            'name' => 'Thanh Thảo',
            'address' => 'Quận 9, TP Thủ Đức',
            'phone_number' => '0931395362',
            'customer_id' => 1,
            'is_default' => 0,
        ]);

        $customer->deliveryAddresses()->create([
            'name' => 'Chí Huy',
            'address' => 'Bình Thạnh',
            'phone_number' => '0931395364',
            'customer_id' => 2,
            'is_default' => 1,
        ]);

        $customer->deliveryAddresses()->create([
            'name' => 'Bắp',
            'address' => 'Quận 1',
            'phone_number' => '0931395363',
            'customer_id' => 2,
            'is_default' => 0,
        ]);

        $customer->deliveryAddresses()->create([
            'name' => 'Tấn',
            'address' => 'Bình Chánh',
            'phone_number' => '0931395365',
            'customer_id' => 3,
            'is_default' => 1,
        ]);

        $customer->deliveryAddresses()->create([
            'name' => 'Trân',
            'address' => 'Tân Bình',
            'phone_number' => '0931395366',
            'customer_id' => 3,
            'is_default' => 0,
        ]);

        $customer->deliveryAddresses()->create([
            'name' => 'Phương Tú',
            'address' => 'Bình Dương',
            'phone_number' => '0931395367',
            'customer_id' => 4,
            'is_default' => 1,
        ]);
    }
}
