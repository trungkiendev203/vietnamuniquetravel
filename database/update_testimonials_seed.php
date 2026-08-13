<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Functions.php';

use App\Config\Database;

$db = Database::getConnection();

// Reset and insert 8 rich testimonials
$db->exec("DELETE FROM testimonials");

$testimonials = [
    [
        'id' => 1,
        'client_name' => 'Sarah Jenkins',
        'client_country' => 'Australia',
        'client_avatar' => '',
        'rating' => 5,
        'tour_name' => 'Hidden Villages & Hieu Waterfall Adventure',
        'content_en' => 'An extraordinary experience in Pu Luong! The bamboo rafting on Cham stream and the high village of Son Ba Muoi exceeded our expectations. The local guide was super attentive!',
        'content_vi' => 'Một trải nghiệm phi thường tại Pù Luông! Chèo bè tre trên dòng suối Chàm và bản trên cao Son Bá Mười đẹp vượt ngoài mong đợi. Hướng dẫn viên bản địa rất chu đáo!',
        'is_featured' => 1,
        'sort_order' => 1
    ],
    [
        'id' => 2,
        'client_name' => 'Marcus Thorne',
        'client_country' => 'Germany',
        'client_avatar' => '',
        'rating' => 5,
        'tour_name' => 'Summit Expedition: Conquer Pu Luong Peak',
        'content_en' => 'The trek to conquer Pu Luong Peak was challenging but deeply rewarding! The summit BBQ lunch and herbal foot soak afterwards was pure perfection.',
        'content_vi' => 'Chuyến leo đỉnh Pù Luông đầy thử thách nhưng vô cùng xứng đáng! Tiệc nướng BBQ trên đỉnh và ngâm chân thảo dược cuối ngày thật hoàn hảo.',
        'is_featured' => 1,
        'sort_order' => 2
    ],
    [
        'id' => 3,
        'client_name' => 'Elena & David Moreau',
        'client_country' => 'France',
        'client_avatar' => '',
        'rating' => 5,
        'tour_name' => 'Cham River Bamboo Rafting & Water Wheels',
        'content_en' => 'The craftsmanship of the giant bamboo water wheels and the peaceful river drift was the highlight of our Vietnam vacation. Pure serenity and authentic culture.',
        'content_vi' => 'Những cọn nước khổng lồ bằng tre và trải nghiệm lướt bè tre êm đềm trên sông là điểm nhấn tuyệt vời nhất trong kỳ nghỉ của chúng tôi. Rất đỗi bình yên.',
        'is_featured' => 1,
        'sort_order' => 3
    ],
    [
        'id' => 4,
        'client_name' => 'Kenji Takahashi',
        'client_country' => 'Japan',
        'client_avatar' => '',
        'rating' => 5,
        'tour_name' => 'Mai Chau Emerald Valley Cycling',
        'content_en' => 'Cycling through tranquil rice fields and staying in a traditional White Thai stilt house gave us an unforgettable memory of Vietnamese hospitality.',
        'content_vi' => 'Đạp xe qua những cánh đồng lúa thanh bình và nghỉ tại nhà sàn người Thái Trắng đã để lại trong chúng tôi kỷ niệm khó quên về lòng hiếu khách của người Việt.',
        'is_featured' => 1,
        'sort_order' => 4
    ],
    [
        'id' => 5,
        'client_name' => 'Clara Lindqvist',
        'client_country' => 'Sweden',
        'client_avatar' => '',
        'rating' => 5,
        'tour_name' => 'Pu Luong Terraced Rice Fields Trek',
        'content_en' => 'Watching the golden sunrise over Don Village terraces was breathtaking. Vietnam Unique Travel handled every detail responsibly and professionally.',
        'content_vi' => 'Ngắm bình minh rực rỡ trên những thửa ruộng bậc thang Bản Đôn là khoảnh khắc kỳ diệu. Vietnam Unique Travel tổ chức cực kỳ chu đáo và chuyên nghiệp.',
        'is_featured' => 1,
        'sort_order' => 5
    ],
    [
        'id' => 6,
        'client_name' => 'James & Liam Wilson',
        'client_country' => 'United Kingdom',
        'client_avatar' => '',
        'rating' => 5,
        'tour_name' => 'Son Ba Muoi Highland Cloud Hunting',
        'content_en' => 'High above the clouds at 1,180m, the fresh mountain air and pristine hamlets felt like another world. The authentic home-cooked meals were delicious!',
        'content_vi' => 'Bản Son Bá Mười ở độ cao 1.180m quanh năm mây phủ như một thế giới thần tiên. Bữa cơm gia đình ấm cúng của người dân tộc Thái rất ngon và đậm vị!',
        'is_featured' => 1,
        'sort_order' => 6
    ],
    [
        'id' => 7,
        'client_name' => 'Isabella Rossi',
        'client_country' => 'Italy',
        'client_avatar' => '',
        'rating' => 5,
        'tour_name' => 'Kho Muong Cave & Bat Sanctuary Discovery',
        'content_en' => 'Trekking down into the secluded Kho Muong valley surrounded by dramatic limestone karsts was an adventure of a lifetime. Highly recommended!',
        'content_vi' => 'Hành trình khám phá thung lũng Kho Mường và hang dơi giữa những dãy núi đá vôi hùng vĩ là trải nghiệm tuyệt vời nhất đời tôi. Rất đáng để thử!',
        'is_featured' => 1,
        'sort_order' => 7
    ],
    [
        'id' => 8,
        'client_name' => 'Oliver & Mia Chen',
        'client_country' => 'Singapore',
        'client_avatar' => '',
        'rating' => 5,
        'tour_name' => 'Northern Frontier Cultural Immersion',
        'content_en' => 'A truly sustainable, authentic way to travel. We loved connecting with local craftsmen, weaving masters, and learning about traditional herbal remedies.',
        'content_vi' => 'Một chuyến đi chuẩn du lịch bền vững và giàu trải nghiệm. Chúng tôi rất thích được trò chuyện cùng các nghệ nhân dệt thổ cẩm và thử thảo dược bản địa.',
        'is_featured' => 1,
        'sort_order' => 8
    ]
];

$stmt = $db->prepare("INSERT INTO testimonials (id, client_name, client_country, client_avatar, rating, tour_name, content_en, content_vi, is_featured, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($testimonials as $t) {
    $stmt->execute([
        $t['id'], $t['client_name'], $t['client_country'], $t['client_avatar'],
        $t['rating'], $t['tour_name'], $t['content_en'], $t['content_vi'],
        $t['is_featured'], $t['sort_order']
    ]);
}

echo "Successfully seeded 8 rich testimonials!\n";
