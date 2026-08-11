-- Seed Data for Vietnam Unique Travel
-- Compatible with MySQL 5.7+ / 8.0+

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Insert Default Admin Account
INSERT INTO `admins` (`id`, `username`, `email`, `password`, `name`, `role`, `status`) VALUES
(1, 'admin', 'sales.vietnamuniquetravel@gmail.com', '$2b$12$QAsVgXMNTdUkhHbhHbv.gucg9tlvw.59kS.JmWfFUZ2kTuTMcVgYO', 'Vietnam Unique Travel Admin', 'admin', 1)
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`), `name` = VALUES(`name`);

-- 2. Insert Destinations
INSERT IGNORE INTO `destinations` (`id`, `slug`, `image`, `is_featured`, `sort_order`, `status`) VALUES
(1, 'pu-luong-nature-reserve', '/assets/images/hero.webp', 1, 1, 1),
(2, 'mai-chau-valley', '/assets/images/water-wheels.webp', 1, 2, 1),
(3, 'ninh-binh', '/assets/images/bamboo-rafting.webp', 1, 3, 1),
(4, 'ha-giang-loop', '/assets/images/hieu-waterfall.webp', 1, 4, 1);

INSERT IGNORE INTO `destination_translations` (`destination_id`, `lang`, `name`, `short_description`, `description`, `seo_title`, `seo_description`) VALUES
(1, 'en', 'Pu Luong Nature Reserve', 'Pristine limestone karsts, lush terraced rice fields, vibrant Thai ethnic villages and roaring waterfalls.', 'Pu Luong Nature Reserve is a haven of serene mountain landscapes, endless rice terraces, and authentic ethnic minority culture located in Thanh Hoa province.', 'Pu Luong Nature Reserve Tours | Vietnam Unique Travel', 'Discover authentic Pu Luong tours with trekking, bamboo rafting, waterfalls, and ethnic stilt houses.'),
(1, 'vi', 'Khu Bảo Tồn Thiên Nhiên Pù Luông', 'Vùng đất hoang sơ với ruộng bậc thang hùng vĩ, bản làng người Thái và những dòng thác kỳ vĩ.', 'Khu bảo tồn thiên nhiên Pù Luông thuộc tỉnh Thanh Hóa, nơi sở hữu những thửa ruộng bậc thang ngút ngàn, dãy núi đá vôi hùng vĩ và các bản làng người Thái yên bình.', 'Tour Pù Luông Trải Nghiệm Độc Đáo | Vietnam Unique Travel', 'Khám phá các chương trình tour Pù Luông trekking, đi bè tre, ngắm thác Hiêu và trải nghiệm văn hóa bản địa.'),
(2, 'en', 'Mai Chau Valley', 'Idyllic valley surrounded by emerald mountains and traditional White Thai ethnic villages.', 'Mai Chau is famous for its peaceful rural scenery, wooden stilt houses, warm hospitality, and traditional brocade weaving.', 'Mai Chau Valley Tours | Vietnam Unique Travel', 'Explore Mai Chau valley with cycling, homestay experience, and local culture.'),
(2, 'vi', 'Thung Lũng Mai Châu', 'Thung lũng yên bình với núi rừng xanh mướt và những bản làng người Thái Trắng.', 'Mai Châu nổi tiếng với khung cảnh nông thôn yên bình, những nếp nhà sàn bằng gỗ và văn hóa dệt thổ cẩm lâu đời.', 'Tour Mai Châu Trải Nghiệm | Vietnam Unique Travel', 'Khám phá thung lũng Mai Châu với các hoạt động đạp xe, lưu trú nhà sàn và tìm hiểu văn hóa.'),
(3, 'en', 'Ninh Binh', 'Ha Long Bay on land featuring towering limestone karst towers and ancient riverways.', 'Ninh Binh offers dramatic karst landscapes, river boat trips through sacred caves, and ancient temples.', 'Ninh Binh Eco Tours | Vietnam Unique Travel', 'Authentic eco tours to Ninh Binh, Trang An, Tam Coc, and Cuc Phuong National Park.'),
(3, 'vi', 'Ninh Bình', 'Vịnh Hạ Long trên cạn với những dãy núi đá vôi kỳ vĩ và dòng sông uốn lượn.', 'Ninh Bình sở hữu cảnh quan karst kỳ vĩ, những dòng sông thơ mộng xuyên qua hang động và di tích lịch sử cổ kính.', 'Tour Du Lịch Ninh Bình | Vietnam Unique Travel', 'Hành trình khám phá Ninh Bình, Tràng An, Tam Cốc và Vườn Quốc Gia Cúc Phương.'),
(4, 'en', 'Ha Giang Loop', 'Spectacular northern mountain frontier with dramatic passes, deep canyons and vibrant hill tribes.', 'Ha Giang is Vietnam ultimate mountain frontier, boasting the famous Ma Pi Leng pass and unique ethnic diversity.', 'Ha Giang Mountain Tours | Vietnam Unique Travel', 'Explore Ha Giang loop with responsible trekking and motorbike tours.'),
(4, 'vi', 'Hà Giang', 'Vùng núi phía Bắc hùng vĩ với những con đèo hiểm trở, hẻm vực sâu và bản làng cao nguyên đá.', 'Hà Giang là mảnh đất địa đầu Tổ quốc với đèo Mã Pí Lèng kỳ vĩ và những nét văn hóa đa dạng của đồng bào tộc người.', 'Tour Hà Giang Hùng Vĩ | Vietnam Unique Travel', 'Khám phá cao nguyên đá Hà Giang với các hành trình trekking và trải nghiệm văn hóa.');

-- 3. Insert Categories / Experiences
INSERT IGNORE INTO `categories` (`id`, `slug`, `icon`, `image`, `sort_order`, `status`) VALUES
(1, 'trekking-hiking', 'ph-footprints', '/assets/images/hero.webp', 1, 1),
(2, 'motorbike-cycling', 'ph-motorbike', '/assets/images/water-wheels.webp', 2, 1),
(3, 'local-culture', 'ph-house-line', '/assets/images/silk-weaving.webp', 3, 1),
(4, 'waterfalls-rivers', 'ph-waves', '/assets/images/hieu-waterfall.webp', 4, 1),
(5, 'responsible-tourism', 'ph-leaf', '/assets/images/bamboo-rafting.webp', 5, 1);

INSERT IGNORE INTO `category_translations` (`category_id`, `lang`, `name`, `description`) VALUES
(1, 'en', 'Trekking & Hiking', 'Explore untamed mountain trails, lush valleys and serene rice terraces step by step.'),
(1, 'vi', 'Trekking & Leo Núi', 'Khám phá những cung đường núi hoang sơ, thung lũng xanh và ruộng bậc thang qua từng bước chân.'),
(2, 'en', 'Motorbike & Cycling', 'Feel the fresh mountain breeze on scenic backroads and secluded ethnic villages.'),
(2, 'vi', 'Xe Máy & Đạp Xe', 'Tận hưởng gió núi mây ngàn trên các con đường làng thơ mộng và bản làng xa xôi.'),
(3, 'en', 'Local Culture & Heritage', 'Immerse in authentic Thai and Muong ethnic traditions, silk weaving, and home hospitality.'),
(3, 'vi', 'Văn Hóa Bản Địa', 'Hòa mình vào phong tục truyền thống của người Thái, Muong, dệt thổ cẩm và ẩm thực nhà sàn.'),
(4, 'en', 'Waterfalls & Rivers', 'Swim in crystal streams, petrified stone waterfalls, and ride handmade bamboo rafts.'),
(4, 'vi', 'Thác Nước & Dòng Sông', 'Đắm mình trong làn nước mát rượi của thác Hiêu và chèo bè tre trên dòng suối Cham.'),
(5, 'en', 'Responsible & Community Tourism', 'Travel with positive impact, supporting indigenous families and eco-preservation.'),
(5, 'vi', 'Du Lịch Có Trách Nhiệm', 'Mỗi chuyến đi góp phần tạo sinh kế bền vững và bảo vệ môi trường, văn hóa bản địa.');

-- 4. Insert 7 Signature Pu Luong Tours
INSERT IGNORE INTO `tours` (`id`, `code`, `slug`, `destination_id`, `duration_type`, `duration_days`, `difficulty`, `transportation`, `group_size`, `price_from_usd`, `price_from_vnd`, `featured_image`, `is_featured`, `is_signature`, `signature_number`, `sort_order`, `status`) VALUES
(1, 'PLHDT-01', 'bike-tours-hidden-villages-hieu-waterfall-adventure', 1, 'halfday', 1, 'easy', 'Motorbike with local guide', '1-6 pax', 22.00, 580000, '/assets/images/hieu-waterfall.webp', 1, 1, 1, 1, 1),
(2, 'PLHDT-02', 'bike-tours-local-market-hidden-valley-discovery', 1, 'halfday', 1, 'easy', 'Motorbike or Private Car', '1-10 pax', 20.00, 520000, '/assets/images/hero.webp', 1, 1, 2, 2, 1),
(3, 'PLHDT-03', 'trekking-tours-authentic-village-life-experience', 1, 'halfday', 1, 'easy', 'Trekking / Walking', '1-12 pax', 25.00, 600000, '/assets/images/silk-weaving.webp', 1, 1, 3, 3, 1),
(4, 'PLHDT-04', 'car-bike-trekking-tours-threads-of-tradition', 1, 'halfday', 1, 'easy', 'Motorbike / Car + Bamboo Raft', '1-10 pax', 35.00, 850000, '/assets/images/bamboo-rafting.webp', 1, 0, 0, 4, 1),
(5, 'PLFDT-01', 'medium-trekking-into-the-heart-of-pu-luong', 1, 'fullday', 1, 'medium', 'Trekking & Walking', '1-10 pax', 31.00, 800000, '/assets/images/water-wheels.webp', 1, 0, 0, 5, 1),
(6, 'PLFDT-02', 'bike-car-short-trekking-pu-luong-signature-experience', 1, 'fullday', 1, 'easy', 'Motorbike or Car + Bamboo Raft', '1-12 pax', 43.00, 1130000, '/assets/images/hero.webp', 1, 0, 0, 6, 1),
(7, 'PLFDT-03', 'hard-trekking-tours-conquer-pu-luong-peak', 1, 'fullday', 1, 'hard', 'Trekking / Mountain Climbing', '1-8 pax', 34.00, 900000, '/assets/images/hero.webp', 1, 0, 0, 7, 1);

-- 5. Insert Tour Translations
INSERT IGNORE INTO `tour_translations` (`tour_id`, `lang`, `title`, `sub_title`, `short_description`, `highlights`, `overview`, `inclusions`, `exclusions`, `what_to_bring`, `child_policy`, `cancellation_policy`, `seo_title`, `seo_description`) VALUES
(1, 'en', 
 'PLHDT – 01: BIKE TOURS: Hidden Villages & Hieu Waterfall Adventure', 
 'Half-Day Motorbike Tour through Son – Ba Muoi – Hieu Village', 
 'Experience an inspiring half-day motorbike journey through high-altitude cloud villages of Son - Ba Muoi and immerse in petrified Hieu Waterfall.', 
 '• Ride up to Son-Ba-Muoi village located 1,180m above sea level with cool misty weather.
• Explore scenic trails through rice terraces and traditional Thai wooden stilt houses.
• Discover Hieu Waterfall where trees and objects turn to stone over time.
• Free time swimming in crystal-clear mountain waterfall pools.', 
 'Son Ba Muoi village is nestled between craggy mountain ranges at an altitude of 1,180m, bringing a virgin beauty like Sa Pa or Da Lat. Continue your ride to Hieu village and follow small trails through rice terraces to Hieu waterfall cascading down 800 meters.', 
 '• Mineral water
• Local driver/guide
• Entrance tickets to Hieu waterfall', 
 '• Personal expenses and tips
• English speaking guide surcharge ($10 / 265k VND per guide)
• Travel insurance', 
 '• Comfortable clothing and walking shoes
• Swimwear and towel if warm weather
• Sunscreen and camera', 
 '• Children aged 5+ pay same price as adults for motorbike seat.', 
 '• Free cancellation up to 24 hours before departure.', 
 'Hidden Villages & Hieu Waterfall Adventure Tour | Vietnam Unique Travel', 
 'Book PLHDT-01 half-day motorbike tour to Son Ba Muoi high village and Hieu Waterfall in Pu Luong.'),

(1, 'vi', 
 'PLHDT – 01: TOUR XE MÁY: Khám Phá Bản Ẩn Mình & Thác Hiêu', 
 'Hành trình nửa ngày bằng xe máy qua Sơn – Bá Mười – Bản Hiêu', 
 'Trải nghiệm nửa ngày bằng xe máy vượt qua vùng cao Son Bá Mười bồng bềnh mây phủ và ngâm mình tại dòng thác Hiêu hóa đá kỳ thú.', 
 '• Chinh phục bản Sơn Bá Mười ở độ cao 1.180m khí hậu mát mẻ như Sa Pa.
• Ngắm nhìn ruộng bậc thang và nếp nhà sàn người Thái ẩn hiện.
• Khám phá thác Hiêu với hiện tượng nước vôi hóa đá độc đáo.
• Tự do tắm mát tại hồ nước tự nhiên dưới chân thác.', 
 'Sơn Bá Mười nằm ở độ cao 1.180m so với mực nước biển, bao bọc bởi những dãy núi đá vôi trập trùng. Du khách sẽ đi xe máy cùng người bản địa, băng qua lối nhỏ ruộng bậc thang đến bản Hiêu và thác Hiêu mát rượi.', 
 '• Nước uống chai
• Lái xe / HDV bản địa
• Vé tham quan thác Hiêu', 
 '• Chi phí cá nhân và tiền tip
• Phụ thu Hướng dẫn viên tiếng Anh (265.000đ / $10 cho 1 HDV)
• Bảo hiểm du lịch', 
 '• Trang phục thoải mái, giày đi bộ
• Đồ bơi và khăn tắm nếu tắm thác
• Kem chống nắng, máy ảnh', 
 '• Trẻ em từ 5 tuổi trở lên tính giá như người lớn (1 người/1 xe).', 
 '• Miễn phí đổi ngày/hủy tour trước 24 giờ khởi hành.', 
 'Tour Xe Máy Khám Phá Bản Hiêu & Thác Hiêu Pù Luông | VNU', 
 'Đặt tour xe máy nửa ngày khám phá Sơn Bá Mười và Thác Hiêu Pù Luông cùng Vietnam Unique Travel.'),

(2, 'en', 
 'PLHDT – 02: BIKE TOURS: Local Market & Hidden Valley Discovery', 
 'Doan Fair Market, Hieu Village, Hieu Waterfall & Brocade Weaving Village (Thu & Sun Only)', 
 'Discover the vibrant authentic ethnic atmosphere of Doan Market, pristine Hieu Waterfall, Co Lung duck farm, and Thai brocade weaving artisans.', 
 '• Visit traditional Doan Market (open Thursdays & Sundays only) trading Kinh, Muong & Thai goods.
• Taste local street food delicacies and buy handmade souvenirs.
• Trek to Hieu Waterfall and see the famed Co Lung ducks.
• Visit Lan Village brocade weaving artisans and try traditional looms.', 
 'Doan Market dates back to French colonial times, serving as a trading hub for Kinh, Muong, and Thai communities. Explore local products, exotic spices, and textiles before heading to Hieu Village and Lan weaving village.', 
 '• Mineral water
• Guide
• Entrance tickets to Hieu waterfall', 
 '• Personal shopping expenses & street food tasting
• English speaking guide surcharge ($8 / 210k VND per group)
• Travel insurance', 
 '• Cash in VND for market shopping
• Comfortable clothes & camera', 
 '• Children >=10 years counted as adult; Children 6-9 years 50% adult price for car option.', 
 '• Free cancellation up to 24 hours prior.', 
 'Doan Fair Market & Hidden Valley Discovery Tour | Vietnam Unique Travel', 
 'Book PLHDT-02 tour visiting Doan ethnic market, Hieu Waterfall and Lan brocade village.'),

(2, 'vi', 
 'PLHDT – 02: TOUR XE MÁY / Ô TÔ: Chợ Phố Đoàn & Thung Lũng Ẩn', 
 'Chợ Phố Đoàn – Bản Hiêu – Thác Hiêu – Trang Trại Vịt – Bản Lan Dệt Thổ Cẩm (Thứ 5 & Chủ Nhật)', 
 'Hòa mình vào không khí chợ phiên Phố Đoàn rực rỡ sắc màu, ngắm thác Hiêu, trang trại vịt Cổ Lũng và làng dệt thổ cẩm truyền thống.', 
 '• Ghép phiên chợ Phố Đoàn (chỉ họp vào sáng Thứ 5 & Chủ Nhật) đậm chất vùng cao.
• Thưởng thức ẩm thực đường phố và mua quà lưu niệm thủ công độc đáo.
• Ghé thăm thác Hiêu và tìm hiểu giống vịt Cổ Lũng đặc sản Pù Luông.
• Trải nghiệm dệt thổ cẩm cùng nghệ nhân người Thái tại Bản Lan.', 
 'Chợ Phố Đoàn là nơi giao thương văn hóa rực rỡ từ thời Pháp thuộc giữa đồng bào Thái, Mường, Kinh. Tour kết hợp tham quan thác Hiêu và làng nghề dệt vải thổ cẩm thủ công.', 
 '• Nước uống
• Hướng dẫn viên
• Vé tham quan thác Hiêu', 
 '• Mua sắm cá nhân tại chợ
• Phụ thu HDV tiếng Anh (210.000đ / $8)
• Bảo hiểm', 
 '• Tiền mặt VND mua quà chợ
• Trang phục nhẹ nhàng', 
 '• Trẻ em >=10 tuổi tính như người lớn. Trẻ 6-9 tuổi tính 50% người lớn (cho phương án đi ô tô).', 
 '• Hủy trước 24 giờ không mất phí.', 
 'Tour Chợ Phiên Phố Đoàn & Thác Hiêu Pù Luông | VNU', 
 'Hành trình nửa ngày trải nghiệm chợ Phố Đoàn, thác Hiêu và làng dệt dệt thổ cẩm bản Lan.'),

(3, 'en',
 'PLHDT – 03: TREKKING TOURS: Authentic Village Life Experience',
 'Half-Day Walking & Cultural Trek through Don & Bang Villages',
 'Immerse yourself in peaceful Thai ethnic stilt houses, emerald rice terraces, and traditional bamboo water wheels.',
 '• Easy walking trek through serene rice fields and historic Thai minority villages.
• Meet local Thai families and learn about centuries-old rice farming techniques.
• Discover iconic bamboo water wheels along the Cham river.
• Enjoy complimentary mountain tea and local tropical fruits.',
 'A light half-day trekking experience taking you off the beaten path into pristine Thai villages. Walk past cascading rice terraces and wooden stilt homes surrounded by lush bamboo groves.',
 '• Mineral water & local guide
• Tropical fruits tasting',
 '• Personal expenses & tips
• Travel insurance',
 '• Comfortable walking shoes
• Sun hat & camera',
 '• Children 5+ pay adult price.',
 '• Free cancellation up to 24 hours prior.',
 'Authentic Village Life Trekking Tour | Vietnam Unique Travel',
 'Book PLHDT-03 half-day walking trek through traditional Pu Luong stilt villages.'),

(3, 'vi',
 'PLHDT – 03: TOUR TREKKING: Trải Nghiệm Cuộc Sống Bản Đón & Bản Báng',
 'Trekking nửa ngày khám phá nét đẹp bình yên bản làng người Thái',
 'Hòa mình vào khung cảnh nhà sàn thanh bình, ruộng bậc thang xanh mướt và guồng nước bằng tre độc đáo dọc dòng suối Cham.',
 '• Trekking nhẹ nhàng qua ruộng bậc thang và bản làng Thái cổ kính.
• Giao lưu cùng người dân bản địa và tìm hiểu canh tác lúa nước lâu đời.
• Check-in guồng nước cọn tre khổng lồ bên dòng suối mát lành.
• Thưởng thức trà núi và hoa quả tươi tại nhà sàn truyền thống.',
 'Hành trình nửa ngày đi bộ ngắm cảnh đưa du khách len lỏi qua những lối nhỏ bình yên. Ngắm nhìn ruộng bậc thang nối tiếp nhau và lắng nghe tiếng suối reo cùng âm thanh yên bình của núi rừng Pù Luông.',
 '• Nước uống & Hướng dẫn viên bản địa
• Thưởng thức hoa quả tươi',
 '• Chi phí cá nhân & tiền tip
• Bảo hiểm du lịch',
 '• Giày đi bộ thoải mái
• Mũ che nắng & máy ảnh',
 '• Trẻ em từ 5 tuổi tính giá người lớn.',
 '• Hủy trước 24 giờ miễn phí.',
 'Tour Trekking Khám Phá Bản Đón Pù Luông | Vietnam Unique Travel',
 'Đặt tour trekking nửa ngày PLHDT-03 trải nghiệm cuộc sống người Thái Pù Luông.');

-- 6. Tour Categories Linking
INSERT IGNORE INTO `tour_categories` (`tour_id`, `category_id`) VALUES
(1, 2), (1, 4),
(2, 2), (2, 3), (2, 4),
(3, 1), (3, 3),
(4, 1), (4, 3), (4, 4), (4, 5),
(5, 1), (5, 3), (5, 4),
(6, 1), (6, 2), (6, 3), (6, 4), (6, 5),
(7, 1), (7, 5);

-- 7. Tour Prices Setup
INSERT IGNORE INTO `tour_prices` (`tour_id`, `transport_type`, `pax_tier`, `price_vnd`, `price_usd`, `note`) VALUES
(1, 'motorbike', '1 pax', 580000, 22.00, 'Motorbike with local guide'),
(1, 'motorbike', '2 pax', 580000, 22.00, 'Motorbike per pax'),
(1, 'motorbike', '3+ pax', 580000, 22.00, 'Motorbike per pax'),
(2, 'motorbike', '1 pax', 520000, 20.00, 'Motorbike option'),
(2, 'car', '1 pax', 1200000, 45.00, 'Private Car option'),
(2, 'car', '2-3 pax', 870000, 33.00, 'Private Car per pax'),
(2, 'car', '4+ pax', 750000, 28.00, 'Private Car per pax'),
(3, 'walking', '1 pax', 600000, 25.00, 'Trekking with local guide'),
(4, 'motorbike', '1 pax', 850000, 35.00, 'Motorbike + Bamboo raft'),
(5, 'walking', '1 pax', 1250000, 48.00, '1 pax medium trek'),
(5, 'walking', '2-3 pax', 950000, 37.00, '2-3 pax medium trek'),
(5, 'walking', '4+ pax', 800000, 31.00, '4+ pax medium trek'),
(6, 'motorbike', '1 pax', 1130000, 43.00, 'Signature motorbike option'),
(6, 'car', '1 pax', 2090000, 80.00, 'Signature private car 1 pax'),
(6, 'car', '2-3 pax', 1620000, 62.00, 'Signature private car 2-3 pax'),
(6, 'car', '4+ pax', 1370000, 52.00, 'Signature private car 4+ pax'),
(7, 'walking', '1 pax', 1580000, 60.00, 'Pu Luong Peak trek 1 pax'),
(7, 'walking', '2-3 pax', 1100000, 42.00, 'Pu Luong Peak trek 2-3 pax'),
(7, 'walking', '4+ pax', 900000, 34.00, 'Pu Luong Peak trek 4+ pax');

-- 7.5 Tour Gallery Images
INSERT IGNORE INTO `tour_images` (`tour_id`, `image_path`, `caption`, `sort_order`) VALUES
(1, 'assets/images/hero.webp', 'Son Ba Muoi mountain panorama', 1),
(1, 'assets/images/hieu-waterfall.webp', 'Hieu Waterfall stream', 2),
(1, 'assets/images/bamboo-rafting.webp', 'Bamboo Rafting Cham Stream', 3),
(1, 'assets/images/silk-weaving.webp', 'Brocade weaving at Lan Village', 4),
(1, 'assets/images/water-wheels.webp', 'Pu Luong Water Wheels', 5),
(2, 'assets/images/hero.webp', 'Pu Luong Landscape', 1),
(2, 'assets/images/water-wheels.webp', 'Water Wheels', 2),
(2, 'assets/images/hieu-waterfall.webp', 'Hieu Waterfall', 3),
(3, 'assets/images/bamboo-rafting.webp', 'Bamboo Rafting', 1),
(3, 'assets/images/silk-weaving.webp', 'Lan Village Weaving', 2),
(4, 'assets/images/hieu-waterfall.webp', 'Hieu Waterfall', 1),
(4, 'assets/images/water-wheels.webp', 'Water Wheels', 2),
(5, 'assets/images/hero.webp', 'Trekking Pu Luong', 1),
(5, 'assets/images/bamboo-rafting.webp', 'Cham Stream', 2),
(6, 'assets/images/hero.webp', 'Signature Tour Pu Luong', 1),
(6, 'assets/images/hieu-waterfall.webp', 'Hieu Waterfall', 2),
(6, 'assets/images/silk-weaving.webp', 'Silk Weaving', 3),
(7, 'assets/images/hero.webp', 'Pu Luong Peak', 1),
(7, 'assets/images/water-wheels.webp', 'Water Wheels', 2);

-- 8. Tour Itinerary Steps for PLHDT-01
INSERT IGNORE INTO `tour_itinerary_steps` (`id`, `tour_id`, `step_time`, `sort_order`) VALUES
(1, 1, '07:30 AM', 1),
(2, 1, '09:30 AM', 2),
(3, 1, '11:00 AM', 3);

INSERT IGNORE INTO `tour_itinerary_translations` (`step_id`, `lang`, `title`, `description`) VALUES
(1, 'en', 'Departure to Son Ba Muoi Village', 'Drivers pick you up at your homestay/resort for a 20km ride up mountains to Son Ba Muoi village at 1,180m altitude.'),
(1, 'vi', 'Khởi hành đi Bản Sơn Bá Mười', 'Lái xe đón quý khách tại Homestay/Resort bắt đầu hành trình 20km vượt đèo lên bản Sơn Bá Mười ở độ cao 1.180m.'),
(2, 'en', 'Hieu Village & Hieu Waterfall Exploration', 'Follow small trails through rice terraces. Hike along the 800m stream to witness petrified rocks and enjoy free swimming.'),
(2, 'vi', 'Tham quan Bản Hiêu & Thác Hiêu', 'Đi theo lối nhỏ qua ruộng bậc thang ngắm cảnh làng quê, dạo chơi dọc dòng thác Hiêu hóa đá và tự do tắm suối.'),
(3, 'en', 'Return to Homestay / Resort', 'Driver takes you back to your homestay/resort. Journey ends with unforgettable memories.'),
(3, 'vi', 'Trở về Homestay / Resort', 'Lái xe đưa quý khách trở lại điểm đón ban đầu. Kết thúc hành trình.');

-- 9. Insert FAQs
INSERT IGNORE INTO `faqs` (`id`, `category`, `question_en`, `answer_en`, `question_vi`, `answer_vi`, `sort_order`) VALUES
(1, 'booking', 'How do I book a tour with Vietnam Unique Travel?', 'You can send a booking inquiry directly on our website, or contact our team via WhatsApp, LINE, Zalo, or email. We will verify availability and confirm within minutes.', 'Làm thế nào để đặt tour?', 'Quý khách có thể gửi yêu cầu đặt tour trực tiếp qua website hoặc liên hệ qua WhatsApp, Zalo, LINE, email. Đội ngũ tư vấn sẽ kiểm tra chỗ và xác nhận nhanh chóng.', 1),
(2, 'custom', 'Can I request a customized Private Tour?', 'Yes! We specialize in tailored Private Tours designed around your schedule, fitness level, and personal preferences.', 'Tôi có thể đặt tour riêng (Private Tour) không?', 'Có. Chúng tôi chuyên thiết kế các chương trình Private Tour theo lịch trình, thể trạng và sở thích riêng của từng nhóm khách.', 2),
(3, 'preparation', 'What should I prepare before the trip?', 'After confirming your tour, we will send a full preparation kit including recommended clothing, shoes, weather updates, and packing checklist.', 'Tôi cần chuẩn bị gì trước chuyến đi?', 'Sau khi xác nhận tour, chúng tôi sẽ gửi tài liệu chi tiết về thời tiết, trang phục, vật dụng cá nhân cần mang theo.', 3);

-- 10. Insert Testimonials
INSERT IGNORE INTO `testimonials` (`id`, `client_name`, `client_country`, `client_avatar`, `rating`, `content_en`, `content_vi`, `tour_name`, `is_featured`, `sort_order`) VALUES
(1, 'Sarah Jenkins', 'Australia', '/assets/images/hero.webp', 5, 'An extraordinary experience in Pu Luong! The bamboo rafting on Cham stream and the high village of Son Ba Muoi exceeded our expectations. The local guide was super attentive!', 'Một trải nghiệm tuyệt vời tại Pù Luông! Đi bè tre trên suối Cham và thăm bản Sơn Bá Mười vượt xa mong đợi của chúng tôi. HDV bản địa rất chu đáo!', 'PLHDT-01: Hidden Villages & Hieu Waterfall', 1, 1),
(2, 'Marcus Thorne', 'Germany', '/assets/images/water-wheels.webp', 5, 'The conquer of Pu Luong Peak was challenging but rewarding! The BBQ lunch on the mountain peak and foot massage afterwards was perfection.', 'Hành trình chinh phục đỉnh Pù Luông đầy thử thách nhưng rất xứng đáng! Bữa trưa BBQ trên đỉnh núi và ngâm chân massage cuối ngày thật tuyệt vời.', 'PLFDT-03: Conquer Pu Luong Peak', 1, 2);

-- 11. Insert Sample Blog Posts
INSERT IGNORE INTO `posts` (`id`, `slug`, `featured_image`, `is_featured`, `status`, `views`) VALUES
(1, 'ultimate-travel-guide-to-pu-luong-nature-reserve', '/assets/images/hero.webp', 1, 1, 120),
(2, 'why-responsible-tourism-matters-in-vietnam-mountains', '/assets/images/bamboo-rafting.webp', 1, 1, 85);

INSERT IGNORE INTO `post_translations` (`post_id`, `lang`, `title`, `summary`, `content`, `seo_title`, `seo_description`) VALUES
(1, 'en', 'Ultimate Travel Guide to Pu Luong Nature Reserve 2026', 'Everything you need to know about weather, rice harvest seasons, trekking routes, and ethnic culture in Pu Luong.', '<p>Pu Luong Nature Reserve is one of Northern Vietnam hidden gems. Located just 160km southwest of Hanoi, this untouched sanctuary offers a breathtaking mix of limestone karst peaks, cascading rice terraces, and authentic Thai and Muong ethnic culture.</p><h2>Best Time to Visit</h2><p>The golden rice harvest seasons occur twice a year: May to June and September to October.</p>', 'Pu Luong Travel Guide 2026 | Vietnam Unique Travel', 'Read our complete travel guide to Pu Luong Nature Reserve: best season, top tours, rice harvest dates.'),
(1, 'vi', 'Cẩm Nang Du Lịch Pù Luông Tự Nhiên Mới Nhất 2026', 'Tất tần tật thông tin thời tiết, mùa lúa chín, cung đường trekking và văn hóa bản địa Pù Luông.', '<p>Khu bảo tồn thiên nhiên Pù Luông là viên ngọc xanh của miền Bắc Việt Nam, cách Hà Nội khoảng 160km. Nơi đây sở hữu thung lũng lúa bậc thang tuyệt đẹp, những nếp nhà sàn người Thái và dòng thác Hiêu hóa đá kỳ vĩ.</p><h2>Thời điểm lý tưởng nhất</h2><p>Mùa lúa chín Pù Luông diễn ra 2 lần trong năm: Tháng 5 - 6 và Tháng 9 - 10.</p>', 'Cẩm Nang Du Lịch Pù Luông 2026 | Vietnam Unique Travel', 'Cẩm nang chi tiết kinh nghiệm du lịch Pù Luông: mùa lúa chín, các tour trekking và điểm tham quan hot nhất.');

-- 12. Site Settings Initial Setup
INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'Vietnam Unique Travel'),
('company_name', 'CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG'),
('tax_code', '0102126315'),
('hotline', '+84 362 191 568'),
('office_phone', '+84 943 642 389'),
('sales_phone', '+84 988 956 496'),
('email', 'sales.vietnamuniquetravel@gmail.com'),
('website', 'vietnamuniquetravel.com'),
('address', '200 Ngõ 192 Lê Trọng Tấn, Phường Phương Liệt, Hà Nội'),
('support_channels', 'WhatsApp, LINE, Zalo, iMessage'),
('whatsapp_number', '+84362191568'),
('seo_default_title', 'Vietnam Unique Travel | Authentic & Responsible Tourism in Vietnam'),
('seo_default_description', 'Vietnam Unique Travel delivers authentic, nature-focused, and responsible travel experiences across Pu Luong, Mai Chau, Ha Giang, and beyond.');

SET FOREIGN_KEY_CHECKS = 1;
