<?php
$isVi = isset($lang) ? $lang === 'vi' : \App\Core\Language::current() === 'vi';
$prefix = $isVi ? 'vi/' : '';
?>
<!-- HERO SECTION (SOVABA STYLE FOR VIETNAM UNIQUE TRAVEL) -->
<section class="hero-section" style="background-image: url('<?= asset('assets/images/hero.webp') ?>');">
  <div class="hero-overlay"></div>
  <div class="container hero-content">
    
    <!-- Top Welcome Subtitle -->
    <div class="hero-welcome-sub">
      <?= $lang === 'vi' ? 'CHÀO MỪNG ĐẾN VỚI' : 'W E L C O M E &nbsp; T O' ?>
    </div>

    <!-- Main Large Serif Title -->
    <h1 class="hero-sovaba-title">
      VIETNAM UNIQUE TRAVEL
    </h1>

    <!-- Tagline Subtitle -->
    <p class="hero-sovaba-tagline">
      <?= $lang === 'vi' ? 'Hành trình độc đáo, trải nghiệm chân thực' : 'New step, new life' ?>
    </p>

    <!-- Sovaba Style Pill Search Bar -->
    <form action="<?= base_url($prefix . 'search') ?>" method="GET" class="sovaba-search-pill">
      <div class="search-pill-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </div>
      <input type="text" name="q" placeholder="<?= $lang === 'vi' ? 'Bạn muốn đi đâu?' : 'Where do you want to go?' ?>" required>
      <button type="submit" class="btn-search-pill">
        <?= $lang === 'vi' ? 'Tìm kiếm' : 'Search' ?>
      </button>
    </form>

  </div>
</section>

<!-- SIGNATURE TOURS SECTION (EXACT SOVABA HOT TOUR DESIGN) -->
<section class="signature-section">
  <div class="container">
    
    <?php 
    $num = 1;
    foreach ($signatureTours as $tour): 
      $numStr = sprintf("%02d", $num++);
    ?>
      <div class="sovaba-hot-card">
        
        <!-- Left Text Content -->
        <div class="sovaba-hot-content">
          <!-- Top Badge: 01 ─── Tour hot -->
          <div class="sovaba-hot-header">
            <span class="sovaba-hot-num"><?= $numStr ?></span>
            <span class="sovaba-hot-dash"></span>
            <span class="sovaba-hot-tag"><?= $lang === 'vi' ? 'Tour hot' : 'Signature Tour' ?></span>
          </div>

          <h3 class="sovaba-hot-title"><?= e($tour['title']) ?></h3>
          <p class="sovaba-hot-desc"><?= e($tour['short_description']) ?></p>

          <a href="<?= base_url($prefix . 'tours/' . $tour['slug']) ?>" class="sovaba-hot-link">
            <span><?= $lang === 'vi' ? 'Xem thêm' : 'Explore Tour' ?></span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </div>

        <!-- Right Angled Image Card Box -->
        <div class="sovaba-hot-img-box">
          <img src="<?= asset($tour['featured_image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($tour['title']) ?>" loading="lazy">
        </div>

      </div>
    <?php endforeach; ?>

  </div>
</section>

<!-- FEATURED DESTINATION SPOTLIGHT SECTION (SOVABA STYLE - AUTO ROTATE 3s) -->
<?php if (!empty($destinations)): 
  $featuredDest = $destinations[0];
  $destSpotlightList = array_map(function($d) use ($isVi, $prefix) {
      return [
          'name' => $d['name'],
          'sub' => $isVi ? 'Vùng Đất Nổi Bật' : 'Featured Destination',
          'desc' => $d['description'] ?: $d['short_description'],
          'image' => asset($d['image'] ?: 'assets/images/hero.webp'),
          'link' => base_url($prefix . 'destinations/' . $d['slug'])
      ];
  }, $destinations);
