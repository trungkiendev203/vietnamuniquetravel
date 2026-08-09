<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
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
            <?= $lang === 'vi' ? 'Xem thêm' : 'Explore Tour' ?>
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

<!-- FEATURED EXPERIENCES SECTION -->
<section style="padding: 100px 0; background: var(--color-ivory);">
  <div class="container">
    <div class="section-header-center">
      <span class="section-sub-gold" style="color: var(--color-brand-green);"><?= __('experiences_title') ?></span>
      <h2 style="font-size: 2.5rem; color: var(--color-text-dark);"><?= __('experiences_subtitle') ?></h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
      <?php foreach ($categories as $cat): ?>
        <div style="background: #FFF; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); transition: transform var(--transition-fast);">
          <img src="<?= asset($cat['image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($cat['name']) ?>" style="height: 200px; width: 100%; object-fit: cover;">
          <div style="padding: 24px;">
            <h3 style="font-size: 1.3rem; margin-bottom: 10px; color: var(--color-brand-green);"><?= e($cat['name']) ?></h3>
            <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 16px;"><?= e($cat['description']) ?></p>
            <a href="<?= base_url($prefix . 'experiences') ?>" style="color: var(--color-brand-green); font-weight: 700; font-size: 0.9rem;">Discover Activities &rarr;</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- WHY VIETNAM UNIQUE TRAVEL 3D CAROUSEL SECTION -->
<?php
$whyItems = [
    [
        'num' => '01',
        'title_vi' => 'Trải Nghiệm Chân Thực',
        'title_en' => 'Authentic Experiences',
        'desc_vi' => 'Khám phá những miền đất nguyên sơ và kết nối sâu sắc với thiên nhiên, con người cùng văn hóa địa phương.',
        'desc_en' => 'Explore untouched lands and forge genuine connections with local people, pristine nature, and ethnic traditions.',
        'img' => 'assets/images/bamboo-rafting.webp',
        'alt' => 'Bamboo Rafting Pu Luong'
    ],
    [
        'num' => '02',
        'title_vi' => 'Hành Trình Được Thiết Kế Riêng',
        'title_en' => 'Tailor-Made Journeys',
        'desc_vi' => 'Mỗi hành trình được điều chỉnh theo sở thích, thời gian và nhịp trải nghiệm riêng của từng du khách.',
        'desc_en' => 'Every itinerary is crafted around your pace, preferences, and personal travel style.',
        'img' => 'assets/images/hieu-waterfall.webp',
        'alt' => 'Pu Luong Waterfall'
    ],
    [
        'num' => '03',
        'title_vi' => 'Du Lịch Có Trách Nhiệm',
        'title_en' => 'Responsible Tourism',
        'desc_vi' => 'Tôn trọng thiên nhiên và văn hóa bản địa, đồng thời góp phần tạo sinh kế bền vững cho cộng đồng địa phương.',
        'desc_en' => 'Respecting nature and ethnic cultures while creating sustainable livelihoods for native communities.',
        'img' => 'assets/images/water-wheels.webp',
        'alt' => 'Pu Luong Water Wheels'
    ],
    [
        'num' => '04',
        'title_vi' => 'Đồng Hành Tận Tâm',
        'title_en' => 'Dedicated Companion',
        'desc_vi' => 'Đội ngũ am hiểu điểm đến luôn lắng nghe và hỗ trợ để mỗi hành trình diễn ra thuận lợi, an toàn và đáng nhớ.',
        'desc_en' => 'Our passionate local experts support you every step of the way for a seamless, safe, and memorable trip.',
        'img' => 'assets/images/silk-weaving.webp',
        'alt' => 'Traditional Silk Weaving'
    ],
];
?>

