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
            'full_name' => 'Thiên Quỳnh'
        ]);

        $customer->user()->create([
            'email' => 'thienquynh106@gmail.com',
            'password' => '123456',
            'phone_number' => '0908640010',
            'address' => 'Bình Thạnh, TPHCM'
        ]);

        $customer = Customer::create([
            'full_name' => 'Ngọc Linh'
        ]);

        $customer->user()->create([
            'email' => 'ngoclinh196@gmail.com',
            'password' => '123456',
            'phone_number' => '0908640110',
            'address' => 'Thủ Đức, TPHCM'
        ]);

        $customer = Customer::create([
            'full_name' => 'Nhật An'
        ]);

        $customer->user()->create([
            'email' => 'nhatan106@gmail.com',
            'password' => '123456',
            'phone_number' => '0908641110',
            'address' => 'Thủ Đức, TPHCM'
        ]);

        $customer = Customer::create([
            'full_name' => 'Phương Tú'
        ]);

        $customer->user()->create([
            'email' => 'phuongtu106@gmail.com',
            'password' => '123456',
            'phone_number' => '0908611110',
            'address' => 'Quận 9, TPHCM'
        ]);
    }
}