?>
<section class="dest-spotlight-sec">
  <div class="dest-spotlight-container container">
    
    <!-- Left Text Content -->
    <div class="dest-spotlight-content">
      <span class="dest-spotlight-sub"><?= e($isVi ? 'Vùng Đất Nổi Bật' : 'Featured Destination') ?></span>
      <h2 class="dest-spotlight-title"><?= e($featuredDest['name']) ?></h2>
      <p class="dest-spotlight-desc">
        <?= e($featuredDest['description'] ?: $featuredDest['short_description']) ?>
      </p>
      <a href="<?= base_url($prefix . 'destinations/' . $featuredDest['slug']) ?>" class="btn-dest-spotlight">
        <?= $isVi ? 'Xem chi tiết' : 'Explore Destination' ?>
      </a>
    </div>

    <!-- Right Image Box (Dual-layer for zero-white-flash crossfade) -->
    <div class="dest-spotlight-img-box" id="destSpotlightImgBox">
      <img src="<?= asset($featuredDest['image'] ?: 'assets/images/hero.webp') ?>" class="spotlight-img-active" alt="<?= e($featuredDest['name']) ?>" loading="eager">
      <img src="<?= asset($destinations[1]['image'] ?? $featuredDest['image']) ?>" class="spotlight-img-next" alt="" loading="lazy">
    </div>

  </div>
</section>

<script>
(function() {
  const destData = <?= json_encode($destSpotlightList) ?>;
  if (!destData || destData.length <= 1) return;

  // Preload all destination images into browser cache immediately
  destData.forEach(d => {
    const i = new Image();
    i.src = d.image;
  });

  let currentIdx = 0;
  let isTransitioning = false;

  setInterval(() => {
    if (isTransitioning) return;
    isTransitioning = true;

    const contentBox = document.querySelector('.dest-spotlight-content');
    const imgActive = document.querySelector('.spotlight-img-active');
    const imgNext = document.querySelector('.spotlight-img-next');
    if (!contentBox || !imgActive || !imgNext) {
      isTransitioning = false;
      return;
    }

    const nextIdx = (currentIdx + 1) % destData.length;
    const d = destData[nextIdx];

    // Load next image onto background layer
    imgNext.src = d.image;
    imgNext.alt = d.name;

    // Soft fade text
    contentBox.style.opacity = '0.35';
    contentBox.style.transform = 'translateY(6px)';

    setTimeout(() => {
      const subEl = document.querySelector('.dest-spotlight-sub');
      const titleEl = document.querySelector('.dest-spotlight-title');
      const descEl = document.querySelector('.dest-spotlight-desc');
      const linkEl = document.querySelector('.btn-dest-spotlight');

      if (subEl) subEl.textContent = d.sub;
      if (titleEl) titleEl.textContent = d.name;
      if (descEl) descEl.textContent = d.desc;
      if (linkEl) linkEl.href = d.link;

      // Cross-fade top image layer smoothly to reveal next layer underneath
      imgActive.style.opacity = '0';
      imgNext.style.opacity = '1';

      contentBox.style.opacity = '1';
      contentBox.style.transform = 'translateY(0)';

      setTimeout(() => {
        imgActive.src = d.image;
        imgActive.alt = d.name;
        imgActive.style.opacity = '1';
        imgNext.style.opacity = '0';
        currentIdx = nextIdx;
        isTransitioning = false;
      }, 700);

    }, 250);

  }, 3200);
})();
</script>
<?php endif; ?>

<!-- FEATURED EXPERIENCES SECTION -->
<section style="padding: 100px 0; background: #FFFFFF;">
  <div class="container">
    <div class="section-header-center">
      <span class="section-sub-gold" style="color: var(--color-brand-green);"><?= __('experiences_title') ?></span>
      <h2 style="font-size: 2.5rem; color: var(--color-text-dark);"><?= __('experiences_subtitle') ?></h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
      <?php foreach ($categories as $cat): ?>
        <div class="exp-card">
          <div style="position: relative; overflow: hidden;">
            <img src="<?= asset($cat['image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($cat['name']) ?>" class="exp-card-img">
          </div>
          <div style="padding: 24px;">
            <h3 style="font-size: 1.3rem; margin-bottom: 10px; color: var(--color-brand-green);"><?= e($cat['name']) ?></h3>
            <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 16px;"><?= e($cat['description']) ?></p>
            <a href="<?= base_url($prefix . 'experiences') ?>" class="exp-card-link">Discover Activities &rarr;</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- WHY VIETNAM UNIQUE TRAVEL GLASSMORPHISM SPOTLIGHT CAROUSEL SECTION -->
