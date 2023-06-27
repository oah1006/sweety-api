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
            'street_number' => '71',
            'street' => 'Hoàng Văn Thái',
            'ward_code' => 27487,
            'district_code' => 778,
            'province_code' => 79,
            'phone_number' => '0931395365',
            'long' => '106.72073',
            'lat' => '10.72942'
        ]);

        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 2',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'street_number' => '64',
            'street' => 'Lữ Gia',
            'ward_code' => 27208,
            'district_code' => 772,
            'province_code' => 79,
            'phone_number' => '0931395366',
            'long' => '106.65367',
            'lat' => '10.77109'
        ]);


        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 3',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'street_number' => '190',
            'street' => 'Phan Văn Trị',
            'ward_code' => 26908,
            'district_code' => 765,
            'province_code' => 79,
            'phone_number' => '0931395367',
            'long' => '106.69543',
            'lat' => '10.81347'
        ]);

        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 4',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'street_number' => '359',
            'street' => 'Đỗ Xuân Hợp',
            'ward_code' => 26848,
            'district_code' => 769,
            'province_code' => 79,
            'phone_number' => '0931395369',
            'long' => '106.77232',
            'lat' => '10.82092'
        ]);
    }
}
