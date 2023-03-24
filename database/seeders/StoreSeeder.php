<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            'name' => 'Cửa hàng Sweety chi nhánh 1',
            'address' => 'Quận 9, TPHCM',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        Store::create([
            'name' => 'Cửa hàng Sweety chi nhánh 2',
            'address' => 'Tân Phú, TPHCM',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        Store::create([
            'name' => 'Cửa hàng Sweety chi nhánh 3',
            'address' => 'Thủ Đức, TPHCM',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        Store::create([
            'name' => 'Cửa hàng Sweety chi nhánh 4',
            'address' => 'Dĩ An, Bình Dương',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);
    }
}
