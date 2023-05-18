<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            "name" => "Trà sữa ô long",
            "description" => "Trà sữa ô long thanh vị trà ô long và sữa tươi",
            "stock" => 40,
            "price" => "35000",
            "category_id" => 2,
            "published" => 0
        ]);

        Product::create([
            "name" => "Nước cam",
            "description" => "Nước cam với đầy sự ngọt ngào ít chua chua",
            "stock" => 40,
            "price" => "35000",
            "category_id" => 1,
            "published" => 1
        ]);

        Product::create([
            "name" => "Trà sữa bạc hà",
            "description" => "Trà sữa thanh vị bạc hà và sữa tươi",
            "stock" => 40,
            "price" => "35000",
            "category_id" => 2,
            "published" => 1
        ]);
    }
}
