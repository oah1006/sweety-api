<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staff = Staff::create([
            'full_name' => 'Bùi Nhật Hào',
            'is_active' => '1',
            'role' => 'administrator',
            'store_id' => '1'
        ]);

        $staff->user()->create([
            'email' => 'bnhao10062001@gmail.com',
            'password' => '123456',
        ]);

        $staff->address()->create([
            'house_number' => '78/17A',
            'street' => 'Hồ Bá Phấn',
            'ward' => 'Phước Long A',
            'district' => 'Quận 9',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395361',
            'long' => '132',
            'lat' => '213'
        ]);

        $staff = Staff::create([
            'full_name' => 'Lê Chí Huy',
            'is_active' => '1',
            'role' => 'Manager',
            'store_id' => '2'
        ]);

        $staff->user()->create([
            'email' => 'lechihuy1062001@gmail.com',
            'password' => '123456',
        ]);

        $staff->address()->create([
            'house_number' => '201',
            'street' => 'Nơ Trang Long',
            'ward' => 'Phường 7',
            'district' => 'Quận Bình Thạnh',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395362',
            'long' => '132',
            'lat' => '213'
        ]);

        $staff = Staff::create([
            'full_name' => 'Ánh Hằng',
            'is_active' => '1',
            'role' => 'employee',
            'store_id' => '3'
        ]);

        $staff->user()->create([
            'email' => 'anhhang2108@gmail.com',
            'password' => '123456',
        ]);

        $staff->address()->create([
            'house_number' => '201',
            'street' => 'Đường 15',
            'ward' => 'Phường Bình An',
            'district' => 'Thị xã Dĩ An',
            'city' => 'Bình Dương',
            'phone_number' => '0931395363',
            'long' => '132',
            'lat' => '213'
        ]);

        $staff = Staff::create([
            'full_name' => 'Nguyễn Hoàng Tấn',
            'is_active' => '0',
            'role' => 'administrator',
            'store_id' => '4'
        ]);

        $staff->user()->create([
            'email' => 'nguyenhoangtan0101@gmail.com',
            'password' => '123456',
        ]);

        $staff->address()->create([
            'house_number' => '102',
            'street' => 'Tân Kỳ Tân Quý',
            'ward' => 'Phường Bình Hưng Hòa',
            'district' => 'Tân Phú',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395364',
            'long' => '132',
            'lat' => '213'
        ]);
    }
}
