<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
$currentCategory = $activeFilters['category'] ?? 'all';
$currentDestination = $activeFilters['destination'] ?? 'all';
$currentSearch = $activeFilters['q'] ?? '';

$categoryList = [
    'all' => $lang === 'vi' ? 'Tất cả' : 'All',
    'news' => $lang === 'vi' ? 'Tin tức' : 'News',
    'culture' => $lang === 'vi' ? 'Văn hoá' : 'Culture',
    'food' => $lang === 'vi' ? 'Ẩm thực' : 'Cuisine',
    'experience' => $lang === 'vi' ? 'Kinh Nghiệm' : 'Travel Tips',
    'stay' => $lang === 'vi' ? 'Lưu Trú' : 'Stays & Eco-Lodges',
    'activities' => $lang === 'vi' ? 'Hoạt động trải nghiệm' : 'Adventures'
];
?>

<!-- 1. HERO BANNER SECTION (Sovaba Style) -->
<section class="tips-hero-sec">
  <div class="tips-hero-overlay"></div>
  <div class="container tips-hero-container">
    <h1 class="tips-hero-title">
      <?= $lang === 'vi' 
        ? 'Mẹo du lịch: Bí quyết tận hưởng chuyến đi trọn vẹn' 
        : 'Travel Tips: Secrets to a Complete & Authentic Journey' 
      ?>
    </h1>
    <p class="tips-hero-sub">
      <?= $lang === 'vi' 
        ? 'Chia sẻ bí quyết lên kế hoạch thông minh, tiết kiệm chi phí, sắp xếp hành lý gọn nhẹ và tận hưởng trọn vẹn từng trải nghiệm. Hướng dẫn thực tế cho mọi hành trình thêm suôn sẻ và đáng nhớ.' 
        : 'Expert advice on smart planning, packing light, cultural etiquette, and responsible travel. Practical guides to make every adventure meaningful and memorable.' 
      ?>
    </p>

    <!-- Destination Filter Pill -->
    <div class="tips-hero-search-wrap">
      <div class="tips-dest-dropdown-pill">
        <svg class="tips-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <select id="heroDestSelect" class="tips-dest-select" aria-label="Select Destination">
          <option value="all"><?= $lang === 'vi' ? 'Chọn điểm đến' : 'Select destination' ?></option>
          <?php foreach ($destinations as $dest): ?>
            <option value="<?= $dest['id'] ?>" <?= ($currentDestination == $dest['id']) ? 'selected' : '' ?>>
              <?= e($dest['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <span class="tips-select-arrow">▾</span>
      </div>
    </div>

    <!-- Scroll Down Link -->
    <a href="#trending-tips" class="tips-scroll-down-btn">
      <span><?= $lang === 'vi' ? 'Khám phá' : 'Explore' ?></span>
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="6 9 12 15 18 9"></polyline>
      </svg>
    </a>
  </div>
</section>

<!-- 2. TRENDING TRAVEL TIPS & CATEGORY FILTER (Xu hướng du lịch) -->
<section id="trending-tips" class="tips-main-section">
  <div class="container">
    
    <!-- Section Title -->
    <div class="tips-section-header">
      <h2 class="tips-sec-title"><?= $lang === 'vi' ? 'Xu hướng du lịch' : 'Travel Insights & Trends' ?></h2>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="tips-toolbar-row">
      <!-- Search Input Box -->
      <div class="tips-search-box">
        <svg class="search-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input 
          type="text" 
          id="tipsSearchInput" 
          class="tips-search-input" 
          placeholder="<?= $lang === 'vi' ? 'Tìm kiếm tiêu đề bài viết...' : 'Search article titles...' ?>" 
          value="<?= e($currentSearch) ?>"
          autocomplete="off"
        >
        <?php if (!empty($currentSearch)): ?>
          <button id="clearTipsSearch" class="tips-clear-search-btn" aria-label="Clear search">&times;</button>
        <?php endif; ?>
      </div>

      <!-- Category Filter Pills -->
      <div class="tips-category-pills-wrap">
        <?php foreach ($categoryList as $catKey => $catLabel): ?>
          <button 
            type="button" 
            class="tips-cat-pill <?= ($currentCategory === $catKey) ? 'active' : '' ?>" 
            data-category="<?= $catKey ?>"
          >
            <?= e($catLabel) ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Articles 4-Column Grid -->
    <div id="tipsCardsGrid" class="tips-cards-grid">
      <?php if (empty($posts)): ?>
        <div class="tips-no-results">
          <p><?= $lang === 'vi' ? 'Không tìm thấy bài viết nào phù hợp. Vui lòng thử từ khóa hoặc danh mục khác.' : 'No articles found matching your criteria. Try another keyword or category.' ?></p>
        </div>
      <?php else: ?>
        <?php foreach ($posts as $post): ?>
          <?php 
            $articleUrl = base_url($prefix . ($lang === 'vi' ? 'meo-du-lich/' : 'travel-tips/') . $post['slug']);
            $postDate = !empty($post['published_at']) ? date('d/m/Y', strtotime($post['published_at'])) : '12/08/2026';
            $catLabel = $categoryList[$post['category'] ?? 'experience'] ?? ($lang === 'vi' ? 'Kinh Nghiệm' : 'Tips');
          ?>
          <article class="tips-card-item">
            <a href="<?= $articleUrl ?>" class="tips-card-thumb-link" aria-label="<?= e($post['title']) ?>">
              <img 
                src="<?= asset($post['featured_image'] ?: 'assets/images/hero.webp') ?>" 
                alt="<?= e($post['title']) ?>" 
                class="tips-card-img" 
                loading="lazy"
              >
              <span class="tips-card-cat-badge"><?= e($catLabel) ?></span>
            </a>
            <div class="tips-card-body">
              <h3 class="tips-card-title">
                <a href="<?= $articleUrl ?>" title="<?= e($post['title']) ?>">
                  <?= e($post['title']) ?>
                </a>
              </h3>
              <div class="tips-card-meta">
                <span class="tips-card-date"><?= $postDate ?></span>
                <?php if (!empty($post['read_time'])): ?>
                  <span class="tips-card-readtime"> • <?= e($post['read_time']) ?></span>
                <?php endif; ?>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</section>

<!-- Client-side Fast Filter & AJAX Handling -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('tipsSearchInput');
  const catPills = document.querySelectorAll('.tips-cat-pill');
  const destSelect = document.getElementById('heroDestSelect');
  const gridContainer = document.getElementById('tipsCardsGrid');
  const clearBtn = document.getElementById('clearTipsSearch');

  let currentCategory = '<?= $currentCategory ?>';
  let currentDest = '<?= $currentDestination ?>';
  let searchTimer = null;

  function fetchFilteredPosts() {
    const query = searchInput ? searchInput.value.trim() : '';
    const params = new URLSearchParams({
      category: currentCategory,
      destination: currentDest,
      q: query,
      format: 'json'
    });

    const fetchUrl = '<?= base_url(($lang === 'vi' ? 'vi/meo-du-lich' : 'travel-tips')) ?>?' + params.toString();

    // Visual feedback
    if (gridContainer) gridContainer.style.opacity = '0.5';

    fetch(fetchUrl, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      if (gridContainer) {
        gridContainer.style.opacity = '1';
        renderCards(data.posts || []);
      }
    })
    .catch(err => {
      console.error('Filter fetch error:', err);
      if (gridContainer) gridContainer.style.opacity = '1';
    });
  }

  function renderCards(posts) {
    if (!gridContainer) return;

    if (!posts || posts.length === 0) {
      gridContainer.innerHTML = `
        <div class="tips-no-results" style="grid-column: 1 / -1; text-align: center; padding: 50px 0;">
          <p style="color: #64748B; font-size: 1.05rem;">
            <?= $lang === 'vi' ? 'Không tìm thấy bài viết nào phù hợp. Vui lòng thử lại.' : 'No articles found matching your criteria.' ?>
          </p>
        </div>
      `;
      return;
    }

    const prefix = '<?= $prefix ?>';
    const lang = '<?= $lang ?>';
    const catMap = <?= json_encode($categoryList) ?>;

    let html = '';
    posts.forEach(post => {
      const slugUrl = '<?= base_url() ?>/' + prefix + (lang === 'vi' ? 'meo-du-lich/' : 'travel-tips/') + post.slug;
      const dateFormatted = post.published_at ? new Date(post.published_at).toLocaleDateString('vi-VN') : '12/08/2026';
      const catName = catMap[post.category] || (lang === 'vi' ? 'Kinh Nghiệm' : 'Tips');
      const readTime = post.read_time ? ` • ${post.read_time}` : '';
      const imgPath = '<?= base_url() ?>' + (post.featured_image ? post.featured_image : '/assets/images/hero.webp');

      html += `
        <article class="tips-card-item">
          <a href="${slugUrl}" class="tips-card-thumb-link" aria-label="${post.title}">
            <img src="${imgPath}" alt="${post.title}" class="tips-card-img" loading="lazy">
            <span class="tips-card-cat-badge">${catName}</span>
          </a>
          <div class="tips-card-body">
            <h3 class="tips-card-title">
              <a href="${slugUrl}" title="${post.title}">${post.title}</a>
            </h3>
            <div class="tips-card-meta">
              <span class="tips-card-date">${dateFormatted}</span>
              <span class="tips-card-readtime">${readTime}</span>
            </div>
          </div>
        </article>
      `;
    });

    gridContainer.innerHTML = html;
  }

  // Category Pill Click
  catPills.forEach(pill => {
    pill.addEventListener('click', () => {
      catPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');
      currentCategory = pill.dataset.category || 'all';
      fetchFilteredPosts();
    });
  });

  // Destination Select Change
  if (destSelect) {
    destSelect.addEventListener('change', () => {
      currentDest = destSelect.value;
      fetchFilteredPosts();
      const trendSec = document.getElementById('trending-tips');
      if (trendSec) trendSec.scrollIntoView({ behavior: 'smooth' });
    });
  }

  // Search Input Typing (Debounced 300ms)
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      clearTimeout(searchTimer);
      searchTimer = setTimeout(fetchFilteredPosts, 300);
    });
  }

  // Clear Search Button
  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      if (searchInput) {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        fetchFilteredPosts();
      }
    });
  }
});
</script>
