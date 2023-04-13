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
        ]);

        $customer->address()->create([
            'house_number' => '156',
            'street' => 'Phan Văn Trị',
            'ward' => 'Phường 11',
            'district' => 'Quận Bình Thạnh',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395315'
        ]);

        $customer = Customer::create([
            'full_name' => 'Ngọc Linh'
        ]);

        $customer->user()->create([
            'email' => 'ngoclinh196@gmail.com',
            'password' => '123456',
        ]);

        $customer->address()->create([
            'house_number' => '156',
            'street' => 'Hồ Tùng Mậu',
            'ward' => 'Phường Bến Nghé',
            'district' => 'Quận 1',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931396325'
        ]);

        $customer = Customer::create([
            'full_name' => 'Nhật An'
        ]);

        $customer->user()->create([
            'email' => 'nhatan106@gmail.com',
            'password' => '123456',
        ]);

        $customer->address()->create([
            'house_number' => '156',
            'street' => 'Hồ Tùng Mậu',
            'ward' => 'Phường Bến Nghé',
            'district' => 'Quận 1',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395325'
        ]);

        $customer = Customer::create([
            'full_name' => 'Phương Tú'
        ]);

        $customer->user()->create([
            'email' => 'phuongtu106@gmail.com',
            'password' => '123456',
        ]);

        $customer->address()->create([
            'house_number' => '257',
            'street' => 'Đồng Khởi',
            'ward' => 'Phường Tân Hiệp',
            'district' => 'Biên Hòa',
            'city' => 'Đồng Nai',
            'phone_number' => '0931395335'
        ]);
    }
}
