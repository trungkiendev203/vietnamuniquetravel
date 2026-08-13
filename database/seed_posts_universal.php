<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/Functions.php';

$db = \App\Config\Database::getConnection();
$driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
echo "Active DB Driver: {$driver}\n";

// Add columns if missing
$cols = [
    'category' => 'VARCHAR(50) DEFAULT "experience"',
    'tags' => 'VARCHAR(255) DEFAULT ""',
    'destination_id' => 'INT DEFAULT 1',
    'read_time' => 'VARCHAR(50) DEFAULT "5 min read"'
];

foreach ($cols as $col => $def) {
    try {
        $db->exec("ALTER TABLE posts ADD COLUMN {$col} {$def}");
    } catch (Exception $e) {
        // already exists
    }
}

$db->exec("DELETE FROM post_translations");
$db->exec("DELETE FROM posts");

$articles = [
    [
        'id' => 1,
        'slug' => 'kinh-nghiem-du-lich-pu-luong-tu-a-den-z',
        'image' => '/assets/images/hero.webp',
        'category' => 'experience',
        'tags' => 'Pù Luông, Kinh Nghiệm, Săn Mây, Thác Hiêu',
        'destination_id' => 1,
        'read_time' => '6 min read',
        'published_at' => '2026-08-12 09:00:00',
        'vi_title' => 'Kinh nghiệm du lịch Pù Luông tự túc: Mùa lúa chín, đường đi & bản làng đẹp nhất',
        'vi_summary' => 'Tổng hợp tất tần tật kinh nghiệm khám phá Pù Luông: thời điểm săn mây, cung đường di chuyển, thác Hiêu, guồng nước và các bản làng người Thái bình yên.',
        'vi_content' => '<p class="lead-article-text">Nằm cách thủ đô Hà Nội khoảng 160km về phía Tây Nam, <strong>Khu bảo tồn thiên nhiên Pù Luông</strong> (Thanh Hóa) hiện lên như một bức tranh thủy mặc ngút ngàn với những thửa ruộng bậc thang kỳ vĩ, rừng nguyên sinh rậm rạp và những bản làng người Thái, người Mường ẩn mình trong làn mây trắng bồng bềnh.</p>
<div class="article-toc-box">
  <h4 class="toc-title">Danh mục bài viết</h4>
  <ul class="toc-list">
    <li><a href="#section-1">1. Thời điểm đẹp nhất để đến Pù Luông</a></li>
    <li><a href="#section-2">2. Hướng dẫn đường đi và phương tiện di chuyển</a></li>
    <li><a href="#section-3">3. Top những điểm check-in không thể bỏ lỡ</a></li>
    <li><a href="#section-4">4. Ăn gì ngon tại Pù Luông?</a></li>
    <li><a href="#section-5">5. Lưu ý quan trọng cho chuyến đi trọn vẹn</a></li>
  </ul>
</div>
<h2 id="section-1">1. Thời điểm đẹp nhất để đến Pù Luông</h2>
<p>Pù Luông có hai mùa lúa chín tuyệt đẹp trong năm: Tháng 5 - Tháng 6 và Tháng 9 - Tháng 10.</p>
<div class="article-image-block">
  <img src="/assets/images/hero.webp" alt="Ruộng bậc thang Pù Luông mùa lúa chín" loading="lazy">
  <p class="img-caption">Ảnh: Ruộng bậc thang Pù Luông rực rỡ sắc vàng mùa lúa chín</p>
</div>
<h2 id="section-2">2. Hướng dẫn đường đi và phương tiện di chuyển</h2>
<p>Từ Hà Nội, bạn có thể di chuyển bằng xe limousine hoặc phượt xe máy theo Quốc lộ 6 qua Mai Châu rồi rẽ sang đường 15C.</p>',
        'en_title' => 'Complete Pu Luong Travel Guide: Golden Rice Seasons, Hamlets & Secret Trails',
        'en_summary' => 'Everything you need to plan an authentic trip to Pu Luong Nature Reserve: best seasons for cloud hunting, cascading waterfalls, bamboo water wheels, and Thai ethnic culture.',
        'en_content' => '<p class="lead-article-text">Located 160km southwest of Hanoi, Pu Luong Nature Reserve is a pristine mountain retreat.</p>'
    ],
    [
        'id' => 2,
        'slug' => 'nghe-det-tho-cam-truyen-thong-nguoi-thai-mai-chau',
        'image' => '/assets/images/silk-weaving.webp',
        'category' => 'culture',
        'tags' => 'Mai Châu, Văn Hoá, Thổ Cẩm, Bản Lác',
        'destination_id' => 2,
        'read_time' => '5 min read',
        'published_at' => '2026-08-11 10:30:00',
        'vi_title' => 'Nghề dệt thổ cẩm truyền thống người Thái Mai Châu: Nét đẹp di sản dệt nên từ tâm huyết',
        'vi_summary' => 'Khám phá nghệ thuật dệt thổ cẩm thủ công tinh xảo của các mẹ, các chị người Thái tại Bản Lác và Poom Coọng.',
        'vi_content' => '<p class="lead-article-text">Giữa thung lũng Mai Châu thơ mộng, tiếng thoi đưa lách cách bên khung cửi dưới gầm nhà sàn đã trở thành nét đẹp văn hóa ngàn đời.</p>',
        'en_title' => 'Traditional Thai Brocade Weaving in Mai Chau: Living Heritage Woven with Soul',
        'en_summary' => 'Immerse in the intricate heritage of White Thai weavers in Mai Chau valley.',
        'en_content' => '<p class="lead-article-text">Brocade weaving represents the soul and identity of White Thai artisans in Mai Chau.</p>'
    ],
    [
        'id' => 3,
        'slug' => 'top-mon-ngon-dac-san-pu-luong-mai-chau',
        'image' => '/assets/images/beach-carousel-bg.webp',
        'category' => 'food',
        'tags' => 'Ẩm Thực, Vịt Cổ Lũng, Cơm Lam, Đặc Sản',
        'destination_id' => 1,
        'read_time' => '4 min read',
        'published_at' => '2026-08-10 14:15:00',
        'vi_title' => 'Top 7 món ngon đặc sản Pù Luông & Mai Châu: Vịt Cổ Lũng, cá suối nướng và cơm lam',
        'vi_summary' => 'Thưởng thức ẩm thực vùng cao độc đáo với vịt Cổ Lũng nướng than hoa, cá suối nướng lá dong, măng rừng xào tỏi và rượu cần thơm nồng.',
        'vi_content' => '<p class="lead-article-text">Ẩm thực Pù Luông níu chân du khách bởi nguồn nguyên liệu tươi ngon được nuôi trồng tự nhiên bên dòng suối mát lành.</p>',
        'en_title' => 'Top 7 Must-Try Ethnic Delicacies in Pu Luong & Mai Chau',
        'en_summary' => 'Taste the flavors of the Northwest highlands: savory Co Lung grilled duck, fresh stream fish wrapped in forest leaves, and fragrant bamboo sticky rice.',
        'en_content' => '<p class="lead-article-text">Discover organic mountain farm-to-table cuisine in Pu Luong.</p>'
    ],
    [
        'id' => 4,
        'slug' => 'trai-nghiem-cheo-be-tre-va-check-in-guong-nuoc-khong-lo',
        'image' => '/assets/images/bamboo-rafting.webp',
        'category' => 'activities',
        'tags' => 'Hoạt Động, Bè Tre, Guồng Nước, Sông Chăm',
        'destination_id' => 1,
        'read_time' => '5 min read',
        'published_at' => '2026-08-09 11:00:00',
        'vi_title' => 'Trải nghiệm chèo bè tre sông Chăm và chiêm ngưỡng guồng nước khổng lồ bản Công',
        'vi_summary' => 'Thả trôi bè tre dọc dòng suối Chăm trong vắt, lắng nghe tiếng nước róc rách và chiêm ngưỡng công trình dẫn thủy nhập điền độc đáo.',
        'vi_content' => '<p class="lead-article-text">Chèo bè tre thả trôi êm đềm dọc sông Chăm là trải nghiệm thư thái bậc nhất khi đặt chân đến Pù Luông.</p>',
        'en_title' => 'Authentic Bamboo Rafting on Cham River & Giant Water Wheels Discovery',
        'en_summary' => 'Glide peacefully on traditional bamboo rafts along Cham River and admire the majestic ancient water wheels.',
        'en_content' => '<p class="lead-article-text">Serene bamboo rafting adventures along Cham River.</p>'
    ],
    [
        'id' => 5,
        'slug' => 'top-homestay-nha-san-view-dep-nhat-pu-luong',
        'image' => '/assets/images/water-wheels.webp',
        'category' => 'stay',
        'tags' => 'Lưu Trú, Homestay, Nhà Sàn, Bản Đôn',
        'destination_id' => 1,
        'read_time' => '4 min read',
        'published_at' => '2026-08-08 16:45:00',
        'vi_title' => 'Top những homestay nhà sàn & retreat ngắm thung lũng lúa đẹp nhất Pù Luông',
        'vi_summary' => 'Gợi ý những địa điểm lưu trú nguyên bản, nhà sàn gỗ thoáng đãng nhìn thẳng ra ruộng bậc thang ngút ngàn tại Bản Đôn, Bản Kho Mường.',
        'vi_content' => '<p class="lead-article-text">Nghỉ ngơi tại những nếp nhà sàn truyền thống hướng trọn tầm nhìn ra thung lũng ruộng bậc thang.</p>',
        'en_title' => 'Top Scenic Stilt House Homestays & Eco-Retreats in Pu Luong',
        'en_summary' => 'Curated guide to charming wooden stilt homestays and eco-lodges with panoramic terraced rice field views in Don Village and Kho Muong.',
        'en_content' => '<p class="lead-article-text">Scenic eco-retreats and authentic homestays in Pu Luong.</p>'
    ],
    [
        'id' => 6,
        'slug' => 'du-lich-co-trach-nhiem-giu-gin-ve-dep-hoang-so-tay-bac',
        'image' => '/assets/images/hieu-waterfall.webp',
        'category' => 'news',
        'tags' => 'Tin Tức, Du Lịch Bền Vững, Bản Địa',
        'destination_id' => 1,
        'read_time' => '5 min read',
        'published_at' => '2026-08-07 08:20:00',
        'vi_title' => 'Du lịch có trách nhiệm: Cùng Vietnam Unique Travel gìn giữ nét hoang sơ Tây Bắc',
        'vi_summary' => 'Những nguyên tắc vàng khi ghé thăm các bản làng dân tộc: tôn trọng phong tục tập quán, giảm thiểu rác thải nhựa và ủng hộ sinh kế địa phương.',
        'vi_content' => '<p class="lead-article-text">Du lịch có trách nhiệm là tôn chỉ hành động trong mọi hành trình của Vietnam Unique Travel.</p>',
        'en_title' => 'Responsible Travel: Preserving the Pristine Beauty of Northern Vietnam',
        'en_summary' => 'Golden principles for mindful travelers: supporting indigenous communities, eliminating single-use plastics, and honoring sacred cultural traditions.',
        'en_content' => '<p class="lead-article-text">Mindful travel and sustainability in Vietnam highlands.</p>'
    ],
    [
        'id' => 7,
        'slug' => 'kham-pha-cho-phien-pho-doan-pu-luong',
        'image' => '/assets/images/silk-weaving.webp',
        'category' => 'culture',
        'tags' => 'Chợ Phiên, Phố Đòn, Bản Sắc, Trải Nghiệm',
        'destination_id' => 1,
        'read_time' => '4 min read',
        'published_at' => '2026-08-06 09:30:00',
        'vi_title' => 'Khám phá chợ phiên Phố Đòn: Nét sinh hoạt văn hóa rực rỡ sắc màu vùng cao Pù Luông',
        'vi_summary' => 'Chợ phiên họp vào sáng thứ 5 và Chủ Nhật hàng tuần tại xã Lũng Niêm, nơi tụ hội văn hóa của đồng bào các dân tộc Thái, Mường.',
        'vi_content' => '<p class="lead-article-text">Chợ phiên Phố Đòn rực rỡ sắc màu thổ cẩm và hương thơm của các món bánh vùng cao.</p>',
        'en_title' => 'Exploring Pho Doan Highland Market: Vibrant Sunday Colors of Pu Luong',
        'en_summary' => 'Experience the bustling atmosphere of Pho Doan local market every Thursday and Sunday morning.',
        'en_content' => '<p class="lead-article-text">Vibrant ethnic culture at Pho Doan Highland Market.</p>'
    ],
    [
        'id' => 8,
        'slug' => 'bi-quyet-chuan-bi-hanh-ly-trekking-tay-bac-gon-nhe',
        'image' => '/assets/images/hero.webp',
        'category' => 'experience',
        'tags' => 'Kinh Nghiệm, Trekking, Hành Lý, Chuẩn Bị',
        'destination_id' => 1,
        'read_time' => '4 min read',
        'published_at' => '2026-08-05 15:00:00',
        'vi_title' => 'Bí quyết chuẩn bị hành lý trekking Tây Bắc gọn nhẹ, an toàn và đầy đủ tiện ích',
        'vi_summary' => 'Hướng dẫn chi tiết cách chọn giày leo núi bám tốt, trang phục thoáng khí, vật dụng chống vắt và đồ sơ cứu y tế cần thiết.',
        'vi_content' => '<p class="lead-article-text">Một hành lý gọn gàng và phù hợp là chìa khóa để chuyến trekking băng rừng lội suối trở nên nhẹ nhàng.</p>',
        'en_title' => 'Smart Packing Guide for Trekking in Northern Vietnam Highlands',
        'en_summary' => 'Essential gear checklist for hiking enthusiasts: breathable layers, waterproof footwear, trail snacks, and lightweight daypack essentials.',
        'en_content' => '<p class="lead-article-text">Smart packing guide for Vietnam trekking adventures.</p>'
    ]
];

$stmtPost = $db->prepare("INSERT INTO posts (id, slug, featured_image, category, tags, destination_id, read_time, is_featured, status, views, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1, 150, ?)");
$stmtTrans = $db->prepare("INSERT INTO post_translations (post_id, lang, title, summary, content, seo_title, seo_description) VALUES (?, ?, ?, ?, ?, ?, ?)");

foreach ($articles as $a) {
    $stmtPost->execute([
        $a['id'],
        $a['slug'],
        $a['image'],
        $a['category'],
        $a['tags'],
        $a['destination_id'],
        $a['read_time'],
        $a['published_at']
    ]);

    // VI
    $stmtTrans->execute([
        $a['id'],
        'vi',
        $a['vi_title'],
        $a['vi_summary'],
        $a['vi_content'],
        $a['vi_title'],
        $a['vi_summary']
    ]);

    // EN
    $stmtTrans->execute([
        $a['id'],
        'en',
        $a['en_title'],
        $a['en_summary'],
        $a['en_content'],
        $a['en_title'],
        $a['en_summary']
    ]);
}

echo "Successfully seeded " . count($articles) . " articles across all translations!\n";