<section class="why-carousel-sec">
  <div class="why-carousel-container">
    
    <div class="why-carousel-header">
      <span class="why-eyebrow">WHY TRAVEL WITH US</span>
      <h2 class="why-title-white">
        <?= $isVi ? 'Vietnam Unique Travel — Hành Trình Mang Dấu Ấn Riêng' : 'Vietnam Unique Travel — Journeys Made Personal' ?>
      </h2>
    </div>

    <div class="why-stage-wrap">
      
      <button class="why-nav-btn why-nav-prev" onclick="moveWhySlide(-1)" aria-label="Previous Slide">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
      </button>

      <div class="why-carousel-stage" id="whyStage">
        <?php foreach ($whyItems as $idx => $item): ?>
          <div class="why-card" data-index="<?= $idx ?>" onclick="selectWhySlide(<?= $idx ?>)">
            <div class="why-card-img-wrap">
              <picture>
                <source srcset="<?= asset($item['img']) ?>" type="image/webp">
                <img src="<?= asset($item['img']) ?>" alt="<?= e($item['alt']) ?>" width="370" height="190" loading="lazy">
              </picture>
            </div>
            <span class="why-card-num"><?= $item['num'] ?></span>
            <h3 class="why-card-title"><?= e($isVi ? $item['title_vi'] : $item['title_en']) ?></h3>
            <p class="why-card-desc"><?= e($isVi ? $item['desc_vi'] : $item['desc_en']) ?></p>
            <div class="why-card-line"></div>
          </div>
        <?php endforeach; ?>
      </div>

      <button class="why-nav-btn why-nav-next" onclick="moveWhySlide(1)" aria-label="Next Slide">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </button>

    </div>

    <div class="why-dots-wrap" id="whyDots">
      <?php foreach ($whyItems as $idx => $item): ?>
        <button class="why-dot <?= $idx === 0 ? 'active' : '' ?>" onclick="selectWhySlide(<?= $idx ?>)" aria-label="Slide <?= $idx + 1 ?>"></button>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<script>
let currentWhyIdx = 0;
const whyCards = document.querySelectorAll('#whyStage .why-card');
const whyDots = document.querySelectorAll('#whyDots .why-dot');
const totalWhy = whyCards.length;
let whyTimer = null;

function renderWhyCarousel() {
  whyCards.forEach((card, i) => {
    card.className = 'why-card';
    const diff = (i - currentWhyIdx + totalWhy) % totalWhy;
    
    if (diff === 0) {
      card.classList.add('active');
    } else if (diff === 1) {
      card.classList.add('next');
    } else if (diff === totalWhy - 1) {
      card.classList.add('prev');
    } else if (diff < totalWhy / 2) {
      card.classList.add('hidden-right');
    } else {
      card.classList.add('hidden-left');
    }
  });

  whyDots.forEach((dot, i) => {
    dot.classList.toggle('active', i === currentWhyIdx);
  });
}

function moveWhySlide(dir) {
  currentWhyIdx = (currentWhyIdx + dir + totalWhy) % totalWhy;
  renderWhyCarousel();
  resetWhyAutoplay();
}

function selectWhySlide(idx) {
  currentWhyIdx = idx;
  renderWhyCarousel();
  resetWhyAutoplay();
}

function startWhyAutoplay() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  whyTimer = setInterval(() => {
    moveWhySlide(1);
  }, 6000);
}

function resetWhyAutoplay() {
  if (whyTimer) clearInterval(whyTimer);
  startWhyAutoplay();
}

// Touch Swipe Support
let touchStartX = 0;
let touchEndX = 0;
const stageEl = document.getElementById('whyStage');

if (stageEl) {
  stageEl.addEventListener('touchstart', e => {
    touchStartX = e.changedTouches[0].screenX;
  }, {passive: true});

  stageEl.addEventListener('touchend', e => {
    touchEndX = e.changedTouches[0].screenX;
    if (touchEndX < touchStartX - 40) moveWhySlide(1);
    if (touchEndX > touchStartX + 40) moveWhySlide(-1);
  }, {passive: true});

  stageEl.addEventListener('mouseenter', () => clearInterval(whyTimer));
  stageEl.addEventListener('mouseleave', startWhyAutoplay);
}

// Keyboard Navigation
document.addEventListener('keydown', e => {
  if (document.activeElement && ['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;
  if (e.key === 'ArrowLeft') moveWhySlide(-1);
  if (e.key === 'ArrowRight') moveWhySlide(1);
});

// Initial Render
renderWhyCarousel();
startWhyAutoplay();
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

<!-- BOOKING CTA BANNER -->
<section style="padding: 80px 0; background: linear-gradient(135deg, var(--color-brand-green) 0%, var(--color-forest-dark) 100%); color: #FFF; text-align: center;">
  <div class="container">
    <h2 style="font-size: 2.6rem; color: #FFF; margin-bottom: 16px;">Ready For An Unforgettable Journey?</h2>
    <p style="max-width: 600px; margin: 0 auto 32px; color: rgba(255,255,255,0.88); font-size: 1.1rem;">
      Let our travel specialists design your ideal Vietnam expedition. Fast response within minutes.
    </p>
    <a href="<?= base_url($prefix . 'booking') ?>" class="btn btn-gold" style="font-size: 1.1rem; padding: 16px 36px;">
      Plan Your Custom Trip Now &rarr;
    </a>
  </div>
</section>
