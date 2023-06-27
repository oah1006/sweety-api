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
            "name" => "Hồng Trà Sữa Trân Châu",
            "description" => "Thêm chút ngọt ngào cho ngày mới với hồng trà nguyên lá, sữa thơm ngậy được cân chỉnh với tỉ lệ hoàn hảo, cùng trân châu trắng dai giòn có sẵn để bạn tận hưởng từng ngụm trà sữa ngọt ngào thơm ngậy thiệt đã.",
            "stock" => 50,
            "price" => "55000",
            "category_id" => 2,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Trà Hạt Sen Đá",
            "description" => "Nền trà oolong hảo hạng kết hợp cùng hạt sen tươi, bùi bùi và lớp foam cheese béo ngậy. Trà hạt sen là thức uống thanh mát, nhẹ nhàng phù hợp cho cả buổi sáng và chiều tối.",
            "stock" => 50,
            "price" => "55000",
            "category_id" => 1,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Hi Tea Đào",
            "description" => "Sự kết hợp ăn ý giữa Đào cùng trà hoa Hibiscus, tạo nên tổng thể hài hoà dễ gây “thương nhớ” cho team thích món thanh mát, có vị chua nhẹ.",
            "stock" => 50,
            "price" => "45000",
            "category_id" => 1,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Cà Phê Đen Đá",
            "description" => "Không ngọt ngào như Bạc sỉu hay Cà phê sữa, Cà phê đen mang trong mình phong vị trầm lắng, thi vị hơn. Người ta thường phải ngồi rất lâu mới cảm nhận được hết hương thơm ngào ngạt, phảng phất mùi cacao và cái đắng mượt mà trôi tuột xuống vòm họng.",
            "stock" => 50,
            "price" => "30000",
            "category_id" => 5,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Bạc Sỉu",
            "description" => "Bạc sỉu chính là Ly sữa trắng kèm một chút cà phê. Thức uống này rất phù hợp những ai vừa muốn trải nghiệm chút vị đắng của cà phê vừa muốn thưởng thức vị ngọt béo ngậy từ sữa.",
            "stock" => 50,
            "price" => "29000",
            "category_id" => 5,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Trà Đen Macchiato",
            "description" => "Trà đen được ủ mới mỗi ngày, giữ nguyên được vị chát mạnh mẽ đặc trưng của lá trà, phủ bên trên là lớp Macchiato homemade bồng bềnh quyến rũ vị phô mai mặn mặn mà béo béo.",
            "stock" => 50,
            "price" => "55000",
            "category_id" => 2,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Trà Sữa Mắc Ca Trân Châu",
            "description" => "Mỗi ngày với The Coffee House sẽ là điều tươi mới hơn với sữa hạt mắc ca thơm ngon, bổ dưỡng quyện cùng nền trà oolong cho vị cân bằng, ngọt dịu đi kèm cùng Trân châu trắng giòn dai mang lại cảm giác “đã” trong từng ngụm trà sữa.",
            "stock" => 50,
            "price" => "55000",
            "category_id" => 2,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Hi Tea Đá Tuyết Yuzu Vải",
            "description" => "Vị trà hoa Hibiscus chua chua, kết hợp cùng đá tuyết Yuzu mát lạnh tái tê, thêm miếng vải căng mọng, ngọt ngào sẽ khiến bạn thích thú ngay từ lần thử đầu tiên.",
            "stock" => 50,
            "price" => "60000",
            "category_id" => 1,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Hi Tea Đào Kombucha",
            "description" => "Trà hoa Hibiscus 0% caffeine chua nhẹ, kết hợp cùng trà lên men Kombucha hoàn toàn tự nhiên và Đào thanh mát",
            "stock" => 50,
            "price" => "59000",
            "category_id" => 1,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "Hi Tea Yuzu Kombucha",
            "description" => "Trà hoa Hibiscus 0% caffeine thanh mát, hòa quyện cùng trà lên men Kombucha 100% tự nhiên và mứt Yuzu Marmalade (quýt Nhật) mang đến hương vị chua chua lạ miệng",
            "stock" => 50,
            "price" => "59000",
            "category_id" => 1,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "CloudTea Oolong Nướng Kem Dừa Đá Xay",
            "description" => "Trà sữa đá xay - phiên bản nâng cấp đầy mới lạ của trà sữa truyền thống, lần đầu xuất hiện tại Nhà. Ngon khó cưỡng với lớp kem dừa béo ngậy nhưng không ngấy, thêm vụn bánh quy phô mai giòn tan vui miệng",
            "stock" => 50,
            "price" => "55000",
            "category_id" => 2,
            "published" => 1,
            "is_deleted" => 0
        ]);

        Product::create([
            "name" => "CloudTea Oolong Nướng Kem Cheese",
            "description" => "Hội mê cheese sao có thể bỏ lỡ chiếc trà sữa siêu mlem này. Món đậm vị Oolong nướng - nền trà được yêu thích nhất hiện nay, quyện thêm kem sữa thơm béo. Đặc biệt, chinh phục ngay fan ghiền cheese bởi lớp foam phô mai mềm tan mằn mặn",
            "stock" => 50,
            "price" => "55000",
            "category_id" => 2,
            "published" => 1,
            "is_deleted" => 0
        ]);
    }
}
