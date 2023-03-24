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
            'phone_number' => '0931395361',
            'address' => 'Quận 9, TPHCM',
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
            'address' => 'Quận Bình Thạnh, TPHCM',
            'phone_number' => '0931395362',
        ]);

        $staff = Staff::create([
            'full_name' => 'Bùi Nhật Hào',
            'is_active' => '1',
            'role' => 'employee',
            'store_id' => '3'
        ]);

        $staff->user()->create([
            'email' => 'anhhang2108@gmail.com',
            'password' => '123456',
            'address' => 'Dĩ An, Bình Dương',
            'phone_number' => '0931395363',
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
            'address' => 'Tân Phú, TPHCM',
            'phone_number' => '0931395364',
        ]);
    }
}
