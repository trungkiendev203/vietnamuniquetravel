<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
$publishedDate = !empty($post['published_at']) ? date('d/m/Y', strtotime($post['published_at'])) : '12/08/2026';
$tagsList = !empty($post['tags']) ? array_filter(array_map('trim', explode(',', $post['tags']))) : ['Pù Luông', 'Kinh Nghiệm'];
$currentUrl = base_url(($lang === 'vi' ? 'vi/meo-du-lich/' : 'travel-tips/') . $post['slug']);
?>

<article class="tips-detail-page">
  <div class="container tips-detail-container">

    <!-- 1. ARTICLE TITLE & BREADCRUMB -->
    <header class="tips-detail-header">
      <nav class="tips-breadcrumb" aria-label="Breadcrumb">
        <a href="<?= base_url($prefix) ?>"><?= __('nav_home') ?></a>
        <span class="breadcrumb-sep">/</span>
        <a href="<?= base_url($prefix . ($lang === 'vi' ? 'meo-du-lich' : 'travel-tips')) ?>">
          <?= $lang === 'vi' ? 'Mẹo du lịch' : 'Travel Tips' ?>
        </a>
        <span class="breadcrumb-sep">/</span>
        <span class="breadcrumb-current"><?= e($post['title']) ?></span>
      </nav>

      <h1 class="tips-article-title"><?= e($post['title']) ?></h1>
    </header>

    <!-- 2. ARTICLE HERO IMAGE -->
    <div class="tips-detail-hero-img-wrap">
      <img 
        src="<?= asset($post['featured_image'] ?: 'assets/images/hero.webp') ?>" 
        alt="<?= e($post['title']) ?>" 
        class="tips-detail-hero-img"
      >
    </div>

    <!-- 3. TAGS & AUTHOR META ROW (Sovaba Style) -->
    <div class="tips-meta-tags-row">
      <!-- Tag Badges -->
      <div class="tips-tag-badges-group">
        <?php foreach ($tagsList as $tag): ?>
          <span class="tips-tag-badge"><?= e($tag) ?></span>
        <?php endforeach; ?>
      </div>

      <!-- Author Box -->
      <div class="tips-author-box">
        <div class="tips-author-avatar">
          <img src="<?= asset('assets/images/vnu-logo-transparent.png') ?>" alt="Author Avatar">
        </div>
        <div class="tips-author-info">
          <span class="tips-author-name">Vietnam Unique Travel</span>
          <span class="tips-post-date"><?= $lang === 'vi' ? 'Cập nhật:' : 'Updated:' ?> <?= $publishedDate ?></span>
        </div>
      </div>
    </div>

    <!-- 4. TWO-COLUMN MAIN CONTENT (70% Article + 30% Sidebar) -->
    <div class="tips-content-layout-grid">
      
      <!-- Left Column: Story Content -->
      <main class="tips-article-main-body">
        <?= $post['content'] ?>

        <!-- Share Buttons Bar -->
        <div class="tips-share-article-bar">
          <span class="share-bar-label"><?= $lang === 'vi' ? 'Chia sẻ bài viết:' : 'Share article:' ?></span>
          <div class="share-btns-group">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl) ?>" target="_blank" rel="noopener" class="tips-share-btn share-fb" aria-label="Share on Facebook">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
              <span>Facebook</span>
            </a>
            <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' ' . $currentUrl) ?>" target="_blank" rel="noopener" class="tips-share-btn share-wa" aria-label="Share on WhatsApp">
              💬 <span>WhatsApp</span>
            </a>
            <button type="button" class="tips-share-btn share-copy" id="copyLinkBtn" data-url="<?= $currentUrl ?>">
              🔗 <span id="copyLinkText"><?= $lang === 'vi' ? 'Sao chép link' : 'Copy link' ?></span>
            </button>
          </div>
        </div>

        <!-- 4.1 Photo Gallery Section -->
        <div class="tips-photo-gallery-wrap">
          <h3 class="gallery-sec-title"><?= $lang === 'vi' ? 'Bộ sưu tập hình ảnh Pù Luông' : 'Pu Luong Photo Gallery' ?></h3>
          <div class="tips-gallery-grid">
            <div class="tips-gallery-item">
              <img src="<?= asset('assets/images/pu-luong-misty-valley.webp') ?>" alt="Thung lũng ruộng bậc thang Pù Luông mây phủ" loading="lazy">
              <span class="gallery-caption"><?= $lang === 'vi' ? 'Thung lũng ruộng bậc thang mây phủ' : 'Misty Terraced Rice Valley' ?></span>
            </div>
            <div class="tips-gallery-item">
              <img src="<?= asset('assets/images/hieu-waterfall.webp') ?>" alt="Thác Hiêu nguyên sơ" loading="lazy">
              <span class="gallery-caption"><?= $lang === 'vi' ? 'Thác Hiêu nguyên sơ kỳ vĩ' : 'Pristine Hieu Waterfall' ?></span>
            </div>
            <div class="tips-gallery-item">
              <img src="<?= asset('assets/images/bamboo-rafting.webp') ?>" alt="Chèo bè tre sông Chăm" loading="lazy">
              <span class="gallery-caption"><?= $lang === 'vi' ? 'Chèo bè tre sông Chăm' : 'Cham River Bamboo Rafting' ?></span>
            </div>
            <div class="tips-gallery-item">
              <img src="<?= asset('assets/images/water-wheels.webp') ?>" alt="Guồng nước khổng lồ" loading="lazy">
              <span class="gallery-caption"><?= $lang === 'vi' ? 'Cụm guồng nước khổng lồ' : 'Giant Bamboo Water Wheels' ?></span>
            </div>
            <div class="tips-gallery-item">
              <img src="<?= asset('assets/images/silk-weaving.webp') ?>" alt="Dệt thổ cẩm truyền thống" loading="lazy">
              <span class="gallery-caption"><?= $lang === 'vi' ? 'Nghề dệt thổ cẩm người Thái' : 'Traditional Brocade Weaving' ?></span>
            </div>
            <div class="tips-gallery-item">
              <img src="<?= asset('assets/images/hero.webp') ?>" alt="Mùa lúa chín vàng óng" loading="lazy">
              <span class="gallery-caption"><?= $lang === 'vi' ? 'Mùa lúa chín vàng óng' : 'Golden Harvest Season' ?></span>
            </div>
          </div>
        </div>
      </main>

      <!-- Right Column: Sidebar (Related Posts & Tour CTA) -->
      <aside class="tips-sidebar-col">
        
        <!-- Widget: Related Posts (Bài viết liên quan) -->
        <?php if (!empty($relatedPosts)): ?>
          <div class="tips-sidebar-widget widget-related-posts">
            <h3 class="widget-title"><?= $lang === 'vi' ? 'Bài viết liên quan' : 'Related Articles' ?></h3>
            <div class="related-posts-list">
              <?php foreach ($relatedPosts as $rPost): ?>
                <?php 
                  $rUrl = base_url($prefix . ($lang === 'vi' ? 'meo-du-lich/' : 'travel-tips/') . $rPost['slug']);
                  $rDate = !empty($rPost['published_at']) ? date('d/m/Y', strtotime($rPost['published_at'])) : '12/08/2026';
                ?>
                <div class="related-post-card">
                  <a href="<?= $rUrl ?>" class="related-post-thumb-link">
                    <img src="<?= asset($rPost['featured_image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($rPost['title']) ?>" class="related-post-thumb" loading="lazy">
                  </a>
                  <div class="related-post-info">
                    <h4 class="related-post-title">
                      <a href="<?= $rUrl ?>"><?= e($rPost['title']) ?></a>
                    </h4>
                    <span class="related-post-date"><?= $rDate ?></span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Widget: Tour Suggestion CTA -->
        <div class="tips-sidebar-widget widget-tour-cta">
          <div class="tour-cta-badge"><?= $lang === 'vi' ? 'Hành trình gợi ý' : 'Recommended Tour' ?></div>
          <h4 class="tour-cta-title">
            <?= $lang === 'vi' ? 'Tour Pù Luông - Mai Châu 3N2Đ: Khám phá trọn vẹn thiên nhiên hoang sơ' : 'Pu Luong & Mai Chau 3D2N: Authentic Mountain & River Journey' ?>
          </h4>
          <p class="tour-cta-desc">
            <?= $lang === 'vi' ? 'Lên kế hoạch chuyến đi riêng trọn gói cùng hướng dẫn viên bản địa am hiểu.' : 'Craft your private custom itinerary with local travel experts.' ?>
          </p>
          <a href="<?= base_url($prefix . 'booking') ?>" class="btn btn-gold tour-cta-btn">
            <?= __('btn_book_tour') ?> &rarr;
          </a>
        </div>

      </aside>

    </div>

  </div>