<?php
$whyItems = [
    [
        'author_vi' => 'Trải Nghiệm Chân Thực',
        'author_en' => 'Authentic Experiences',
        'desc_vi' => 'Khám phá những miền đất nguyên sơ và kết nối sâu sắc với thiên nhiên, con người cùng văn hóa địa phương.',
        'desc_en' => 'Explore untouched lands and forge genuine connections with local people, pristine nature, and ethnic traditions.',
        'img' => 'assets/images/bamboo-rafting.webp',
        'alt' => 'Bamboo Rafting Pu Luong'
    ],
    [
        'author_vi' => 'Hành Trình Được Thiết Kế Riêng',
        'author_en' => 'Tailor-Made Journeys',
        'desc_vi' => 'Mỗi hành trình được điều chỉnh theo sở thích, thời gian và nhịp trải nghiệm riêng của từng du khách.',
        'desc_en' => 'Every itinerary is crafted around your pace, preferences, and personal travel style.',
        'img' => 'assets/images/hieu-waterfall.webp',
        'alt' => 'Pu Luong Waterfall'
    ],
    [
        'author_vi' => 'Du Lịch Có Trách Nhiệm',
        'author_en' => 'Responsible Tourism',
        'desc_vi' => 'Tôn trọng thiên nhiên và văn hóa bản địa, đồng thời góp phần tạo sinh kế bền vững cho cộng đồng địa phương.',
        'desc_en' => 'Respecting nature and ethnic cultures while creating sustainable livelihoods for native communities.',
        'img' => 'assets/images/water-wheels.webp',
        'alt' => 'Pu Luong Water Wheels'
    ],
    [
        'author_vi' => 'Đồng Hành Tận Tâm',
        'author_en' => 'Dedicated Companion',
        'desc_vi' => 'Đội ngũ am hiểu điểm đến luôn lắng nghe và hỗ trợ để mỗi hành trình diễn ra thuận lợi, an toàn và đáng nhớ.',
        'desc_en' => 'Our passionate local experts support you every step of the way for a seamless, safe, and memorable trip.',
        'img' => 'assets/images/silk-weaving.webp',
        'alt' => 'Traditional Silk Weaving'
    ]
];

$whyItems = array_map(function($item) {
    $item['full_img'] = asset($item['img']);
    return $item;
}, $whyItems);
?>

