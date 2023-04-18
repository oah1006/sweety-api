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
        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 1',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'street_number' => '101',
            'street' => 'Tôn Dật Tiên',
            'ward_code' => 26851,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0931395365',
            'long' => '132',
            'lat' => '213'
        ]);

        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 2',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'street_number' => '159',
            'street' => 'Nguyễn Đức Cảnh',
            'ward_code' => 26848,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0931395366',
            'long' => '132',
            'lat' => '213'
        ]);


        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 3',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'street_number' => '17',
            'street' => 'Út tịch',
            'ward_code' => 26845,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0931395367',
            'long' => '132',
            'lat' => '213'
        ]);

        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 4',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'street_number' => '102',
            'street' => 'Hồ Bá Phấn',
            'ward_code' => 26851,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0931395369',
            'long' => '132',
            'lat' => '213'
        ]);
    }
}
