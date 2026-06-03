<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy admin user đầu tiên làm tác giả (hoặc null nếu chưa có)
        $author = User::first();

        $posts = [
            // ── SẢN PHẨM ──────────────────────────────────────────────────
            [
                'category'   => 'san-pham',
                'title'      => 'Ra mắt nước rửa chén SOCCON hương quế — sạch mạnh, dịu tay',
                'excerpt'    => 'SOCCON chính thức giới thiệu dòng nước rửa chén mới với công thức X2 sức mạnh, kết hợp hương quế ấm áp tự nhiên, an toàn cho da tay.',
                'content'    => '<h2>Giới thiệu sản phẩm</h2><p>Nước rửa chén SOCCON hương quế là sản phẩm mới nhất trong dòng hoá phẩm gia dụng của thương hiệu SOCCON Living Well. Với công thức được cải tiến, sản phẩm mang lại hiệu quả làm sạch gấp đôi so với thế hệ trước.</p><h2>Điểm nổi bật</h2><ul><li>Công thức X2 sức mạnh, loại bỏ dầu mỡ nhanh chóng</li><li>Hương quế ấm áp, tự nhiên từ tinh dầu</li><li>Dịu nhẹ với da tay, không gây khô ráp</li><li>Khử mùi tanh từ hải sản hiệu quả</li></ul><h2>Phù hợp với ai?</h2><p>Sản phẩm phù hợp cho các gia đình, quán ăn và nhà hàng cần giải pháp rửa chén hiệu quả, tiết kiệm thời gian mà vẫn đảm bảo an toàn cho người sử dụng.</p><blockquote>Một không gian bếp sạch bắt đầu từ những sản phẩm đúng đắn — SOCCON Living Well.</blockquote>',
                'tags'       => ['nước rửa chén', 'SOCCON', 'sản phẩm mới', 'hương quế'],
                'read_time'  => 3,
                'published_at' => now()->subDays(2),
            ],
            [
                'category'   => 'san-pham',
                'title'      => 'Tẩy lồng máy giặt SOCCON — loại bỏ 99.9% cặn bẩn chỉ 1 lần dùng',
                'excerpt'    => 'Máy giặt bẩn là nguyên nhân quần áo có mùi hôi dù đã giặt. SOCCON ra mắt sản phẩm tẩy lồng chuyên dụng giải quyết triệt để vấn đề này.',
                'content'    => '<h2>Vì sao máy giặt cần được vệ sinh định kỳ?</h2><p>Theo các chuyên gia, máy giặt cần được vệ sinh lồng ít nhất 1 lần/tháng. Cặn bẩn, vi khuẩn và nấm mốc tích tụ bên trong lồng giặt chính là nguyên nhân khiến quần áo sau khi giặt vẫn có mùi khó chịu.</p><h2>SOCCON giải quyết như thế nào?</h2><ul><li>Công thức enzyme đặc biệt phân giải cặn bẩn</li><li>Loại bỏ đến 99.9% vi khuẩn và nấm mốc</li><li>Khử mùi hôi từ bên trong lồng máy</li><li>Phù hợp cả máy giặt cửa trước và cửa trên</li></ul><h2>Cách sử dụng</h2><p>Đổ 1 gói vào lồng máy, chọn chế độ vệ sinh hoặc chế độ giặt thông thường ở nhiệt độ 60°C. Chạy một chu kỳ đầy đủ là xong.</p>',
                'tags'       => ['máy giặt', 'tẩy lồng', 'SOCCON', 'vệ sinh'],
                'read_time'  => 4,
                'published_at' => now()->subDays(5),
            ],
            [
                'category'   => 'san-pham',
                'title'      => 'PINKMEE ra mắt bộ dưỡng ẩm da mặt từ hoa hồng Bulgaria',
                'excerpt'    => 'Bộ đôi serum và kem dưỡng chiết xuất hoa hồng Bulgaria từ PINKMEE — giải pháp cấp ẩm chuyên sâu cho làn da căng mịn suốt 24 giờ.',
                'content'    => '<h2>Hoa hồng Bulgaria — Vàng của làng mỹ phẩm</h2><p>Hoa hồng Bulgaria (Rosa Damascena) được thu hoạch tại Thung lũng hoa hồng ở Bulgaria, nổi tiếng là nguyên liệu quý hiếm trong ngành mỹ phẩm cao cấp thế giới. PINKMEE tự hào là một trong những thương hiệu Việt Nam đầu tiên đưa nguyên liệu này vào sản phẩm.</p><h2>Bộ sản phẩm bao gồm</h2><ul><li>Serum hoa hồng 30ml — cấp ẩm tức thì, thấm nhanh trong 30 giây</li><li>Kem dưỡng ngày SPF 20 50ml — bảo vệ và dưỡng ẩm suốt ngày</li><li>Kem dưỡng đêm 50ml — phục hồi da khi ngủ</li></ul><blockquote>Làn da của bạn xứng đáng được chăm sóc bằng những gì tốt nhất từ thiên nhiên.</blockquote>',
                'tags'       => ['PINKMEE', 'dưỡng da', 'hoa hồng', 'sản phẩm mới'],
                'read_time'  => 5,
                'published_at' => now()->subDays(8),
            ],

            // ── KHUYẾN MÃI ────────────────────────────────────────────────
            [
                'category'   => 'khuyen-mai',
                'title'      => 'Flash Sale cuối tuần — Giảm đến 40% toàn bộ sản phẩm SOCCON',
                'excerpt'    => 'Chỉ từ thứ 6 đến chủ nhật hàng tuần, toàn bộ sản phẩm SOCCON giảm giá sốc đến 40%. Số lượng có hạn, nhanh tay kẻo hết!',
                'content'    => '<h2>Chương trình Flash Sale cuối tuần</h2><p>Mỗi cuối tuần, SOCCON Living Well tổ chức chương trình Flash Sale đặc biệt với mức giảm giá hấp dẫn lên đến 40% cho toàn bộ danh mục sản phẩm. Đây là cơ hội tuyệt vời để bạn trải nghiệm các sản phẩm chăm sóc gia đình chất lượng cao với mức giá ưu đãi nhất.</p><h2>Sản phẩm tham gia Flash Sale</h2><ul><li>Nước rửa chén SOCCON — Giảm 30%</li><li>Nước lau sàn SOCCON — Giảm 35%</li><li>Bộ combo vệ sinh bếp — Giảm 40%</li><li>Tẩy lồng máy giặt — Giảm 25%</li></ul><h2>Điều kiện áp dụng</h2><p>Chương trình áp dụng cho tất cả khách hàng, không giới hạn số lượng đơn hàng. Giao hàng miễn phí cho đơn từ 200.000đ.</p>',
                'tags'       => ['flash sale', 'khuyến mãi', 'giảm giá', 'SOCCON'],
                'read_time'  => 3,
                'published_at' => now()->subDays(1),
            ],
            [
                'category'   => 'khuyen-mai',
                'title'      => 'Mua combo tiết kiệm — Nhận ngay quà tặng hấp dẫn từ PINKMEE',
                'excerpt'    => 'Mua bất kỳ bộ 3 sản phẩm PINKMEE trở lên, nhận ngay mini serum hoa hồng trị giá 150.000đ hoàn toàn miễn phí.',
                'content'    => '<h2>Chương trình quà tặng kèm PINKMEE</h2><p>Trong tháng này, khi bạn mua bất kỳ combo 3 sản phẩm PINKMEE trở lên, bạn sẽ nhận được ngay mini serum hoa hồng Bulgaria 10ml trị giá 150.000đ hoàn toàn miễn phí.</p><h2>Combo gợi ý</h2><ul><li>Combo Dưỡng Ẩm: Serum + Kem ngày + Kem đêm</li><li>Combo Chăm Sóc Tóc: Dầu gội + Dầu xả + Dầu dưỡng tóc</li><li>Combo Làm Sạch: Nước tẩy trang + Sữa rửa mặt + Toner</li></ul>',
                'tags'       => ['PINKMEE', 'combo', 'quà tặng', 'khuyến mãi'],
                'read_time'  => 3,
                'published_at' => now()->subDays(3),
            ],

            // ── KIẾN THỨC ─────────────────────────────────────────────────
            [
                'category'   => 'kien-thuc',
                'title'      => '5 mẹo giặt đồ đúng cách để quần áo bền màu, không co rút',
                'excerpt'    => 'Giặt đồ tưởng đơn giản nhưng nếu làm sai cách có thể khiến quần áo phai màu, co rút hoặc hỏng vải chỉ sau vài lần giặt.',
                'content'    => '<h2>1. Phân loại quần áo trước khi giặt</h2><p>Luôn phân loại quần áo theo màu sắc (trắng, sáng, tối) và chất liệu vải trước khi cho vào máy giặt. Tránh giặt chung quần áo trắng với đồ màu để hạn chế lem màu.</p><h2>2. Đọc nhãn hướng dẫn trên quần áo</h2><p>Mỗi loại vải có chế độ giặt phù hợp riêng. Nhãn hướng dẫn giặt thường ghi rõ nhiệt độ nước, có thể sử dụng máy sấy không, có thể ủi hay không.</p><h2>3. Chọn nhiệt độ nước phù hợp</h2><ul><li>30°C: Vải mỏng, đồ màu dễ phai</li><li>40°C: Quần áo thông thường</li><li>60°C: Đồ lót, khăn tắm, đồ trẻ em</li></ul><h2>4. Không cho quá nhiều bột giặt</h2><p>Bột giặt dư thừa không những không làm sạch hơn mà còn để lại cặn trên vải, gây cứng vải và kích ứng da. Dùng đúng liều lượng khuyến nghị.</p><h2>5. Phơi đồ đúng cách</h2><p>Phơi quần áo ở nơi thoáng gió, tránh ánh nắng trực tiếp với đồ màu. Lộn mặt trong ra ngoài khi phơi để tránh phai màu.</p>',
                'tags'       => ['giặt đồ', 'mẹo hay', 'kiến thức', 'quần áo'],
                'read_time'  => 5,
                'published_at' => now()->subDays(10),
            ],
            [
                'category'   => 'kien-thuc',
                'title'      => 'Sàn nhà luôn sạch bóng — Bí quyết lau sàn đúng kỹ thuật',
                'excerpt'    => 'Lau sàn không chỉ là đổ nước và lau. Kỹ thuật đúng giúp sàn sạch nhanh hơn, bóng hơn và giảm thiểu vết ố vàng theo thời gian.',
                'content'    => '<h2>Chọn đúng sản phẩm lau sàn</h2><p>Mỗi loại sàn (gỗ, đá hoa cương, gạch ceramic, vinyl) cần loại nước lau sàn phù hợp. Dùng sai sản phẩm có thể làm mờ bề mặt hoặc để lại cặn khó lau sạch.</p><h2>Nước lau sàn SOCCON phù hợp loại sàn nào?</h2><ul><li>Gạch ceramic, đá hoa cương — Tất cả hương</li><li>Sàn nhựa vinyl — Hương sả chanh</li><li>Sàn gỗ công nghiệp — Pha loãng 1:50 với nước</li></ul><h2>Kỹ thuật lau đúng cách</h2><p>Lau từ trong ra ngoài, từ góc khuất đến cửa ra vào. Thay nước lau thường xuyên (mỗi 20-25m²) để tránh lây vi khuẩn từ vùng bẩn sang vùng sạch.</p><blockquote>Một không gian sạch không chỉ là sạch về bề mặt, mà còn là cảm giác dễ chịu mỗi ngày — SOCCON Living Well.</blockquote>',
                'tags'       => ['lau sàn', 'mẹo hay', 'vệ sinh nhà', 'SOCCON'],
                'read_time'  => 4,
                'published_at' => now()->subDays(15),
            ],
            [
                'category'   => 'kien-thuc',
                'title'      => 'Da nhạy cảm nên dùng mỹ phẩm như thế nào cho đúng?',
                'excerpt'    => 'Da nhạy cảm cần được chăm sóc đặc biệt hơn. Hướng dẫn từ chuyên gia PINKMEE giúp bạn xây dựng chu trình skincare phù hợp.',
                'content'    => '<h2>Nhận biết da nhạy cảm</h2><p>Da nhạy cảm thường có các dấu hiệu: đỏ, ngứa, bong tróc khi tiếp xúc với sản phẩm mới; cảm giác căng và khó chịu sau khi rửa mặt; dễ bị kích ứng bởi thời tiết thay đổi.</p><h2>Nguyên tắc vàng cho da nhạy cảm</h2><ul><li>Ít thành phần — ít rủi ro kích ứng hơn</li><li>Tránh cồn, hương liệu nhân tạo, paraben</li><li>Patch test trước khi dùng sản phẩm mới</li><li>Giới thiệu từng sản phẩm một, không dùng nhiều loại cùng lúc</li></ul><h2>Chu trình PINKMEE cho da nhạy cảm</h2><p>Buổi sáng: Sữa rửa mặt dịu nhẹ → Toner không cồn → Serum dưỡng ẩm → Kem chống nắng khoáng SPF 50+. Buổi tối: Nước tẩy trang → Sữa rửa mặt → Kem dưỡng đêm phục hồi.</p>',
                'tags'       => ['da nhạy cảm', 'skincare', 'PINKMEE', 'mỹ phẩm'],
                'read_time'  => 6,
                'published_at' => now()->subDays(20),
            ],

            // ── CÔNG TY ───────────────────────────────────────────────────
            [
                'category'   => 'cong-ty',
                'title'      => 'Global Partner kỷ niệm 10 năm thành lập — Hành trình đáng nhớ',
                'excerpt'    => 'Nhìn lại 10 năm xây dựng và phát triển, Global Partner tự hào đã đồng hành cùng hàng nghìn gia đình Việt Nam với những sản phẩm chất lượng.',
                'content'    => '<h2>10 năm — Một hành trình đáng nhớ</h2><p>Ngày này 10 năm trước, Global Partner được thành lập với vỏn vẹn 5 nhân viên và một mong muốn đơn giản: mang đến những sản phẩm làm sạch tốt hơn cho người Việt. Hôm nay, chúng tôi tự hào nhìn lại hành trình đó với hơn 100 nhân viên, 2 thương hiệu mạnh và hàng chục nghìn khách hàng trung thành trên toàn quốc.</p><h2>Những cột mốc quan trọng</h2><ul><li>2014: Thành lập công ty tại Hà Nội</li><li>2016: Ra mắt thương hiệu SOCCON</li><li>2019: Mở rộng hệ thống phân phối 20 tỉnh thành</li><li>2021: Ra mắt thương hiệu PINKMEE</li><li>2024: 10 năm và hơn 5.000 khách hàng tin dùng</li></ul><blockquote>Cảm ơn tất cả khách hàng, đối tác và nhân viên đã đồng hành cùng chúng tôi trong suốt 10 năm qua.</blockquote>',
                'tags'       => ['kỷ niệm', 'công ty', 'Global Partner', '10 năm'],
                'read_time'  => 4,
                'published_at' => now()->subDays(7),
            ],
            [
                'category'   => 'cong-ty',
                'title'      => 'SOCCON Living Well chính thức mở rộng hệ thống đại lý toàn quốc',
                'excerpt'    => 'Từ tháng này, SOCCON Living Well bắt đầu nhận đơn đăng ký đại lý tại tất cả 63 tỉnh thành với chính sách hoa hồng hấp dẫn.',
                'content'    => '<h2>Chương trình đại lý SOCCON 2024</h2><p>Nhằm mở rộng độ phủ sóng và đưa sản phẩm đến tay người tiêu dùng trên toàn quốc, SOCCON Living Well chính thức triển khai chương trình tìm kiếm đại lý phân phối tại 63 tỉnh thành Việt Nam.</p><h2>Quyền lợi đại lý</h2><ul><li>Chiết khấu từ 15-30% tùy sản lượng</li><li>Hỗ trợ vật tư trưng bày miễn phí</li><li>Đào tạo kiến thức sản phẩm</li><li>Hỗ trợ marketing địa phương</li><li>Ưu tiên giao hàng trong 24h</li></ul><h2>Điều kiện trở thành đại lý</h2><p>Có mặt bằng kinh doanh, cam kết doanh số tối thiểu 10 triệu/tháng, có khả năng thanh toán và lưu kho sản phẩm.</p>',
                'tags'       => ['đại lý', 'phân phối', 'SOCCON', 'tuyển dụng'],
                'read_time'  => 4,
                'published_at' => now()->subDays(12),
            ],
        ];

        foreach ($posts as $data) {
            Post::create([
                'title'        => $data['title'],
                'slug'         => Str::slug($data['title']) . '-' . Str::random(5),
                'excerpt'      => $data['excerpt'],
                'content'      => $data['content'],
                'thumbnail'    => null, // thay bằng đường dẫn ảnh thật nếu có
                'category'     => $data['category'],
                'tags'         => $data['tags'],
                'is_published' => true,
                'published_at' => $data['published_at'],
                'read_time'    => $data['read_time'],
                'views'        => rand(50, 500),
                'user_id'      => $author?->id,
            ]);
        }

        $this->command->info('✓ Đã tạo ' . count($posts) . ' bài viết mẫu.');
    }
}