</article>

<!-- 5. BOTTOM SECTION: FEATURED DESTINATIONS (Điểm đến nổi bật - Sovaba Style) -->
<?php if (!empty($featuredDestinations)): ?>
<section class="tips-dest-spotlight-sec">
  <div class="container">
    <div class="tips-spotlight-header">
      <h2 class="tips-spotlight-title"><?= $lang === 'vi' ? 'ĐIỂM ĐẾN NỔI BẬT' : 'FEATURED DESTINATIONS' ?></h2>
    </div>
    
    <div class="tips-dest-spotlight-grid">
      <?php foreach (array_slice($featuredDestinations, 0, 5) as $dest): ?>
        <?php $destUrl = base_url($prefix . 'destinations/' . $dest['slug']); ?>
        <a href="<?= $destUrl ?>" class="tips-dest-spotlight-card" aria-label="<?= e($dest['name']) ?>">
          <img src="<?= asset($dest['image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($dest['name']) ?>" class="tips-dest-spotlight-img" loading="lazy">
          <div class="tips-dest-spotlight-overlay"></div>
          <h3 class="tips-dest-spotlight-name"><?= e($dest['name']) ?></h3>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Smooth scroll for Table of Contents links
  document.querySelectorAll('.article-toc-box a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('href');
      const targetEl = document.querySelector(targetId);
      if (targetEl) {
        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // Copy Link Button
  const copyBtn = document.getElementById('copyLinkBtn');
  const copyText = document.getElementById('copyLinkText');
  if (copyBtn && copyText) {
    copyBtn.addEventListener('click', () => {
      const url = copyBtn.dataset.url || window.location.href;
      navigator.clipboard.writeText(url).then(() => {
        const orig = copyText.textContent;
        copyText.textContent = '<?= $lang === 'vi' ? 'Đã sao chép!' : 'Copied!' ?>';
        setTimeout(() => { copyText.textContent = orig; }, 2000);
      });
    });
  }
});
</script>
