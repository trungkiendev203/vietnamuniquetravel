import sqlite3
import os

db_path = r'e:\vietnamuniquetravel\storage\database.sqlite'
conn = sqlite3.connect(db_path)
cursor = conn.cursor()

# Ensure table schema has category column or tag column if needed
for col, ctype in [
    ('category', 'TEXT DEFAULT "experience"'),
    ('tags', 'TEXT DEFAULT ""'),
    ('destination_id', 'INTEGER DEFAULT 1'),
    ('read_time', 'TEXT DEFAULT "5 min read"')
]:
    try:
        cursor.execute(f'ALTER TABLE posts ADD COLUMN {col} {ctype}')
    except Exception:
        pass

cursor.execute('DELETE FROM posts')
cursor.execute('DELETE FROM post_translations')

articles = [
    {
        'id': 1,
        'slug': 'kinh-nghiem-du-lich-pu-luong-tu-a-den-z',
        'image': '/assets/images/hero.webp',
        'category': 'experience',
        'tags': 'Pù Luông, Kinh Nghiệm, Săn Mây, Thác Hiêu',
        'destination_id': 1,
        'read_time': '6 min read',
        'published_at': '2026-08-12 09:00:00',
        'vi': {
            'title': 'Kinh nghiệm du lịch Pù Luông tự túc: Mùa lúa chín, đường đi & bản làng đẹp nhất',
            'summary': 'Tổng hợp tất tần tật kinh nghiệm khám phá Pù Luông: thời điểm săn mây, cung đường di chuyển, thác Hiêu, guồng nước và các bản làng người Thái bình yên.',
            'content': '''<p class="lead-article-text">Nằm cách thủ đô Hà Nội khoảng 160km về phía Tây Nam, <strong>Khu bảo tồn thiên nhiên Pù Luông</strong> (Thanh Hóa) hiện lên như một bức tranh thủy mặc ngút ngàn với những thửa ruộng bậc thang kỳ vĩ, rừng nguyên sinh rậm rạp và những bản làng người Thái, người Mường ẩn mình trong làn mây trắng bồng bềnh.</p>

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
<p>Pù Luông có hai mùa lúa chín tuyệt đẹp trong năm mà bạn không nên bỏ lỡ:</p>
<ul>
  <li><strong>Mùa lúa vụ hè thu (Tháng 5 - Tháng 6):</strong> Lúc này Pù Luông bước vào mùa gặt đầu tiên, các thửa ruộng bậc thang chuyển sắc vàng rực rỡ trên nền núi rừng xanh biếc.</li>
  <li><strong>Mùa lúa vụ mùa (Tháng 9 - Tháng 10):</strong> Đây là thời điểm Pù Luông đẹp nhất năm, tiết trời se lạnh mát mẻ, biển mây bồng bềnh xuất hiện vào mỗi sớm mai.</li>
</ul>

<div class="article-image-block">
  <img src="/assets/images/hero.webp" alt="Ruộng bậc thang Pù Luông mùa lúa chín" loading="lazy">
  <p class="img-caption">Ảnh: Ruộng bậc thang Pù Luông rực rỡ sắc vàng mùa lúa chín</p>
</div>

<h2 id="section-2">2. Hướng dẫn đường đi và phương tiện di chuyển</h2>
<p>Từ Hà Nội, bạn có thể lựa chọn di chuyển bằng xe máy phượt theo cung đường Quốc Lộ 6 qua Mai Châu rồi rẽ theo đường 15C đi Pù Luông (khoảng 4 - 4.5 tiếng). Nếu đi nhóm đông hoặc gia đình, xe limousine đưa đón tận nơi là lựa chọn tối ưu, vừa an toàn vừa tiết kiệm sức lực.</p>

<h2 id="section-3">3. Top những điểm check-in không thể bỏ lỡ</h2>
<p>Khi đến với Pù Luông, hãy dành thời gian ghé thăm những địa danh nổi tiếng:</p>
<ol>
  <li><strong>Bản Đôn & Bản Kho Mường:</strong> Nơi tập trung nhiều nếp nhà sàn truyền thống và thung lũng lúa thoai thoải tuyệt đẹp.</li>
  <li><strong>Thác Hiêu (Hiêu Waterfall):</strong> Dòng thác nước trong vắt bắt nguồn từ lòng núi đá vôi, có tính chất đóng vôi cây cỏ độc đáo.</li>
  <li><strong>Guồng nước bản Công & Chèo bè tre suối Chăm:</strong> Trải nghiệm lướt êm đềm trên bè tre và chiêm ngưỡng công trình dẫn thủy thông minh của cha ông.</li>
</ol>

<div class="article-image-block">
  <img src="/assets/images/hieu-waterfall.webp" alt="Thác Hiêu hoang sơ tuyệt đẹp" loading="lazy">
  <p class="img-caption">Ảnh: Dòng thác Hiêu kỳ vĩ mát lạnh giữa lòng đại ngàn</p>
</div>

<h2 id="section-4">4. Ăn gì ngon tại Pù Luông?</h2>
<p>Ẩm thực nơi đây gắn liền với sản vật tự nhiên: <em>Vịt Cổ Lũng nướng than hoa thơm lừng</em>, <em>cá suối nướng giòn ngọt</em>, <em>canh lá đắng</em> và <em>cơm lam dẻo quánh</em> chấm muối vừng.</p>

<h2 id="section-5">5. Lưu ý quan trọng cho chuyến đi trọn vẹn</h2>
<blockquote>
  <p>\"Hãy chỉ để lại những dấu chân và chỉ mang về những bức ảnh đẹp. Tôn trọng nếp sống và văn hóa của người dân bản địa chính là cách chúng ta bảo tồn vẻ đẹp Pù Luông bền vững.\"</p>
</blockquote>'''
        },
        'en': {
            'title': 'Complete Pu Luong Travel Guide: Golden Rice Seasons, Hamlets & Secret Trails',
            'summary': 'Everything you need to plan an authentic trip to Pu Luong Nature Reserve: best seasons for cloud hunting, cascading waterfalls, bamboo water wheels, and Thai ethnic culture.',
            'content': '''<p class="lead-article-text">Located approximately 160km southwest of Hanoi, <strong>Pu Luong Nature Reserve</strong> is a pristine sanctuary boasting cascading terraced rice fields, lush limestone karsts, and tranquil traditional stilt-house hamlets of the White Thai and Muong ethnic communities.</p>

<div class="article-toc-box">
  <h4 class="toc-title">Table of Contents</h4>
  <ul class="toc-list">
    <li><a href="#section-1">1. Best Seasons to Visit Pu Luong</a></li>
    <li><a href="#section-2">2. How to Get There from Hanoi</a></li>
    <li><a href="#section-3">3. Must-See Highlights & Experiences</a></li>
    <li><a href="#section-4">4. Highland Culinary Delicacies</a></li>
    <li><a href="#section-5">5. Responsible Travel Tips</a></li>
  </ul>
</div>

<h2 id="section-1">1. Best Seasons to Visit Pu Luong</h2>
<p>Pu Luong boasts two breathtaking golden rice harvest seasons every year: late May to June and late September to October.</p>

<div class="article-image-block">
  <img src="/assets/images/hero.webp" alt="Pu Luong Terraced Rice Fields" loading="lazy">
  <p class="img-caption">Photo: Golden terraced rice fields across Don Village</p>
</div>

<h2 id="section-2">2. How to Get There from Hanoi</h2>
<p>Travelers can easily reach Pu Luong via private transfer or shuttle bus along Route 6 through Mai Chau Valley and onto Scenic Highway 15C (approx. 4 hours driving).</p>

<h2 id="section-3">3. Must-See Highlights & Experiences</h2>
<ol>
  <li><strong>Don & Kho Muong Hamlets:</strong> Idyllic villages tucked into mountain amphitheaters.</li>
  <li><strong>Hieu Waterfall:</strong> Pristine multi-tiered falls calcifying tree leaves in crystalline pools.</li>
  <li><strong>Giant Bamboo Water Wheels:</strong> Ingenious river-powered irrigation craftsmanship.</li>
</ol>

<div class="article-image-block">
  <img src="/assets/images/hieu-waterfall.webp" alt="Hieu Waterfall cascade" loading="lazy">
  <p class="img-caption">Photo: Crystalline natural spring pools of Hieu Waterfall</p>
</div>'''
        }
    },
    {
        'id': 2,
        'slug': 'nghe-det-tho-cam-truyen-thong-nguoi-thai-mai-chau',
        'image': '/assets/images/silk-weaving.webp',
        'category': 'culture',
        'tags': 'Mai Châu, Văn Hoá, Thổ Cẩm, Bản Lác',
        'destination_id': 2,
        'read_time': '5 min read',
        'published_at': '2026-08-11 10:30:00',
        'vi': {
            'title': 'Nghề dệt thổ cẩm truyền thống người Thái Mai Châu: Nét đẹp di sản dệt nên từ tâm huyết',
            'summary': 'Khám phá nghệ thuật dệt thổ cẩm thủ công tinh xảo của các mẹ, các chị người Thái tại Bản Lác và Poom Coọng. Từng đường kim mũi chỉ kể câu chuyện núi rừng ngàn năm.',
            'content': '''<p class="lead-article-text">Giữa thung lũng Mai Châu thơ mộng, tiếng thoi đưa lách cách bên khung cửi dưới gầm nhà sàn đã trở thành giai điệu thân thuộc qua bao thế hệ phụ nữ người Thái trắng.</p>

<div class="article-toc-box">
  <h4 class="toc-title">Danh mục bài viết</h4>
  <ul class="toc-list">
    <li><a href="#sec-1">1. Nguồn gốc và ý nghĩa của thổ cẩm người Thái</a></li>
    <li><a href="#sec-2">2. Quy trình dệt thủ công kỳ công</a></li>
    <li><a href="#sec-3">3. Trải nghiệm dệt vải cùng nghệ nhân bản địa</a></li>
  </ul>
</div>

<h2 id="sec-1">1. Nguồn gốc và ý nghĩa của thổ cẩm người Thái</h2>
<p>Với người Thái ở Mai Châu, tấm thổ cẩm không chỉ là trang phục thường ngày mà còn là thước đo sự khéo léo, đảm đang của người con gái khi về nhà chồng.</p>

<div class="article-image-block">
  <img src="/assets/images/silk-weaving.webp" alt="Nghệ nhân dệt thổ cẩm Mai Châu" loading="lazy">
  <p class="img-caption">Ảnh: Nghệ nhân người Thái bên khung cửi gỗ truyền thống</p>
</div>

<h2 id="sec-2">2. Quy trình dệt thủ công kỳ công</h2>
<p>Từ sợi bông tự nhiên, người thợ nhuộm màu bằng các loại vỏ cây, củ nâu, lá chàm rừng rồi đưa lên khung dệt với những hoa văn hình chim muông, hoa ban, hoa sen cách điệu tinh tế.</p>'''
        },
        'en': {
            'title': 'Traditional Thai Brocade Weaving in Mai Chau: Living Heritage Woven with Soul',
            'summary': 'Immerse in the intricate heritage of White Thai weavers in Mai Chau valley. Discover how natural dyes and ancient wooden looms preserve ancestral traditions.',
            'content': '''<p class="lead-article-text">In the peaceful valley of Mai Chau, the rhythmic sound of wooden looms echoing beneath traditional stilt houses embodies centuries of indigenous White Thai craftsmanship.</p>

<div class="article-toc-box">
  <h4 class="toc-title">Table of Contents</h4>
  <ul class="toc-list">
    <li><a href="#sec-1">1. Cultural Significance of Thai Brocade</a></li>
    <li><a href="#sec-2">2. Natural Dyeing & Hand-Looming Process</a></li>
    <li><a href="#sec-3">3. Weaving Workshop Experience</a></li>
  </ul>
</div>

<h2 id="sec-1">1. Cultural Significance of Thai Brocade</h2>
<p>Brocade textiles represent the soul and identity of Thai women, weaving ancestral patterns of mountain flora, fauna, and geometric harmony.</p>

<div class="article-image-block">
  <img src="/assets/images/silk-weaving.webp" alt="Traditional Brocade Weaving" loading="lazy">
  <p class="img-caption">Photo: Local artisan working on traditional wooden loom</p>
</div>'''
        }
    },
    {
        'id': 3,
        'slug': 'top-mon-ngon-dac-san-pu-luong-mai-chau',
        'image': '/assets/images/beach-carousel-bg.webp',
        'category': 'food',
        'tags': 'Ẩm Thực, Vịt Cổ Lũng, Cơm Lam, Đặc Sản',
        'destination_id': 1,
        'read_time': '4 min read',
        'published_at': '2026-08-10 14:15:00',
        'vi': {
            'title': 'Top 7 món ngon đặc sản Pù Luông & Mai Châu: Vịt Cổ Lũng, cá suối nướng và cơm lam',
            'summary': 'Thưởng thức ẩm thực vùng cao độc đáo với vịt Cổ Lũng nướng than hoa, cá suối nướng lá dong, măng rừng xào tỏi và rượu cần thơm nồng bên bếp lửa nhà sàn.',
            'content': '''<p class="lead-article-text">Không chỉ có cảnh sắc mê đắm lòng người, Pù Luông và Mai Châu còn níu chân du khách bởi nền ẩm thực đậm đà hương vị núi rừng Tây Bắc.</p>

<div class="article-toc-box">
  <h4 class="toc-title">Danh mục bài viết</h4>
  <ul class="toc-list">
    <li><a href="#dish-1">1. Vịt Cổ Lũng nướng than hoa</a></li>
    <li><a href="#dish-2">2. Cá suối nướng Pa Pỉnh Tộp</a></li>
    <li><a href="#dish-3">3. Cơm lam nếp nương</a></li>
  </ul>
</div>

<h2 id="dish-1">1. Vịt Cổ Lũng nướng than hoa</h2>
<p>Giống vịt nuôi thả tự nhiên ven suối nước ngọt, xương nhỏ thịt chắc và thơm ngọt, được tẩm ướp hạt mắc khén rồi nướng chín vàng ươm trên than củi hồng.</p>

<h2 id="dish-2">2. Cá suối nướng Pa Pỉnh Tộp</h2>
<p>Cá bắt từ khe suối trong vắt, ướp cùng gừng, sả, ớt, rau thơm rồi kẹp thanh tre nướng thơm lừng chấm cùng muối chẳm chéo đặc trưng.</p>'''
        },
        'en': {
            'title': 'Top 7 Must-Try Ethnic Delicacies in Pu Luong & Mai Chau',
            'summary': 'Taste the flavors of the Northwest highlands: savory Co Lung grilled duck, fresh stream fish wrapped in forest leaves, and fragrant bamboo sticky rice.',
            'content': '''<p class="lead-article-text">Beyond sublime landscapes, Pu Luong and Mai Chau captivate travelers with authentic mountain farm-to-table cuisine seasoned with indigenous herbs.</p>

<div class="article-toc-box">
  <h4 class="toc-title">Table of Contents</h4>
  <ul class="toc-list">
    <li><a href="#dish-1">1. Co Lung Roasted Duck</a></li>
    <li><a href="#dish-2">2. Pa Pinh Top Grilled Stream Fish</a></li>
    <li><a href="#dish-3">3. Fragrant Bamboo Sticky Rice</a></li>
  </ul>
</div>'''
        }
    },
    {
        'id': 4,
        'slug': 'trai-nghiem-cheo-be-tre-va-check-in-guong-nuoc-khong-lo',
        'image': '/assets/images/bamboo-rafting.webp',
        'category': 'activities',
        'tags': 'Hoạt Động, Bè Tre, Guồng Nước, Sông Chăm',
        'destination_id': 1,
        'read_time': '5 min read',
        'published_at': '2026-08-09 11:00:00',
        'vi': {
            'title': 'Trải nghiệm chèo bè tre sông Chăm và chiêm ngưỡng guồng nước khổng lồ bản Công',
            'summary': 'Thả trôi bè tre dọc dòng suối Chăm trong vắt, lắng nghe tiếng nước róc rách và chiêm ngưỡng công trình dẫn thủy nhập điền độc đáo của đồng bào người Mường.',
            'content': '''<p class="lead-article-text">Giữa không gian thanh bình của núi rừng, chèo bè tre thả trôi êm đềm dọc sông Chăm là trải nghiệm thư thái bậc nhất khi đặt chân đến Pù Luông.</p>

<div class="article-toc-box">
  <h4 class="toc-title">Danh mục bài viết</h4>
  <ul class="toc-list">
    <li><a href="#act-1">1. Hành trình xuôi dòng sông Chăm êm đềm</a></li>
    <li><a href="#act-2">2. Cụm guồng nước khổng lồ bản Công</a></li>
  </ul>
</div>

<h2 id="act-1">1. Hành trình xuôi dòng sông Chăm êm đềm</h2>
<p>Bè tre được đan từ những thân tre già dẻo dai. Dưới bàn tay chèo nhẹ nhàng của người lái bè địa phương, bạn sẽ được ngắm nhìn đôi bờ sông với rặng tre xanh mát và cánh đồng ngô trải dài.</p>

<div class="article-image-block">
  <img src="/assets/images/bamboo-rafting.webp" alt="Chèo bè tre sông Chăm" loading="lazy">
  <p class="img-caption">Ảnh: Thư thái chèo bè tre ngắm cảnh đôi bờ sông Chăm</p>
</div>'''
        },
        'en': {
            'title': 'Authentic Bamboo Rafting on Cham River & Giant Water Wheels Discovery',
            'summary': 'Glide peacefully on traditional bamboo rafts along Cham River and admire the majestic ancient water wheels engineered by local Muong and Thai artisans.',
            'content': '''<p class="lead-article-text">Floating gently along the crystal-clear Cham River on handcrafted bamboo rafts offers travelers an unparalleled sense of tranquility.</p>

<div class="article-image-block">
  <img src="/assets/images/bamboo-rafting.webp" alt="Bamboo Rafting River" loading="lazy">
  <p class="img-caption">Photo: Serene bamboo rafting along Cham River</p>
</div>'''
        }
    },
    {
        'id': 5,
        'slug': 'top-homestay-nha-san-view-dep-nhat-pu-luong',
        'image': '/assets/images/water-wheels.webp',
        'category': 'stay',
        'tags': 'Lưu Trú, Homestay, Nhà Sàn, Bản Đôn',
        'destination_id': 1,
        'read_time': '4 min read',
        'published_at': '2026-08-08 16:45:00',
        'vi': {
            'title': 'Top những homestay nhà sàn & retreat ngắm thung lũng lúa đẹp nhất Pù Luông',
            'summary': 'Gợi ý những địa điểm lưu trú nguyên bản, nhà sàn gỗ thoáng đãng nhìn thẳng ra ruộng bậc thang ngút ngàn tại Bản Đôn, Bản Kho Mường và Bản Hiêu.',
            'content': '''<p class="lead-article-text">Chọn một chốn nghỉ chân hòa mình vào thiên nhiên là bí quyết để cảm nhận trọn vẹn sự yên bình của mảnh đất Pù Luông.</p>

<div class="article-toc-box">
  <h4 class="toc-title">Danh mục bài viết</h4>
  <ul class="toc-list">
    <li><a href="#stay-1">1. Homestay nhà sàn gỗ truyền thống Bản Đôn</a></li>
    <li><a href="#stay-2">2. Ecolodge & Eco-retreat view biển mây</a></li>
  </ul>
</div>

<h2 id="stay-1">1. Homestay nhà sàn gỗ truyền thống Bản Đôn</h2>
<p>Nhà sàn gỗ lợp mái lá cọ, ban công nhìn ra thung lũng ruộng bậc thang trải dài bất tận, buổi tối được cùng gia chủ quây quần bên mâm cơm ấm cúng.</p>'''
        },
        'en': {
            'title': 'Top Scenic Stilt House Homestays & Eco-Retreats in Pu Luong',
            'summary': 'Curated guide to charming wooden stilt homestays and eco-lodges with panoramic terraced rice field views in Don Village and Kho Muong.',
            'content': '''<p class="lead-article-text">Choosing an authentic eco-homestay or mountain retreat is essential for experiencing the true peace and hospitality of Pu Luong.</p>'''
        }
    },
    {
        'id': 6,
        'slug': 'du-lich-co-trach-nhiem-giu-gin-ve-dep-hoang-so-tay-bac',
        'image': '/assets/images/hieu-waterfall.webp',
        'category': 'news',
        'tags': 'Tin Tức, Du Lịch Bền Vững, Bản Địa',
        'destination_id': 1,
        'read_time': '5 min read',
        'published_at': '2026-08-07 08:20:00',
        'vi': {
            'title': 'Du lịch có trách nhiệm: Cùng Vietnam Unique Travel gìn giữ nét hoang sơ Tây Bắc',
            'summary': 'Những nguyên tắc vàng khi ghé thăm các bản làng dân tộc: tôn trọng phong tục tập quán, giảm thiểu rác thải nhựa và ủng hộ sinh kế của đồng bào địa phương.',
            'content': '''<p class="lead-article-text">Du lịch có trách nhiệm không chỉ là một khẩu hiệu, mà là tôn chỉ trong mọi chuyến đi do Vietnam Unique Travel thiết kế.</p>

<div class="article-toc-box">
  <h4 class="toc-title">Danh mục bài viết</h4>
  <ul class="toc-list">
    <li><a href="#resp-1">1. Không để lại rác thải nhựa nơi núi rừng</a></li>
    <li><a href="#resp-2">2. Tôn trọng nếp sống và phong tục bản địa</a></li>
  </ul>
</div>

<h2 id="resp-1">1. Không để lại rác thải nhựa nơi núi rừng</h2>
<p>Chúng tôi khuyến khích du khách mang theo bình nước cá nhân có thể tái sử dụng và thu gom rác trên các cung đường trekking.</p>'''
        },
        'en': {
            'title': 'Responsible Travel: Preserving the Pristine Beauty of Northern Vietnam',
            'summary': 'Golden principles for mindful travelers: supporting indigenous communities, eliminating single-use plastics, and honoring sacred cultural traditions.',
            'content': '''<p class="lead-article-text">Responsible tourism is the core philosophy behind every authentic journey curated by Vietnam Unique Travel.</p>'''
        }
    },
    {
        'id': 7,
        'slug': 'kham-pha-cho-phien-pho-doan-pu-luong',
        'image': '/assets/images/silk-weaving.webp',
        'category': 'culture',
        'tags': 'Chợ Phiên, Phố Đòn, Bản Sắc, Trải Nghiệm',
        'destination_id': 1,
        'read_time': '4 min read',
        'published_at': '2026-08-06 09:30:00',
        'vi': {
            'title': 'Khám phá chợ phiên Phố Đòn: Nét sinh hoạt văn hóa rực rỡ sắc màu vùng cao Pù Luông',
            'summary': 'Chợ phiên họp vào sáng thứ 5 và Chủ Nhật hàng tuần tại xã Lũng Niêm. Nơi bà con đồng bào trao đổi nông sản, thổ cẩm và thưởng thức ẩm thực nóng hổi.',
            'content': '''<p class="lead-article-text">Chợ phiên Phố Đòn từ thời Pháp thuộc đến nay vẫn giữ nguyên nét văn hóa giao thương mộc mạc của các dân tộc Thái, Mường và Kinh.</p>'''
        },
        'en': {
            'title': 'Exploring Pho Doan Highland Market: Vibrant Sunday Colors of Pu Luong',
            'summary': 'Experience the bustling atmosphere of Pho Doan local market every Thursday and Sunday morning, where ethnic minorities gather in traditional costumes.',
            'content': '''<p class="lead-article-text">Pho Doan Sunday market dates back to the French colonial era, retaining its authentic mountain trading spirit.</p>'''
        }
    },
    {
        'id': 8,
        'slug': 'bi-quyet-chuan-bi-hanh-ly-trekking-tay-bac-gon-nhe',
        'image': '/assets/images/hero.webp',
        'category': 'experience',
        'tags': 'Kinh Nghiệm, Trekking, Hành Lý, Chuẩn Bị',
        'destination_id': 1,
        'read_time': '4 min read',
        'published_at': '2026-08-05 15:00:00',
        'vi': {
            'title': 'Bí quyết chuẩn bị hành lý trekking Tây Bắc gọn nhẹ, an toàn và đầy đủ tiện ích',
            'summary': 'Hướng dẫn chi tiết cách chọn giày leo núi bám tốt, trang phục thoáng khí, vật dụng chống vắt và đồ sơ cứu y tế cần thiết cho chuyến đi bộ băng rừng.',
            'content': '''<p class="lead-article-text">Một hành lý gọn gàng và phù hợp là chìa khóa để chuyến trekking băng rừng lội suối trở nên nhẹ nhàng và tràn đầy năng lượng.</p>'''
        },
        'en': {
            'title': 'Smart Packing Guide for Trekking in Northern Vietnam Highlands',
            'summary': 'Essential gear checklist for hiking enthusiasts: breathable layers, waterproof footwear, trail snacks, and lightweight daypack essentials.',
            'content': '''<p class="lead-article-text">Packing light and smart is the secret to an effortless and exhilarating trekking adventure across Vietnam highlands.</p>'''
        }
    }
]

for p in articles:
    cursor.execute('''
        INSERT INTO posts (id, slug, featured_image, category, tags, destination_id, read_time, is_featured, status, views, published_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1, 150, ?)
    ''', (p['id'], p['slug'], p['image'], p['category'], p['tags'], p['destination_id'], p['read_time'], p['published_at']))

    cursor.execute('''
        INSERT INTO post_translations (post_id, lang, title, summary, content, seo_title, seo_description)
        VALUES (?, 'vi', ?, ?, ?, ?, ?)
    ''', (p['id'], p['vi']['title'], p['vi']['summary'], p['vi']['content'], p['vi']['title'], p['vi']['summary']))

    cursor.execute('''
        INSERT INTO post_translations (post_id, lang, title, summary, content, seo_title, seo_description)
        VALUES (?, 'en', ?, ?, ?, ?, ?)
    ''', (p['id'], p['en']['title'], p['en']['summary'], p['en']['content'], p['en']['title'], p['en']['summary']))

conn.commit()
print(f'Successfully seeded {len(articles)} Travel Tips articles!')
conn.close()
