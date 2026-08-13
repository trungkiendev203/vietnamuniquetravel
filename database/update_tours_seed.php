<?php
/**
 * Update Tours and Categories seed data with clean editorial titles (No tour codes in title)
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Functions.php';

use App\Config\Database;

$db = Database::getConnection();

// 1. Categories
$categories = [
    [1, 'trekking', 'ph-footprints', '/assets/images/hero.webp', 1, 'Trekking', 'Trekking & Hiking', 'Trekking & Leo Núi'],
    [2, 'adventure', 'ph-motorbike', '/assets/images/water-wheels.webp', 2, 'Adventure', 'Motorbike & Adventure', 'Xe Máy & Phiêu Lưu'],
    [3, 'cultural', 'ph-house-line', '/assets/images/silk-weaving.webp', 3, 'Cultural', 'Culture & Heritage', 'Văn Hóa Bản Địa'],
    [4, 'nature', 'ph-waves', '/assets/images/hieu-waterfall.webp', 4, 'Nature', 'Nature & Waterfalls', 'Thiên Nhiên & Thác Nước'],
    [5, 'local-life', 'ph-users-three', '/assets/images/silk-weaving.webp', 5, 'Local Life', 'Local Life & Community', 'Đời Sống Bản Địa'],
    [6, 'private', 'ph-shield-check', '/assets/images/bamboo-rafting.webp', 6, 'Private', 'Private & Tailored Journeys', 'Hành Trình Riêng Biệt']
];

foreach ($categories as $cat) {
    $db->prepare("INSERT INTO categories (id, slug, icon, image, sort_order, status) 
                  VALUES (?, ?, ?, ?, ?, 1)
                  ON DUPLICATE KEY UPDATE slug = VALUES(slug), icon = VALUES(icon), image = VALUES(image), sort_order = VALUES(sort_order)")
       ->execute([$cat[0], $cat[1], $cat[2], $cat[3], $cat[4]]);
    
    $db->prepare("INSERT INTO category_translations (category_id, lang, name, description)
                  VALUES (?, 'en', ?, ?)
                  ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description)")
       ->execute([$cat[0], $cat[5], $cat[6]]);

    $db->prepare("INSERT INTO category_translations (category_id, lang, name, description)
                  VALUES (?, 'vi', ?, ?)
                  ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description)")
       ->execute([$cat[0], $cat[7], $cat[7]]);
}

// 2. Insert 12 Tours with Clean Editorial Titles
$tours = [
    [
        'id' => 1,
        'code' => 'PLHDT-01',
        'slug' => 'bike-tours-hidden-villages-hieu-waterfall-adventure',
        'destination_id' => 1,
        'duration_type' => 'halfday',
        'duration_days' => 1,
        'difficulty' => 'easy',
        'transportation' => 'Motorbike with local guide',
        'group_size' => '1-6 pax',
        'price_from_usd' => 22.00,
        'price_from_vnd' => 580000,
        'featured_image' => '/assets/images/hieu-waterfall.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 1,
        'sort_order' => 1,
        'cats' => [2, 1, 4],
        'en' => [
            'title' => 'Hidden Villages & Hieu Waterfall Adventure',
            'sub_title' => 'Half-Day Motorbike Journey to Son-Ba-Muoi Cloud Villages',
            'short_description' => 'Experience an inspiring half-day motorbike journey through high-altitude cloud villages of Son - Ba Muoi and immerse in petrified Hieu Waterfall.',
            'highlights' => "• Ride up to Son-Ba-Muoi village located 1,180m above sea level.\n• Explore scenic trails through rice terraces and traditional Thai stilt houses.\n• Discover Hieu Waterfall where limestone water petrifies objects.\n• Free time swimming in crystal-clear mountain pools.",
            'overview' => 'Son Ba Muoi village is nestled between craggy mountain ranges at an altitude of 1,180m, bringing virgin beauty.'
        ],
        'vi' => [
            'title' => 'Khám Phá Bản Ẩn Mình & Thác Hiêu Bằng Xe Máy',
            'sub_title' => 'Hành trình nửa ngày bằng xe máy qua Sơn – Bá Mười – Bản Hiêu',
            'short_description' => 'Trải nghiệm nửa ngày bằng xe máy vượt qua vùng cao Son Bá Mười bồng bềnh mây phủ và ngâm mình tại dòng thác Hiêu hóa đá kỳ thú.',
            'highlights' => "• Chinh phục bản Sơn Bá Mười ở độ cao 1.180m mát mẻ như Sa Pa.\n• Ngắm nhìn ruộng bậc thang và nếp nhà sàn người Thái ẩn hiện.\n• Khám phá thác Hiêu hóa đá độc đáo và tự do tắm suối.",
            'overview' => 'Sơn Bá Mười nằm ở độ cao 1.180m so với mực nước biển, bao bọc bởi những dãy núi đá vôi trập trùng.'
        ]
    ],
    [
        'id' => 2,
        'code' => 'PLHDT-02',
        'slug' => 'bike-tours-local-market-hidden-valley-discovery',
        'destination_id' => 1,
        'duration_type' => 'halfday',
        'duration_days' => 1,
        'difficulty' => 'easy',
        'transportation' => 'Motorbike or Private Car',
        'group_size' => '1-10 pax',
        'price_from_usd' => 20.00,
        'price_from_vnd' => 520000,
        'featured_image' => '/assets/images/hero.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 2,
        'sort_order' => 2,
        'cats' => [3, 5, 4],
        'en' => [
            'title' => 'Pho Doan Market & Lan Brocade Weaving Village',
            'sub_title' => 'Authentic Ethnic Highland Market & Traditional Thai Looms',
            'short_description' => 'Discover the vibrant authentic ethnic atmosphere of Doan Market, pristine Hieu Waterfall, Co Lung duck farm, and Thai brocade weaving artisans.',
            'highlights' => "• Visit traditional Doan Market trading Kinh, Muong & Thai goods.\n• Taste local street food delicacies and buy handmade souvenirs.\n• Trek to Hieu Waterfall and see famed Co Lung ducks.\n• Visit Lan Village brocade weaving artisans and try looms.",
            'overview' => 'Doan Market dates back to French colonial times, serving as a trading hub for Kinh, Muong, and Thai communities.'
        ],
        'vi' => [
            'title' => 'Chợ Phiên Phố Đoàn & Làng Dệt Thổ Cẩm Bản Lan',
            'sub_title' => 'Chợ Phố Đoàn – Bản Hiêu – Thác Hiêu – Bản Lan Dệt Thổ Cẩm',
            'short_description' => 'Hòa mình vào không khí chợ phiên Phố Đoàn rực rỡ sắc màu, ngắm thác Hiêu, trang trại vịt Cổ Lũng và làng dệt thổ cẩm truyền thống.',
            'highlights' => "• Ghé phiên chợ Phố Đoàn đậm chất vùng cao.\n• Thưởng thức ẩm thực đường phố và quà lưu niệm thủ công.\n• Trải nghiệm dệt thổ cẩm cùng nghệ nhân người Thái tại Bản Lan.",
            'overview' => 'Chợ Phố Đoàn là nơi giao thương văn hóa rực rỡ từ thời Pháp thuộc giữa đồng bào Thái, Mường, Kinh.'
        ]
    ],
    [
        'id' => 3,
        'code' => 'PLHDT-03',
        'slug' => 'trekking-tours-authentic-village-life-experience',
        'destination_id' => 1,
        'duration_type' => 'halfday',
        'duration_days' => 1,
        'difficulty' => 'easy',
        'transportation' => 'Trekking / Walking',
        'group_size' => '1-12 pax',
        'price_from_usd' => 25.00,
        'price_from_vnd' => 600000,
        'featured_image' => '/assets/images/silk-weaving.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 3,
        'sort_order' => 3,
        'cats' => [1, 3, 5],
        'en' => [
            'title' => 'Authentic Village Life & Organic Farm Trekking',
            'sub_title' => 'Scenic Walking Journey through Don & Uoi Valleys',
            'short_description' => 'Immerse in tranquil Black Thai ethnic communities, walking along terraced paths and visiting organic family farms and traditional herb gardens.',
            'highlights' => "• Walk through Don & Uoi ethnic Thai villages.\n• Learn ancient farming and herb medicine techniques.\n• Enjoy organic herbal tea with local host families.\n• Stunning valley views for photography.",
            'overview' => 'An easy-paced walking journey perfect for families and culture lovers seeking authentic contact with villagers.'
        ],
        'vi' => [
            'title' => 'Đời Sống Bản Làng & Đi Bộ Thung Lũng Bản Đôn',
            'sub_title' => 'Đi bộ qua Bản Đôn – Bản Ươi – Vườn Thảo Dược Hữu Cơ',
            'short_description' => 'Hòa mình vào nếp sống mộc mạc của đồng bào Thái Đen, dạo bước qua các thửa ruộng bậc thang và thăm vườn dược liệu gia đình.',
            'highlights' => "• Đi bộ thư thái qua bản Đôn và bản Ươi.\n• Tìm hiểu phương pháp canh tác và thảo dược cổ truyền.\n• Thưởng thức trà thảo mộc cùng bà con bản địa.",
            'overview' => 'Chuyến đi bộ nhẹ nhàng khám phá chiều sâu văn hóa và lối sống hài hòa cùng thiên nhiên của người Thái.'
        ]
    ],
    [
        'id' => 4,
        'code' => 'PLHDT-04',
        'slug' => 'car-bike-trekking-tours-threads-of-tradition',
        'destination_id' => 1,
        'duration_type' => 'halfday',
        'duration_days' => 1,
        'difficulty' => 'easy',
        'transportation' => 'Motorbike / Car + Bamboo Raft',
        'group_size' => '1-10 pax',
        'price_from_usd' => 35.00,
        'price_from_vnd' => 850000,
        'featured_image' => '/assets/images/bamboo-rafting.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 4,
        'sort_order' => 4,
        'cats' => [4, 2, 3],
        'en' => [
            'title' => 'Cham River Bamboo Rafting & Giant Water Wheels',
            'sub_title' => 'Hands-on Bamboo Rafting on Cham River & Ancient Water Wheels',
            'short_description' => 'Drift along calm crystal waters of Cham River on handmade bamboo rafts and witness monumental century-old bamboo water wheels.',
            'highlights' => "• Paddle authentic bamboo rafts down Cham river.\n• Inspect ingenious hydraulic bamboo water wheels.\n• Experience peaceful mountain river scenery.\n• Visit traditional riverside Thai settlements.",
            'overview' => 'A serene eco-adventure capturing the traditional hydraulic craftsmanship and tranquil river life of Pu Luong.'
        ],
        'vi' => [
            'title' => 'Chèo Bè Tre Suối Chàm & Guồng Nước Khổng Lồ',
            'sub_title' => 'Trải nghiệm chèo bè tre thủ công và chiêm ngưỡng cọn nước Pù Luông',
            'short_description' => 'Lướt nhẹ trên dòng suối Chàm trong vắt bằng bè tre mộc mạc và chiêm ngưỡng những guồng nước khổng lồ kỳ công của người Thái.',
            'highlights' => "• Tự tay chèo bè tre truyền thống trên suối Chàm.\n• Tìm hiểu nguyên lý hoạt động của cọn nước đưa nước lên đồng cao.\n• Khung cảnh non nước thơ mộng, không khí trong lành.",
            'overview' => 'Trải nghiệm du lịch sinh thái đậm chất sông nước vùng cao đầy thư thái và ấn tượng.'
        ]
    ],
    [
        'id' => 5,
        'code' => 'PLFDT-01',
        'slug' => 'medium-trekking-into-the-heart-of-pu-luong',
        'destination_id' => 1,
        'duration_type' => 'fullday',
        'duration_days' => 1,
        'difficulty' => 'medium',
        'transportation' => 'Trekking & Walking',
        'group_size' => '1-10 pax',
        'price_from_usd' => 31.00,
        'price_from_vnd' => 800000,
        'featured_image' => '/assets/images/water-wheels.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 5,
        'sort_order' => 5,
        'cats' => [1, 2, 4],
        'en' => [
            'title' => 'Deep Valley Trekking: Into the Heart of Pu Luong',
            'sub_title' => 'Full-Day 14km Trek across Kho Muong & Hidden Terraced Valleys',
            'short_description' => 'Hike deep into Kho Muong valley, explore the mysterious Bat Cave, traverse limestone passes and feast on traditional homecooked lunch.',
            'highlights' => "• 14km scenic trek across diverse mountain terrain.\n• Explore Kho Muong valley and limestone Bat Cave.\n• Authentic ethnic Thai homecooked lunch on stilt house.\n• Deep dive into primary rainforest and terrace networks.",
            'overview' => 'Our premier full-day trekking route designed for active travelers wanting to see the virgin core of Pu Luong Nature Reserve.'
        ],
        'vi' => [
            'title' => 'Trekking Xuyên Thung Lũng Trái Tim Pù Luông',
            'sub_title' => 'Hành trình 14km khám phá Bản Kho Mường, Hang Dơi và thung lũng lúa',
            'short_description' => 'Đi bộ sâu vào lòng thung lũng Kho Mường hoang sơ, thám hiểm Hang Dơi kỳ bí và thưởng thức bữa trưa đậm đà bản sắc người Thái.',
            'highlights' => "• Cung đường trekking 14km qua các địa hình đa dạng.\n• Khám phá bản Kho Mường cô lập và Hang Dơi kỳ vĩ.\n• Bữa trưa đặc sản nướng trên nhà sàn truyền thống.",
            'overview' => 'Hành trình trekking hoàn hảo cho du khách yêu thiên nhiên và mong muốn thử thách thể lực vừa phải.'
        ]
    ],
    [
        'id' => 6,
        'code' => 'PLFDT-02',
        'slug' => 'bike-car-short-trekking-pu-luong-signature-experience',
        'destination_id' => 1,
        'duration_type' => 'fullday',
        'duration_days' => 1,
        'difficulty' => 'easy',
        'transportation' => 'Motorbike or Car + Bamboo Raft',
        'group_size' => '1-12 pax',
        'price_from_usd' => 43.00,
        'price_from_vnd' => 1130000,
        'featured_image' => '/assets/images/hero.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 6,
        'sort_order' => 6,
        'cats' => [4, 3, 6],
        'en' => [
            'title' => 'Pu Luong Signature Panorama: All-in-One Experience',
            'sub_title' => 'Full-Day Waterfalls, Rice Terraces, Bamboo Rafts & High Cloud Villages',
            'short_description' => 'The ultimate curated all-in-one day: visit Son-Ba-Muoi clouds, Hieu waterfall swimming, bamboo rafting on Cham river, and silk weaving.',
            'highlights' => "• Complete highlights of Pu Luong in a single seamless day.\n• Son-Ba-Muoi cloud village viewpoint at 1,180m.\n• Swim at cascading Hieu Waterfall.\n• Romantic bamboo raft river drift.",
            'overview' => 'Perfect for travelers with limited time who want to experience the finest highlights of Pu Luong with premium comfort.'
        ],
        'vi' => [
            'title' => 'Hành Trình Tinh Hoa Pù Luông: Trọn Vẹn 1 Ngày',
            'sub_title' => 'Trọn vẹn Thác Hiêu, Bản Son Bá Mười, Bè Tre & Làng Dệt',
            'short_description' => 'Chuyến đi hoàn hảo kết hợp đầy đủ nét tinh hoa: săn mây Son Bá Mười, tắm thác Hiêu, chèo bè tre suối Chàm và trải nghiệm dệt thổ cẩm.',
            'highlights' => "• Gói trọn tinh hoa Pù Luông trong 1 ngày thoải mái.\n• Điểm ngắm cảnh mây mù Son Bá Mười 1.180m.\n• Tắm thác Hiêu mát lành và đi bè tre suối Chàm.",
            'overview' => 'Lựa chọn lý tưởng cho các gia đình và nhóm bạn muốn tận hưởng trọn vẹn cảnh sắc Pù Luông.'
        ]
    ],
    [
        'id' => 7,
        'code' => 'PLFDT-03',
        'slug' => 'hard-trekking-tours-conquer-pu-luong-peak',
        'destination_id' => 1,
        'duration_type' => 'fullday',
        'duration_days' => 1,
        'difficulty' => 'hard',
        'transportation' => 'Trekking / Mountain Climbing',
        'group_size' => '1-8 pax',
        'price_from_usd' => 34.00,
        'price_from_vnd' => 900000,
        'featured_image' => '/assets/images/hero.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 7,
        'sort_order' => 7,
        'cats' => [1, 2, 4],
        'en' => [
            'title' => 'Summit Expedition: Conquer Pu Luong Peak (1,700m)',
            'sub_title' => 'Full-Day Mountain Summit Trekking & Panoramic Cloudview BBQ',
            'short_description' => 'Challenge yourself conquering the highest summit of Pu Luong at 1,700m, traversing ancient primary jungle and celebrating with peak BBQ lunch.',
            'highlights' => "• Conquer highest peak of Pu Luong (1,700m elevation).\n• Pristine primary oak and bamboo forests.\n• Panoramic 360-degree mountain & cloud ridge views.\n• Summit mountain picnic & herbal foot soak finish.",
            'overview' => 'An exhilarating mountaineering adventure for experienced trekkers seeking untamed wilderness.'
        ],
        'vi' => [
            'title' => 'Chinh Phục Đỉnh Núi Pù Luông 1.700m Hùng Vĩ',
            'sub_title' => 'Trekking đỉnh núi cao nhất Pù Luông và tiệc BBQ ngắm biển mây',
            'short_description' => 'Thử thách giới hạn bản thân khi chinh phục nóc nhà Pù Luông ở độ cao 1.700m, băng qua rừng nguyên sinh cổ thụ và thưởng thức tiệc nướng trên đỉnh.',
            'highlights' => "• Chinh phục đỉnh núi cao 1.700m ngoạn mục.\n• Băng qua rừng trúc và thảm thực vật nguyên sinh.\n• Tầm nhìn 360 độ ngắm biển mây bao la.\n• Ngâm chân thảo dược xua tan mệt mỏi cuối ngày.",
            'overview' => 'Hành trình leo núi đỉnh cao dành cho các bạn trẻ đam mê chinh phục thử thách.'
        ]
    ],
    [
        'id' => 8,
        'code' => 'MC-01',
        'slug' => 'mai-chau-valley-cycling-white-thai-culture',
        'destination_id' => 2,
        'duration_type' => 'multiday',
        'duration_days' => 2,
        'difficulty' => 'easy',
        'transportation' => 'Private Car & Mountain Bikes',
        'group_size' => '1-10 pax',
        'price_from_usd' => 145.00,
        'price_from_vnd' => 3650000,
        'featured_image' => '/assets/images/water-wheels.webp',
        'is_featured' => 1,
        'is_signature' => 0,
        'signature_number' => 8,
        'sort_order' => 8,
        'cats' => [3, 5, 4],
        'en' => [
            'title' => 'Mai Chau Emerald Valley Cycling & White Thai Heritage',
            'sub_title' => '2 Days 1 Night Idyllic Stilt House Living & Traditional Folk Dance',
            'short_description' => 'Cycle through serene emerald rice valleys, stay overnight in a traditional White Thai wooden stilt house, and enjoy ethnic music and culinary treats.',
            'highlights' => "• Scenic cycling through Lac, Pom Coong & Van villages.\n• Overnight at charming traditional stilt house homestay.\n• Enjoy White Thai traditional bamboo dance & Ruou Can wine.\n• Hand-weaving textile workshops with local artisans.",
            'overview' => 'An authentic peaceful escape into the pastoral valley of Mai Chau, blending cycling, culture, and hospitable family warmth.'
        ],
        'vi' => [
            'title' => 'Đạp Xe Thung Lũng Mai Châu & Văn Hóa Người Thái Trắng',
            'sub_title' => '2 Ngày 1 Đêm Lưu Trú Nhà Sàn & Thưởng Thức Múa Xòe Thái',
            'short_description' => 'Đạp xe qua những thung lũng lúa xanh mướt, nghỉ đêm tại nhà sàn gỗ truyền thống người Thái Trắng và hòa mình vào điệu múa sạp rộn ràng.',
            'highlights' => "• Đạp xe qua Bản Lác, Pom Coọng và bản Vặn yên bình.\n• Nghỉ đêm tại nhà sàn ấm cúng cùng gia đình bản địa.\n• Thưởng thức rượu cần và chương trình múa xòe cổ truyền.",
            'overview' => 'Chuyến nghỉ dưỡng nhẹ nhàng tìm về không gian nông thôn thanh bình và mến khách.'
        ]
    ],
    [
        'id' => 9,
        'code' => 'NB-01',
        'slug' => 'ninh-binh-trang-an-karst-sanctuary-riverboat',
        'destination_id' => 3,
        'duration_type' => 'multiday',
        'duration_days' => 2,
        'difficulty' => 'easy',
        'transportation' => 'Private Car & Traditional Sampan',
        'group_size' => '1-12 pax',
        'price_from_usd' => 165.00,
        'price_from_vnd' => 4150000,
        'featured_image' => '/assets/images/bamboo-rafting.webp',
        'is_featured' => 1,
        'is_signature' => 0,
        'signature_number' => 9,
        'sort_order' => 9,
        'cats' => [4, 3, 2],
        'en' => [
            'title' => 'Ninh Binh Karst Sanctuary & Sacred Riverboat Odyssey',
            'sub_title' => '2 Days 1 Night Trang An UNESCO Caves, Tam Coc & Hang Mua Peak',
            'short_description' => 'Glide through mystical water caves in Trang An UNESCO World Heritage, climb 500 stone steps to Hang Mua dragon viewpoint and cycle rural lanes.',
            'highlights' => "• Traditional sampan boat cruise through Trang An grottoes.\n• Climb Hang Mua Dragon mountain for breathtaking vistas.\n• Cycle along peaceful lotus ponds and limestone karsts.\n• Visit ancient capital Hoa Lu and sacred temples.",
            'overview' => 'Discover the legendary Ha Long Bay on land with secluded eco-trails avoiding large tour crowds.'
        ],
        'vi' => [
            'title' => 'Kỳ Quan Tràng An Ninh Bình & Hành Trình Thuyền Rồng',
            'sub_title' => '2 Ngày 1 Đêm Khám Phá Di Sản Tràng An, Tam Cốc & Đỉnh Hang Múa',
            'short_description' => 'Lướt thuyền nan qua quần thể hang động Tràng An huyền ảo, chinh phục 500 bậc đá Hang Múa ngắm trọn vẹn Tam Cốc từ trên cao.',
            'highlights' => "• Đi thuyền nan xuyên qua hệ thống hang động Tràng An.\n• Chinh phục Đỉnh Hang Múa ngắm toàn cảnh sông núi hữu tình.\n• Đạp xe ngắm đầm sen và thăm cố đô Hoa Lư cổ kính.",
            'overview' => 'Hành trình di sản văn hóa và thiên nhiên thế giới độc đáo tại Ninh Bình.'
        ]
    ],
    [
        'id' => 10,
        'code' => 'PLMC-01',
        'slug' => 'pu-luong-mai-chau-heritage-trekking-trail',
        'destination_id' => 1,
        'duration_type' => 'multiday',
        'duration_days' => 3,
        'difficulty' => 'medium',
        'transportation' => 'Private Transport & Trekking',
        'group_size' => '1-10 pax',
        'price_from_usd' => 234.00,
        'price_from_vnd' => 5890000,
        'featured_image' => '/assets/images/hero.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 10,
        'sort_order' => 10,
        'cats' => [1, 4, 3],
        'en' => [
            'title' => 'Pu Luong & Mai Chau Mountain Heritage Trail',
            'sub_title' => '3 Days 2 Nights Cross-Regional Ridge Trekking, Bamboo Rafts & Eco-Lodges',
            'short_description' => 'Connect two iconic mountain valleys on an exclusive 3-day expedition featuring ridge trekking, mountain streams, bamboo rafting and eco-resort comfort.',
            'highlights' => "• Cross-border scenic trekking between Mai Chau and Pu Luong.\n• 2 nights in boutique mountain eco-lodges overlooking rice terraces.\n• Bamboo rafting along Cham river and waterfall swim.\n• Intimate cultural immersion with White Thai & Muong communities.",
            'overview' => 'Our flagship 3-day mountain expedition blending active trekking adventure with tasteful comfort and rich cultural storytelling.'
        ],
        'vi' => [
            'title' => 'Cung Đường Di Sản Ẩn Mình Pù Luông – Mai Châu',
            'sub_title' => '3 Ngày 2 Đêm Trekking Băng Đèo, Chèo Bè Tre & Nghỉ Dưỡng Sinh Thái',
            'short_description' => 'Hành trình 3 ngày kết nối hai thung lũng tuyệt đẹp: trekking băng rừng nguyên sinh, đi bè tre suối Chàm và nghỉ dưỡng tại eco-lodge nhìn ra thung lũng.',
            'highlights' => "• Tuyến trekking kết nối cảnh sắc Mai Châu và Pù Luông.\n• 2 đêm nghỉ tại khu nghỉ dưỡng sinh thái sang trọng giữa thiên nhiên.\n• Trọn vẹn các trải nghiệm: tắm thác, chèo bè tre, ẩm thực núi rừng.",
            'overview' => 'Chương trình signature 3 ngày 2 đêm được yêu thích nhất của Vietnam Unique Travel.'
        ]
    ],
    [
        'id' => 11,
        'code' => 'HG-01',
        'slug' => 'ha-giang-loop-ma-pi-leng-canyon-expedition',
        'destination_id' => 4,
        'duration_type' => 'multiday',
        'duration_days' => 4,
        'difficulty' => 'medium',
        'transportation' => 'Private 4WD Car or Motorbike Easy Rider',
        'group_size' => '1-8 pax',
        'price_from_usd' => 385.00,
        'price_from_vnd' => 9700000,
        'featured_image' => '/assets/images/hieu-waterfall.webp',
        'is_featured' => 1,
        'is_signature' => 0,
        'signature_number' => 11,
        'sort_order' => 11,
        'cats' => [2, 4, 3],
        'en' => [
            'title' => 'Ha Giang Loop: Ma Pi Leng Canyon & Dong Van Karst Plateau',
            'sub_title' => '4 Days 3 Nights Legendary Mountain Passes & Emerald Nho Que River',
            'short_description' => 'Explore Vietnam ultimate northern frontier: conquer Ma Pi Leng Pass, boat through Tu San Canyon, and witness the vibrant colors of Hmong and Dao markets.',
            'highlights' => "• Conquer legendary Ma Pi Leng Pass and Sky Walk cliff trail.\n• Emerald boat cruise through Tu San Canyon on Nho Que river.\n• Dong Van ancient town and Hmong King Palace history.\n• Authentic homestays with warm ethnic minority hosts.",
            'overview' => 'The ultimate mountain road trip through UNESCO Dong Van Karst Geopark with our expert local navigators.'
        ],
        'vi' => [
            'title' => 'Hùng Vĩ Hà Giang: Hẻm Vực Mã Pí Lèng & Cao Nguyên Đá',
            'sub_title' => '4 Ngày 3 Đêm Khám Phá Tứ Đại Đỉnh Đèo & Dòng Sông Nho Quế',
            'short_description' => 'Khám phá mảnh đất địa đầu Tổ quốc: chinh phục đèo Mã Pí Lèng, chèo thuyền hẻm vực Tu Sản sông Nho Quế và hòa mình vào sắc màu văn hóa H\'Mông.',
            'highlights' => "• Chinh phục cung đường đèo Mã Pí Lèng huyền thoại.\n• Du thuyền ngắm hẻm vực Tu Sản sâu nhất Đông Nam Á.\n• Thăm phố cổ Đồng Văn và Dinh thự Vua Mèo cổ kính.",
            'overview' => 'Chuyến phiêu lưu đáng nhớ nhất trên cung đường cao nguyên đá hùng vĩ.'
        ]
    ],
    [
        'id' => 12,
        'code' => 'NVN-01',
        'slug' => 'grand-northern-vietnam-karsts-valleys-ethnic-odyssey',
        'destination_id' => 4,
        'duration_type' => 'multiday',
        'duration_days' => 7,
        'difficulty' => 'easy',
        'transportation' => 'Luxury Private Limousine & Private Guide',
        'group_size' => '1-8 pax',
        'price_from_usd' => 750.00,
        'price_from_vnd' => 18900000,
        'featured_image' => '/assets/images/hero.webp',
        'is_featured' => 1,
        'is_signature' => 1,
        'signature_number' => 12,
        'sort_order' => 12,
        'cats' => [2, 6, 3],
        'en' => [
            'title' => 'Grand Northern Vietnam: Karsts, Valleys & Living Traditions',
            'sub_title' => '7 Days 6 Nights Bespoke Private Journey: Hanoi – Mai Chau – Pu Luong – Ninh Binh',
            'short_description' => 'A comprehensive 7-day luxury private journey combining northern Vietnam most breathtaking destinations: emerald valleys, pristine nature reserves and karst rivers.',
            'highlights' => "• Fully customizable private limousine and dedicated travel curator.\n• 6 nights luxury boutique eco-resorts with panoramic mountain views.\n• Curated culinary banquets featuring fresh organic ethnic delicacies.\n• Exclusive off-the-grid cultural experiences with community leaders.",
            'overview' => 'Our ultimate comprehensive grand journey designed for discerning international travelers seeking authenticity without compromising comfort.'
        ],
        'vi' => [
            'title' => 'Đại Hành Trình Miền Bắc: Vòng Cung Kỳ Vĩ & Văn Hóa Bản Địa',
            'sub_title' => '7 Ngày 6 Đêm Tour Riêng Cao Cấp: Hà Nội – Mai Châu – Pù Luông – Ninh Bình',
            'short_description' => 'Hành trình 7 ngày cao cấp kết nối các điểm đến đẹp nhất miền Bắc: thung lũng Mai Châu, thiên nhiên hoang sơ Pù Luông và non nước Tràng An Ninh Bình.',
            'highlights' => "• Xe riêng Limousine cao cấp và Hướng dẫn viên chuyên nghiệp riêng.\n• 6 đêm nghỉ dưỡng tại các Resort/Eco-lodge sang trọng nhất.\n• Thưởng thức tinh hoa ẩm thực địa phương được chế biến tinh tế.",
            'overview' => 'Hành trình tinh hoa bậc nhất dành cho du khách muốn khám phá trọn vẹn vẻ đẹp miền Bắc Việt Nam.'
        ]
    ]
];

foreach ($tours as $t) {
    $db->prepare("INSERT INTO tours (id, code, slug, destination_id, duration_type, duration_days, difficulty, transportation, group_size, price_from_usd, price_from_vnd, featured_image, is_featured, is_signature, signature_number, sort_order, status)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
                  ON DUPLICATE KEY UPDATE 
                    code = VALUES(code),
                    slug = VALUES(slug),
                    destination_id = VALUES(destination_id),
                    duration_type = VALUES(duration_type),
                    duration_days = VALUES(duration_days),
                    difficulty = VALUES(difficulty),
                    transportation = VALUES(transportation),
                    group_size = VALUES(group_size),
                    price_from_usd = VALUES(price_from_usd),
                    price_from_vnd = VALUES(price_from_vnd),
                    featured_image = VALUES(featured_image),
                    is_featured = VALUES(is_featured),
                    is_signature = VALUES(is_signature),
                    signature_number = VALUES(signature_number),
                    sort_order = VALUES(sort_order),
                    status = 1")
       ->execute([
           $t['id'], $t['code'], $t['slug'], $t['destination_id'], $t['duration_type'],
           $t['duration_days'], $t['difficulty'], $t['transportation'], $t['group_size'],
           $t['price_from_usd'], $t['price_from_vnd'], $t['featured_image'],
           $t['is_featured'], $t['is_signature'], $t['signature_number'], $t['sort_order']
       ]);

    // Translations EN
    $db->prepare("INSERT INTO tour_translations (tour_id, lang, title, sub_title, short_description, highlights, overview)
                  VALUES (?, 'en', ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE 
                    title = VALUES(title),
                    sub_title = VALUES(sub_title),
                    short_description = VALUES(short_description),
                    highlights = VALUES(highlights),
                    overview = VALUES(overview)")
       ->execute([$t['id'], $t['en']['title'], $t['en']['sub_title'], $t['en']['short_description'], $t['en']['highlights'], $t['en']['overview']]);

    // Translations VI
    $db->prepare("INSERT INTO tour_translations (tour_id, lang, title, sub_title, short_description, highlights, overview)
                  VALUES (?, 'vi', ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE 
                    title = VALUES(title),
                    sub_title = VALUES(sub_title),
                    short_description = VALUES(short_description),
                    highlights = VALUES(highlights),
                    overview = VALUES(overview)")
       ->execute([$t['id'], $t['vi']['title'], $t['vi']['sub_title'], $t['vi']['short_description'], $t['vi']['highlights'], $t['vi']['overview']]);

    // Categories
    $db->prepare("DELETE FROM tour_categories WHERE tour_id = ?")->execute([$t['id']]);
    foreach ($t['cats'] as $catId) {
        $db->prepare("INSERT INTO tour_categories (tour_id, category_id) VALUES (?, ?)")
           ->execute([$t['id'], $catId]);
    }
}

echo "Successfully updated " . count($tours) . " Tours with clean editorial titles!\n";