<section class="why-carousel-sec">
  <div class="why-carousel-container">
    
    <div class="why-carousel-header">
      <h2 class="why-title-white">
        <?= $isVi ? 'VIETNAM UNIQUE TRAVEL: NƠI TẠO NÊN NHỮNG KỈ NIỆM' : 'VIETNAM UNIQUE TRAVEL: WHERE MEMORIES ARE MADE' ?>
      </h2>
    </div>

    <div class="why-stage-wrap">
      
      <button class="why-nav-btn why-nav-prev" onclick="moveWhyGlassSlide(-1)" aria-label="Previous Slide">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
      </button>

      <!-- Background Photo Row (Exact 3 Cards) -->
      <div class="why-photo-row" id="whyPhotoRow">
        <div class="why-bg-card card-side" id="bgCardLeft" onclick="moveWhyGlassSlide(-1)" title="Click to view previous slide"><img src="<?= $whyItems[count($whyItems)-1]['full_img'] ?>" alt="Previous" loading="lazy"></div>
        <div class="why-bg-card card-center" id="bgCardCenter"><img src="<?= $whyItems[0]['full_img'] ?>" alt="Current" loading="lazy"></div>
        <div class="why-bg-card card-side" id="bgCardRight" onclick="moveWhyGlassSlide(1)" title="Click to view next slide"><img src="<?= $whyItems[1]['full_img'] ?>" alt="Next" loading="lazy"></div>
      </div>

      <!-- Center Glass Spotlight Card -->
      <div class="why-glass-center" id="whyGlassCard">
        <picture>
          <source srcset="<?= $whyItems[0]['full_img'] ?>" type="image/webp">
          <img src="<?= $whyItems[0]['full_img'] ?>" id="glassCardImg" class="why-glass-img" alt="Featured Photo">
        </picture>
        <span class="why-glass-quote">“</span>
        <p class="why-glass-text" id="glassCardText"><?= e($isVi ? $whyItems[0]['desc_vi'] : $whyItems[0]['desc_en']) ?></p>
        <div class="why-glass-dash">–</div>
        <div class="why-glass-author" id="glassCardAuthor"><?= e($isVi ? $whyItems[0]['author_vi'] : $whyItems[0]['author_en']) ?></div>
      </div>

      <button class="why-nav-btn why-nav-next" onclick="moveWhyGlassSlide(1)" aria-label="Next Slide">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </button>

    </div>

  </div>
</section>

<script>
const whyGlassData = <?= json_encode($whyItems) ?>;
const isViLang = <?= json_encode($isVi) ?>;
let currentWhyGlassIdx = 0;
const totalWhyGlass = whyGlassData.length;
let whyGlassTimer = null;

function renderGlassCarousel() {
  const prevIdx = (currentWhyGlassIdx - 1 + totalWhyGlass) % totalWhyGlass;
  const currIdx = currentWhyGlassIdx;
  const nextIdx = (currentWhyGlassIdx + 1) % totalWhyGlass;

  const itemPrev = whyGlassData[prevIdx];
  const itemCurr = whyGlassData[currIdx];
  const itemNext = whyGlassData[nextIdx];

  const imgLeft = document.querySelector('#bgCardLeft img');
  const imgCenter = document.querySelector('#bgCardCenter img');
  const imgRight = document.querySelector('#bgCardRight img');

  if (imgLeft) imgLeft.src = itemPrev.full_img;
  if (imgCenter) imgCenter.src = itemCurr.full_img;
  if (imgRight) imgRight.src = itemNext.full_img;

  const glassImg = document.getElementById('glassCardImg');
  const glassSource = document.querySelector('#whyGlassCard picture source');
  const glassText = document.getElementById('glassCardText');
  const glassAuthor = document.getElementById('glassCardAuthor');

  if (glassSource) glassSource.srcset = itemCurr.full_img;
  if (glassImg) glassImg.src = itemCurr.full_img;
  if (glassText) glassText.textContent = isViLang ? itemCurr.desc_vi : itemCurr.desc_en;
  if (glassAuthor) glassAuthor.textContent = isViLang ? itemCurr.author_vi : itemCurr.author_en;
}

function moveWhyGlassSlide(dir) {
  currentWhyGlassIdx = (currentWhyGlassIdx + dir + totalWhyGlass) % totalWhyGlass;
  renderGlassCarousel();
  resetWhyGlassTimer();
}

function startWhyGlassTimer() {
  whyGlassTimer = setInterval(() => moveWhyGlassSlide(1), 6000);
}

function resetWhyGlassTimer() {
  if (whyGlassTimer) clearInterval(whyGlassTimer);
  startWhyGlassTimer();
}

renderGlassCarousel();
startWhyGlassTimer();
</script>

