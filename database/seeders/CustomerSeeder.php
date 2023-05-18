<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = Customer::create([
            'full_name' => 'Nhật Hào',
            'gender' => '0',
        ]);

        $customer->user()->create([
            'email' => 'bnhao10062001@gmail.com',
            'password' => '123456',
        ]);

        $customer->address()->create([
            'street_number' => '102',
            'street' => 'Hồ Bá Phấn',
            'ward_code' => 26851,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0931315369',
            'long' => '132',
            'lat' => '213',
        ]);

        $customer = Customer::create([
            'full_name' => 'Ngọc Linh',
            'gender' => '0',
        ]);

        $customer->user()->create([
            'email' => 'ngoclinh196@gmail.com',
            'password' => '123456',
        ]);

        $customer->address()->create([
            'street_number' => '102',
            'street' => 'Hồ Bá Phấn',
            'ward_code' => 26851,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0932395369',
            'long' => '132',
            'lat' => '213'
        ]);

        $customer = Customer::create([
            'full_name' => 'Nhật An',
            'gender' => '0',
        ]);

        $customer->user()->create([
            'email' => 'nhatan106@gmail.com',
            'password' => '123456',
        ]);

        $customer->address()->create([
            'street_number' => '102',
            'street' => 'Hồ Bá Phấn',
            'ward_code' => 26851,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0931345369',
            'long' => '132',
            'lat' => '213'
        ]);

        $customer = Customer::create([
            'full_name' => 'Phương Tú',
            'gender' => '0',
        ]);

        $customer->user()->create([
            'email' => 'phuongtu106@gmail.com',
            'password' => '123456',
        ]);

        $customer->address()->create([
            'street_number' => '102',
            'street' => 'Hồ Bá Phấn',
            'ward_code' => 26851,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0931595369',
            'long' => '132',
            'lat' => '213'
        ]);
    }
}
