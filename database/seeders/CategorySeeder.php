<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Trà trái cây',
            'description' => 'Đây là nơi có nhiều loại trà trái cây với các vị khác nhau phù hợp với mọi độ tuổi. Bạn có thể thử từng món và cảm nhận, nó sẽ rất ngon nếu kết hợp với các loại topping!'
        ]);

        Category::create([
            'name' => 'Trà sữa',
            'description' => 'Đây là nơi có nhiều loại trà sữa với các vị khác nhau phù hợp với mọi độ tuổi. Bạn có thể thử từng món và cảm nhận, nó sẽ rất ngon nếu kết hợp với các loại topping!'
        ]);

        Category::create([
            'name' => 'Cà phê',
            'description' => 'Đây là nơi có nhiều loại cà phê với các vị khác nhau phù hợp với mọi độ tuổi. Bạn có thể thử từng món và cảm nhận, nó sẽ rất ngon nếu kết hợp với các loại topping!'
        ]);
    }
}
