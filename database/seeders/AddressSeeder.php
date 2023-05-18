<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Customer $customer)
    {
        $customer->address()->create([
            'name' => 'Ánh Hằng',
            'street_number' => '190',
            'street' => 'Phan Văn Trị',
            'ward' => 'Phường 11',
            'district' => 'Quận Bình Thạnh',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395161',
            'customer_id' => 1,
            'is_default' => 1,
        ]);

        $customer->address()->create([
            'name' => 'Thanh Thảo',
            'street_number' => '270',
            'street' => 'Bùi Hữu Nghĩa',
            'ward' => 'Phường 2',
            'district' => 'Quận Bình Thạnh',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395261',
            'customer_id' => 1,
            'is_default' => 0,
        ]);

        $customer->address()->create([
            'name' => 'Chí Huy',
            'house_number' => '355A',
            'street' => 'Lê Quang Định',
            'ward' => 'Phường 5',
            'district' => 'Quận Bình Thạnh',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395261',
            'customer_id' => 2,
            'is_default' => 1,
        ]);

        $customer->address()->create([
            'name' => 'Bắp',
            'house_number' => '670',
            'street' => 'Nguyễn Duy Trinh',
            'ward' => 'Bình Trưng Đông',
            'district' => 'Quận 2',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395461',
            'customer_id' => 2,
            'is_default' => 0,
        ]);

        $customer->address()->create([
            'name' => 'Tấn',
            'house_number' => '403',
            'street' => 'Phan Huy Ích',
            'ward' => 'Phường 14',
            'district' => 'Quận Gò Vấp',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395561',
            'customer_id' => 3,
            'is_default' => 1,
        ]);

        $customer->address()->create([
            'name' => 'Trân',
            'house_number' => '93/5B',
            'street' => 'Nguyễn Ảnh Thủ',
            'ward' => 'Trung Chánh',
            'district' => 'Hóc Môn',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395661',
            'customer_id' => 3,
            'is_default' => 0,
        ]);

        $customer->address()->create([
            'name' => 'Phương Tú',
            'house_number' => '359',
            'street' => 'Đỗ Xuân Hợp',
            'ward' => 'Phước Long B',
            'district' => 'Quận 9',
            'city' => 'Thành phố Hồ Chí Minh',
            'phone_number' => '0931395661',
            'customer_id' => 4,
            'is_default' => 1,
        ]);
    }
}
