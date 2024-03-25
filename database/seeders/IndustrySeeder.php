<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "name"      => "An toàn lao động"
            ],
            [
                "name"      => "Bán hàng kỹ thuật"
            ],
            [
                "name"      => "Bán lẻ / bán sỉ"
            ],
            [
                "name"      => "Báo chí / Truyền hình"
            ],
            [
                "name"      => "Bảo hiểm"
            ],
            [
                "name"      => "Bảo trì / Sửa chữa"
            ],
            [
                "name"      => "Bất động sản"
            ],
            [
                "name"      => "Biên / Phiên dịch"
            ],
            [
                "name"      => "Bưu chính - Viễn thông"
            ],
            [
                "name"      => "Chứng khoán / Vàng / Ngoại tệ"
            ],
            [
                "name"      => "Cơ khí / Chế tạo / Tự động hóa"
            ],
            [
                "name"      => "Công nghệ cao"
            ],
            [
                "name"      => "Công nghệ Ô tô"
            ],
            [
                "name"      => "Công nghệ thông tin"
            ],
            [
                "name"      => "Dầu khí / Hóa chất"
            ],
            [
                "name"      => "Dệt may / Da giày"
            ],
            [
                "name"      => "Địa chất / Khoáng sản"
            ],
            [
                "name"      => "Dịch vụ khách hàng"
            ],
            [
                "name"      => "Điện / Điện tử / Điện lạnh"
            ],
            [
                "name"      => "Điện tử viễn thông"
            ],
            [
                "name"      => "Du lịch"
            ],
            [
                "name"      => "Dược phẩm / Công nghệ sinh học"
            ],
            [
                "name"      => "Giáo dục / Đào tạo"
            ],
            [
                "name"      => "Hàng cao cấp"
            ],
            [
                "name"      => "Hàng gia dụng"
            ],
            [
                "name"      => "Hàng hải"
            ],
            [
                "name"      => "Hàng không"
            ],
            [
                "name"      => "Hàng tiêu dùng"
            ],
            [
                "name"      => "Hành chính / Văn phòng"
            ],
            [
                "name"      => "Hoá học / Sinh học"
            ],
            [
                "name"      => "Hoạch định / Dự án"
            ],
            [
                "name"      => "In ấn / Xuất bản"
            ],
            [
                "name"      => "IT Phần cứng / Mạng"
            ],
            [
                "name"      => "IT phần mềm"
            ],
            [
                "name"      => "Kế toán / Kiểm toán"
            ],
            [
                "name"      => "Khách sạn / Nhà hàng"
            ],
            [
                "name"      => "Kiến trúc"
            ],
            [
                "name"      => "Kinh doanh / Bán hàng"
            ],
            [
                "name"      => "Logistics"
            ],
            [
                "name"      => "Luật/Pháp lý"
            ],
            [
                "name"      => "Marketing / Truyền thông / Quảng cáo"
            ],
            [
                "name"      => "Môi trường / Xử lý chất thải"
            ],
            [
                "name"      => "Mỹ phẩm / Trang sức"
            ],
            [
                "name"      => "Mỹ thuật / Nghệ thuật / Điện ảnh"
            ],
            [
                "name"      => "Ngân hàng / Tài chính"
            ],
            [
                "name"      => "Ngành nghề khác"
            ],
            [
                "name"      => "NGO / Phi chính phủ / Phi lợi nhuận"
            ],
            [
                "name"      => "Nhân sự"
            ],
            [
                "name"      => "Nông / Lâm / Ngư nghiệp"
            ],
            [
                "name"      => "Phi chính phủ / Phi lợi nhuận"
            ],
            [
                "name"      => "Quản lý chất lượng"
            ],
            [
                "name"      => "Quản lý điều hành"
            ],
            [
                "name"      => "Sản phẩm công nghiệp"
            ],
            [
                "name"      => "Sản xuất"
            ],
            [
                "name"      => "Spa / Làm đẹp"
            ],
            [
                "name"      => "Tài chính / Đầu tư"
            ],
            [
                "name"      => "Thiết kế đồ họa"
            ],
            [
                "name"      => "Thiết kế nội thất"
            ],
            [
                "name"      => "Thời trang"
            ],
            [
                "name"      => "Thư ký / Trợ lý"
            ],
            [
                "name"      => "Thực phẩm / Đồ uống"
            ],
            [
                "name"      => "Tổ chức sự kiện / Quà tặng"
            ],
            [
                "name"      => "Tư vấn"
            ],
            [
                "name"      => "Vận tải / Kho vận"
            ],
            [
                "name"      => "Xây dựng"
            ],
            [
                "name"      => "Xuất nhập khẩu"
            ],
            [
                "name"      => "Y tế / Dược"
            ],
            [
                "name"      => "Thuê ngoài"
            ]
        ];

        Industry::query()
            ->insert($data);
    }
}
