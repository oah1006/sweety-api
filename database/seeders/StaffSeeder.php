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
            'address' => '78/17A Hồ Bá Phấn, Phước Long A, quận 9, Thành phố Hồ Chí Minh',
            'phone_number' => '0931395321',
            'is_active' => '1',
            'role' => 'administrator',
            'store_id' => '1'
        ]);

        $staff->user()->create([
            'email' => 'bnhao100620011@gmail.com',
            'password' => '123456',
        ]);

        $staff = Staff::create([
            'full_name' => 'Lê Chí Huy',
            'address' => '161 Hồ Bá Phấn, Phước Long A, quận 9, Thành phố Hồ Chí Minh',
            'phone_number' => '0931395322',
            'is_active' => '1',
            'role' => 'administrator',
            'store_id' => '2'
        ]);

        $staff->user()->create([
            'email' => 'lechihuy1062001@gmail.com',
            'password' => '123456',
        ]);


        $staff = Staff::create([
            'full_name' => 'Ánh Hằng',
            'address' => '222 Hồ Bá Phấn, Phước Long A, quận 9, Thành phố Hồ Chí Minh',
            'phone_number' => '0931395323',
            'is_active' => '1',
            'role' => 'employee',
            'store_id' => '3'
        ]);

        $staff->user()->create([
            'email' => 'anhhang2108@gmail.com',
            'password' => '123456',
        ]);


        $staff = Staff::create([
            'full_name' => 'Nguyễn Hoàng Tấn',
            'address' => '721 Hồ Bá Phấn, Phước Long A, quận 9, Thành phố Hồ Chí Minh',
            'phone_number' => '0931395324',
            'is_active' => '0',
            'role' => 'administrator',
            'store_id' => '4'
        ]);

        $staff->user()->create([
            'email' => 'nguyenhoangtan0101@gmail.com',
            'password' => '123456',
        ]);
    }
}