<!-- TESTIMONIALS SECTION -->
<section style="padding: 90px 0; background: var(--color-forest-dark); color: #FFF;">
  <div class="container">
    <div class="section-header-center">
      <span class="section-sub-gold">Guest Reviews</span>
      <h2 class="section-title-white">Stories From Our Travelers</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
      <?php foreach ($testimonials as $item): ?>
        <div style="background: rgba(255,255,255,0.06); padding: 32px; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.1);">
          <div style="color: var(--color-gold); margin-bottom: 12px; font-size: 1.2rem;">
            <?= str_repeat('★', $item['rating']) ?>
          </div>
          <p style="font-style: italic; color: rgba(255,255,255,0.9); margin-bottom: 20px; font-size: 0.98rem; line-height: 1.6;">
            "<?= e($item['content']) ?>"
          </p>
          <div style="font-weight: 700; color: #FFF;"><?= e($item['client_name']) ?> <span style="color: var(--color-gold); font-size: 0.85rem;">(<?= e($item['client_country']) ?>)</span></div>
          <div style="color: rgba(255,255,255,0.5); font-size: 0.85rem;"><?= e($item['tour_name']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- OUR SERVICES BENTO GRID SECTION -->
<section class="our-services-sec">
  <div class="container">
    <h2 class="our-services-title"><?= $isVi ? 'Dịch vụ của chúng tôi' : 'Our Services' ?></h2>

    <div class="services-bento-grid">
      <!-- Card 1 (Large - Hotel Rooms) -->
      <a href="<?= base_url($prefix . 'booking') ?>" class="service-card service-card-large">
        <img src="<?= asset('assets/images/hotel-room.png') ?>" alt="<?= $isVi ? 'Phòng khách sạn' : 'Hotel Accommodation' ?>" loading="lazy">
        <div class="service-card-overlay">
          <h3 class="service-card-title"><?= $isVi ? 'Phòng khách sạn' : 'Hotel Accommodation' ?></h3>
        </div>
      </a>

      <!-- Card 2 (Top Middle - Flight Tickets) -->
      <a href="<?= base_url($prefix . 'booking') ?>" class="service-card">
        <img src="<?= asset('assets/images/flight-tickets.png') ?>" alt="<?= $isVi ? 'Vé máy bay' : 'Flight Tickets' ?>" loading="lazy">
        <div class="service-card-overlay" style="justify-content: center;">
          <h3 class="service-card-title"><?= $isVi ? 'Vé máy bay' : 'Flight Tickets' ?></h3>
        </div>
      </a>

      <!-- Card 3 (Top Right - Passport Services) -->
      <a href="<?= base_url($prefix . 'booking') ?>" class="service-card">
        <img src="<?= asset('assets/images/passport-service.png') ?>" alt="<?= $isVi ? 'Dịch vụ hộ chiếu' : 'Passport & Visa Services' ?>" loading="lazy">
        <div class="service-card-overlay" style="justify-content: center;">
          <h3 class="service-card-title"><?= $isVi ? 'Dịch vụ hộ chiếu' : 'Passport & Visa Services' ?></h3>
        </div>
      </a>

      <!-- Card 4 (Bottom Middle - Team Building) -->
      <a href="<?= base_url($prefix . 'booking') ?>" class="service-card">
        <img src="<?= asset('assets/images/team-building.png') ?>" alt="<?= $isVi ? 'Team building' : 'Team Building' ?>" loading="lazy">
        <div class="service-card-overlay" style="justify-content: center;">
          <h3 class="service-card-title"><?= $isVi ? 'Team building' : 'Team Building' ?></h3>
        </div>
      </a>

      <!-- Card 5 (Bottom Right - Event Organization) -->
      <a href="<?= base_url($prefix . 'booking') ?>" class="service-card">
        <img src="<?= asset('assets/images/event-organization.png') ?>" alt="<?= $isVi ? 'Tổ chức sự kiện' : 'Event Organization' ?>" loading="lazy">
        <div class="service-card-overlay" style="justify-content: center;">
          <h3 class="service-card-title"><?= $isVi ? 'Tổ chức sự kiện' : 'Event Organization' ?></h3>
        </div>
      </a>
    </div>

  </div>
</section>
