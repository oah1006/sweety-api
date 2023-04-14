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
            'house_number' => '101',
            'street' => 'Tôn Dật Tiên',
            'ward' => 'Phường Tân Phú',
            'district' => 'Quận 7',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395365'
        ]);

        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 2',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'house_number' => '159',
            'street' => 'Nguyễn Đức Cảnh',
            'ward' => 'Tân Phong',
            'district' => 'Quận 7',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395366'
        ]);


        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 3',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'house_number' => '17',
            'street' => 'Út tịch',
            'ward' => 'Phường Bình Hưng Hòa',
            'district' => 'Quận Tân Bình',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395367'
        ]);

        $store = Store::create([
            'store_name' => 'Cửa hàng Sweety chi nhánh 4',
            'open_store' => '09:00',
            'close_store' => '21:00'
        ]);

        $store->address()->create([
            'house_number' => '64A',
            'street' => 'Lữ Gia',
            'ward' => 'Phường 15',
            'district' => 'Quận 11',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395369'
        ]);
    }
}
