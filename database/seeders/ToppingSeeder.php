<?php

namespace Database\Seeders;

use App\Models\Topping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topping::create([
            'name' => 'Trân châu đen',
            'price' => 5000,
            'published' => true
        ]);

        Topping::create([
            'name' => 'Trân châu trắng',
            'price' => 5000,
            'published' => true
        ]);

        Topping::create([
            'name' => 'Kem Macchiato',
            'price' => 15000,
            'published' => true
        ]);

        Topping::create([
            'name' => 'Kem phô mai',
            'price' => 15000,
            'published' => true
        ]);
    }
}
