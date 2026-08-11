<?php
$isVi = $lang === 'vi';
$prefix = $isVi ? 'vi/' : '';
?>
<main class="about-page">

  <!-- 1. Editorial Magazine Introduction -->
  <section style="padding: 90px 0 70px; background-color: #F8F6EF;">
    <div class="about-container">
      <span class="about-eyebrow"><?= $isVi ? 'VỀ VIETNAM UNIQUE TRAVEL' : 'ABOUT VIETNAM UNIQUE TRAVEL' ?></span>
      <h1 class="about-intro-h1">
        <?= $isVi ? 'Hành trình sâu sắc hơn.<br>Khám phá Việt Nam theo cách khác biệt.' : 'Travel deeper.<br>Discover Vietnam differently.' ?>
      </h1>
      <p class="about-intro-text">
        <?= $isVi 
          ? 'Vietnam Unique Travel là thương hiệu lữ hành chuyên cung cấp các chương trình du lịch trải nghiệm tại Việt Nam, mang đến những hành trình kết hợp hài hòa giữa thiên nhiên hoang sơ, văn hóa bản địa và du lịch có trách nhiệm.' 
          : 'Vietnam Unique Travel is a dedicated tour operator delivering immersive travel experiences across Vietnam. We blend untouched nature, rich indigenous heritage, and responsible community tourism to reveal the authentic soul of Vietnam.' ?>
      </p>
    </div>
  </section>

  <!-- 2. Three Key Differentiators -->
  <section style="padding: 80px 0; background-color: #FFFFFF;">
    <div class="about-container">
      <div class="diff-grid">
        
        <div class="diff-col">
          <img src="<?= asset('assets/images/bamboo-rafting.webp') ?>" alt="<?= $isVi ? 'Am hiểu địa phương' : 'Local Expertise' ?>" loading="lazy">
          <h3><?= $isVi ? 'Am hiểu địa phương' : 'Local Expertise' ?></h3>
          <p>
            <?= $isVi 
              ? 'Đội ngũ người Việt am hiểu bản địa, nhiệt huyết và giàu kinh nghiệm, sẵn sàng đưa bạn đến những điểm đến nguyên sơ và những bản làng mây phủ ít người biết đến.' 
              : 'Our young, passionate local team brings deep knowledge of hidden sanctuaries, ethnic traditions, and untouched trails far off the commercial grid.' ?>
          </p>
        </div>

        <div class="diff-col">
          <img src="<?= asset('assets/images/silk-weaving.webp') ?>" alt="<?= $isVi ? 'Tận tâm & Tinh tế' : 'Thoughtful Service' ?>" loading="lazy">
          <h3><?= $isVi ? 'Tận tâm & Tinh tế' : 'Thoughtful Service' ?></h3>
          <p>
            <?= $isVi 
              ? 'Từ khâu tư vấn đến từng chặng đường hành trình, chúng tôi chăm chút tỉ mỉ với sự chu đáo, linh hoạt và sự ấm áp chân thành của người Việt.' 
              : 'From initial consultation to on-the-ground support, we craft every detail with safety, flexibility, and genuine Vietnamese hospitality.' ?>
          </p>
        </div>

        <div class="diff-col">
          <img src="<?= asset('assets/images/water-wheels.webp') ?>" alt="<?= $isVi ? 'Hành trình riêng bản sắc' : 'Tailor-Made Journeys' ?>" loading="lazy">
          <h3><?= $isVi ? 'Hành trình riêng bản sắc' : 'Tailor-Made Journeys' ?></h3>
          <p>
            <?= $isVi 
              ? 'Chương trình được nghiên cứu và thiết kế riêng theo nhu cầu của từng nhóm khách, linh hoạt và không rập khuôn theo các tour đại trà.' 
              : 'Custom itineraries built around your pace and curiosity, avoiding mass-market templates to create unforgettable personal memories.' ?>
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- 3. Brand Story (Editorial 55/45 Split) -->
  <section style="padding: 100px 0; background-color: #F8F6EF;">
    <div class="about-container">
      <div class="story-grid">
        
        <div>
          <img src="<?= asset('assets/images/hieu-waterfall.webp') ?>" alt="<?= $isVi ? 'Thác Hiếu Pu Luông' : 'Pu Luong Waterfall' ?>" class="story-img" loading="lazy">
        </div>

        <div class="story-content">
          <span class="about-eyebrow"><?= $isVi ? 'CÂU CHUYỆN THƯƠNG HIỆU' : 'OUR STORY' ?></span>
          <h2><?= $isVi ? 'Khởi nguồn từ tình yêu với một Việt Nam chân thực' : 'Born from a love for the real Vietnam' ?></h2>
          <p>
            <?= $isVi 
              ? 'Việt Nam sở hữu vô vàn cảnh quan thiên nhiên tuyệt đẹp cùng nền văn hóa đa dạng trải dài từ Bắc vào Nam. Tuy nhiên, những giá trị đáng quý nhất thường không nằm ở các điểm du lịch đông đúc mà ẩn mình trong những bản làng yên bình, những cung đường ít người biết đến và những câu chuyện của người dân địa phương.' 
              : 'Vietnam possesses magnificent natural landscapes and a vibrant cultural heritage spanning from North to South. However, the most precious moments rarely lie in crowded tourist hotspots, but rather hide in tranquil mountain hamlets, peaceful country paths, and the authentic stories of local people.' ?>
          </p>
          <p>
            <?= $isVi 
              ? 'Vietnam Unique Travel được thành lập với mong muốn đưa du khách khám phá một Việt Nam chân thực hơn, nơi mỗi chuyến đi không chỉ là tham quan mà còn là hành trình trải nghiệm, kết nối và thấu hiểu.' 
              : 'Vietnam Unique Travel was established to take travelers deeper into Vietnam—where every trip is not just sightseeing, but a meaningful journey of discovery, genuine connection, and mutual respect.' ?>
          </p>

          <blockquote class="story-quote">
            <?= $isVi 
              ? '“Chúng tôi không chỉ bán một tour du lịch mà mong muốn tạo nên những kỷ niệm đáng nhớ, những kết nối ý nghĩa giữa du khách với Việt Nam.”' 
              : '“We don’t just sell tours; we aim to create unforgettable memories and meaningful connections between travelers and Vietnam.”' ?>
          </blockquote>
        </div>

      </div>
    </div>
  </section>

  <!-- 4. Vision & Mission (Premium Eco-Luxury Editorial Section) -->
  <section class="vision-mission-sec" aria-label="Vision and Mission">
    <!-- Decorative Background Elements -->
    <div class="vm-bg-watermark" aria-hidden="true">PURPOSE</div>
    <svg class="vm-bg-contours" viewBox="0 0 1440 600" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path d="M-100 200 C300 100, 700 350, 1540 150" stroke="rgba(255,255,255,0.035)" stroke-width="1.5"/>
      <path d="M-100 350 C400 250, 800 450, 1540 300" stroke="rgba(255,255,255,0.04)" stroke-width="1.5"/>
      <path d="M-100 500 C500 400, 900 550, 1540 450" stroke="rgba(255,255,255,0.025)" stroke-width="1.5"/>
    </svg>

    <div class="about-container vm-container">
      
      <!-- Section Header -->
      <header class="vm-header">
        <span class="vm-eyebrow">
          <span class="vm-eyebrow-line" aria-hidden="true"></span>
          <?= $isVi ? 'ĐỘNG LỰC CỦA CHÚNG TÔI' : 'WHAT DRIVES US' ?>
        </span>
        <h2 class="vm-title">
          <span class="vm-title-main"><?= $isVi ? 'Du lịch có mục đích.' : 'Travel with purpose.' ?></span>
          <span class="vm-title-sub"><?= $isVi ? 'Để lại dấu chân tích cực.' : 'Leave a positive footprint.' ?></span>
        </h2>
        <p class="vm-intro">
          <?= $isVi 
            ? 'Chúng tôi kiến tạo những hành trình đầy ý nghĩa, kết nối du khách với tâm hồn Việt Nam đồng thời gìn giữ vẻ đẹp diệu kỳ của mỗi điểm đến.' 
            : 'We create meaningful journeys that connect travelers with the soul of Vietnam while protecting what makes each destination extraordinary.' ?>
        </p>
      </header>

      <!-- Editorial Grid: 2 Distinct Cards -->
      <div class="vm-editorial-grid">
        
        <!-- CARD 01: VISION -->
        <article class="vm-card vm-card-vision">
          <div>
            <div class="vm-card-badge">
              <span class="vm-card-num">01</span>
              <span class="vm-card-label"><?= $isVi ? 'OUR VISION — TẦM NHÌN' : '01 — OUR VISION' ?></span>
            </div>
            <h3 class="vm-card-h3"><?= $isVi ? 'Thương hiệu lữ hành uy tín' : 'Trusted Authentic Journeys' ?></h3>
            <p class="vm-card-quote">
              “<?= $isVi 
                ? 'Trở thành một trong những thương hiệu lữ hành uy tín của Việt Nam, được khách hàng quốc tế tin tưởng lựa chọn nhờ những hành trình trải nghiệm chân thực, khác biệt và bền vững.' 
                : 'To become a leading trusted travel brand in Vietnam, chosen by international travelers for authentic, distinct, and sustainable travel experiences.' ?>”
            </p>
          </div>
          <div class="vm-card-footer">
            <span class="vm-tag-pill"><?= $isVi ? 'Chân thực & Bền vững' : 'Authentic & Sustainable' ?></span>
          </div>
        </article>

        <!-- CARD 02: MISSION -->
        <article class="vm-card vm-card-mission">
          <div>
            <div class="vm-card-badge">
              <span class="vm-card-num">02</span>
              <span class="vm-card-label"><?= $isVi ? 'OUR MISSION — SỨ MỆNH' : '02 — OUR MISSION' ?></span>
            </div>
            <h3 class="vm-card-h3"><?= $isVi ? 'Kết nối & Bảo tồn văn hóa' : 'Connecting & Preserving' ?></h3>
            <p class="vm-card-quote">
              “<?= $isVi 
                ? 'Mang vẻ đẹp thiên nhiên và văn hóa Việt Nam đến gần hơn với bạn bè quốc tế, thúc đẩy du lịch có trách nhiệm, góp phần bảo tồn văn hóa truyền thống, bảo vệ môi trường và tạo sinh kế bền vững cho cộng đồng địa phương.' 
                : 'Bringing Vietnam’s natural and cultural beauty closer to global friends, fostering responsible travel that protects pristine ecosystems, preserves ethnic traditions, and supports sustainable local livelihoods.' ?>”
            </p>
          </div>
          <div class="vm-card-footer">
            <span class="vm-tag-pill"><?= $isVi ? 'Bảo tồn & Cộng đồng' : 'Ecosystems & Livelihoods' ?></span>
          </div>
        </article>

      </div>

    </div>
  </section>

  <!-- 5. Core Values Editorial List -->
  <section style="padding: 100px 0; background-color: #FFFFFF;">
    <div class="about-container">
      <div style="margin-bottom: 50px;">
        <span class="about-eyebrow"><?= $isVi ? 'GIÁ TRỊ CỐT LÕI' : 'OUR CORE VALUES' ?></span>
        <h2 style="font-family: var(--font-heading); font-size: clamp(2rem, 3vw, 2.8rem); font-weight: 800; color: var(--color-brand-green); margin-top: 6px;">
          <?= $isVi ? 'Những nguyên tắc định hình mỗi hành trình' : 'The principles guiding every journey' ?>
        </h2>
      </div>

      <div class="core-val-list">
        
        <div class="core-val-item">
          <span class="cv-num">01</span>
          <h3 class="cv-title"><?= $isVi ? 'Trải nghiệm chân thực' : 'Authentic Experiences' ?></h3>
          <p class="cv-desc">
            <?= $isVi 
              ? 'Chúng tôi thiết kế các chương trình giúp du khách khám phá một Việt Nam nguyên bản thông qua thiên nhiên, văn hóa và đời sống địa phương.' 
              : 'Designing programs that reveal pristine destinations, authentic ethnic culture, and local daily life, avoiding mass commercial templates.' ?>
          </p>
        </div>

        <div class="core-val-item">
          <span class="cv-num">02</span>
          <h3 class="cv-title"><?= $isVi ? 'Tôn trọng văn hóa bản địa' : 'Local Respect' ?></h3>
          <p class="cv-desc">
            <?= $isVi 
              ? 'Tôn trọng phong tục bản địa, ưu tiên hợp tác và chia sẻ lợi ích trực tiếp với người dân và cộng đồng địa phương.' 
              : 'Honoring indigenous traditions, collaborating directly with local hosts, and ensuring cultural integrity in every village visited.' ?>
          </p>
        </div>

        <div class="core-val-item">
          <span class="cv-num">03</span>
          <h3 class="cv-title"><?= $isVi ? 'Du lịch có trách nhiệm' : 'Responsible Tourism' ?></h3>
          <p class="cv-desc">
            <?= $isVi 
              ? 'Hạn chế tác động tiêu cực tới thiên nhiên, gìn giữ cảnh quan hoang sơ và thúc đẩy sự phát triển kinh tế bền vững cho điểm đến.' 
              : 'Minimizing environmental footprint, promoting eco-friendly habits, and supporting long-term community livelihoods.' ?>
          </p>
        </div>

        <div class="core-val-item">
          <span class="cv-num">04</span>
          <h3 class="cv-title"><?= $isVi ? 'Chuyên nghiệp & Tận tâm' : 'Safety & Thoughtful Care' ?></h3>
          <p class="cv-desc">
            <?= $isVi 
              ? 'Luôn đặt sự an toàn, minh bạch và sự hài lòng của du khách lên hàng đầu với sự phục vụ tận tình 24/7 trong suốt hành trình.' 
              : 'Dedicated 24/7 care, rigorous service standards, and continuous support before, during, and after every trip.' ?>
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- 6. Responsible Tourism Section -->
  <section style="padding: 100px 0; background-color: #F8F6EF;">
    <div class="about-container">
      <div class="story-grid">
        
        <div>
          <span class="about-eyebrow"><?= $isVi ? 'DU LỊCH CÓ TRÁCH NHIỆM' : 'RESPONSIBLE TOURISM' ?></span>
          <h2 style="font-family: var(--font-heading); font-size: clamp(1.8rem, 3vw, 2.6rem); font-weight: 800; color: var(--color-brand-green); margin-bottom: 20px; line-height: 1.25;">
            <?= $isVi ? 'Chuyến đi mang lại giá trị thiết thực' : 'Traveling with purpose and respect' ?>
          </h2>
          <p style="font-size: 1.05rem; line-height: 1.8; color: #334155; margin-bottom: 20px;">
            <?= $isVi 
              ? 'Chúng tôi tin rằng mỗi chuyến đi không chỉ mang lại trải nghiệm cho du khách mà còn phải tạo ra những giá trị tích cực cho điểm đến. Bằng cách hợp tác trực tiếp với các hộ dân, hướng dẫn viên bản địa và nghệ nhân truyền thống, chúng tôi góp phần bảo tồn văn hóa và tạo sinh kế bền vững tại các bản làng.' 
              : 'We believe every journey should generate positive values for both travelers and local hosts. By partnering directly with homestays, native guides, and traditional craft artisans, we help preserve cultural heritage and support sustainable livelihoods in rural communities like Pu Luong.' ?>
          </p>
          <a href="<?= base_url($prefix . 'responsible-tourism') ?>" class="btn btn-outline" style="border-color: var(--color-brand-green); color: var(--color-brand-green);">
            <?= $isVi ? 'Tìm hiểu cam kết du lịch có trách nhiệm' : 'Read Our Responsible Tourism Policy' ?> &rarr;
          </a>
        </div>

        <div class="resp-collage">
          <img src="<?= asset('assets/images/bamboo-rafting.webp') ?>" alt="Bamboo Rafting Pu Luong" loading="lazy">
          <img src="<?= asset('assets/images/silk-weaving.webp') ?>" alt="Local Brocade Weaving" loading="lazy">
        </div>

      </div>
    </div>
  </section>

  <!-- 7. Full-Width Nature Photo CTA -->
  <section style="position: relative; background: url('<?= asset('assets/images/hero.webp') ?>') center/cover no-repeat; padding: 130px 0; text-align: center; color: #FFFFFF;">
    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(2, 47, 19, 0.75) 0%, rgba(0, 0, 0, 0.82) 100%);"></div>
    <div class="about-container" style="position: relative; z-index: 2;">
      <h2 class="cta-artistic-heading">
        <?= $isVi ? 'HÃY ĐỂ VIỆT NAM TRỞ THÀNH MỘT PHẦN<br>TRONG CÂU CHUYỆN CỦA BẠN.' : 'LET VIETNAM BECOME PART<br>OF YOUR STORY.' ?>
      </h2>
      <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="<?= base_url($prefix . 'tours') ?>" class="btn btn-gold"><?= __('btn_explore_tours') ?></a>
        <a href="<?= base_url($prefix . 'contact') ?>" class="btn btn-outline-white"><?= __('btn_plan_trip') ?></a>
      </div>
    </div>
  </section>

</main>
