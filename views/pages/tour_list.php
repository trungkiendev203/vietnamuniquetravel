<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
$currentSort = $activeFilters['sort'] ?? 'recommended';
$currentDest = $activeFilters['destination'] ?? 'all';
$currentExp = (array)($activeFilters['experience'] ?? []);
$currentDur = $activeFilters['duration'] ?? 'all';

// Helper for duration badge
function get_duration_badge($t, $lang) {
    $durType = $t['duration_type'] ?? 'fullday';
    $days = (int)($t['duration_days'] ?? 1);
    
    if ($durType === 'halfday') {
        return $lang === 'vi' ? 'Nửa Ngày' : 'Half Day';
    }
    if ($durType === 'fullday' || $days === 1) {
        return $lang === 'vi' ? '1 Ngày' : '1 Day';
    }
    if ($days === 2) {
        return $lang === 'vi' ? '2 Ngày 1 Đêm' : '2 Days 1 Night';
    }
    if ($days === 3) {
        return $lang === 'vi' ? '3 Ngày 2 Đêm' : '3 Days 2 Nights';
    }
    if ($days === 4) {
        return $lang === 'vi' ? '4 Ngày 3 Đêm' : '4 Days 3 Nights';
    }
    if ($days >= 5) {
        return $lang === 'vi' ? ($days . ' Ngày ' . ($days - 1) . ' Đêm') : ($days . ' Days ' . ($days - 1) . ' Nights');
    }
    return $lang === 'vi' ? 'Trong Ngày' : 'Day Trip';
}
?>

<link rel="stylesheet" href="<?= asset('assets/css/tours.css') ?>">

<!-- Creative Luxury Editorial Header -->
<section class="tours-editorial-header">
  <div class="tours-header-container">
    <div class="tours-header-grid">
      
      <!-- Left Column: Title & Editorial Narrative -->
      <div class="tours-header-content">
        <!-- Breadcrumb -->
        <nav class="tours-breadcrumb" aria-label="Breadcrumb">
          <a href="<?= base_url($prefix) ?>"><?= __('nav_home') ?></a>
          <span class="sep">/</span>
          <span class="current"><?= __('nav_tours') ?></span>
        </nav>

        <!-- Eyebrow & Badges -->
        <div class="tours-eyebrow-box">
          <span class="tours-eyebrow"><?= __('our_journeys') ?></span>
          <span class="tours-eyebrow-badge">✦ <?= $lang === 'vi' ? 'CHUYẾN ĐI ĐẶC SẮC' : 'CURATED ITINERARIES' ?></span>
        </div>

        <!-- Luxury Serif Headline with Italic Accent -->
        <h1 class="tours-headline">
          <?php if ($lang === 'vi'): ?>
            Khám phá <span class="headline-italic-accent">Việt Nam</span>, theo cách riêng của bạn.
          <?php else: ?>
            Explore <span class="headline-italic-accent">Vietnam</span>, your own way.
          <?php endif; ?>
        </h1>

        <!-- Description -->
        <p class="tours-description"><?= __('explore_vietnam_desc') ?></p>

        <!-- Feature Highlight Perks -->
        <div class="tours-header-perks">
          <div class="tours-perk-pill">
            <span class="tours-perk-icon">🌿</span>
            <span><?= $lang === 'vi' ? '100% Hướng dẫn viên bản địa' : '100% Local Expert Guides' ?></span>
          </div>
          <div class="tours-perk-pill">
            <span class="tours-perk-icon">⛰️</span>
            <span><?= $lang === 'vi' ? 'Thiên nhiên nguyên bản' : 'Pristine Nature Reserves' ?></span>
          </div>
          <div class="tours-perk-pill">
            <span class="tours-perk-icon">✨</span>
            <span><?= $lang === 'vi' ? 'Nhóm nhỏ & Riêng tư' : 'Small Groups & Bespoke' ?></span>
          </div>
        </div>
      </div>

      <!-- Right Column: Quick Destination Mood Box -->
      <div class="tours-header-dest-card">
        <div class="tours-header-dest-title">
          <span>✦ <?= $lang === 'vi' ? 'KHÁM PHÁ THEO ĐIỂM ĐẾN' : 'DISCOVER BY REGION' ?></span>
          <span style="font-size: 0.72rem; color: #8C9E94; font-weight: 600;">12 <?= __('journeys') ?></span>
        </div>

        <div class="tours-header-dest-grid">
          <button type="button" class="tours-dest-quick-btn js-quick-dest <?= $currentDest === 'pu-luong' ? 'active' : '' ?>" data-dest="pu-luong">
            <img src="<?= asset('assets/images/hieu-waterfall.webp') ?>" alt="Pu Luong" class="tours-dest-thumb">
            <div class="tours-dest-quick-info">
              <span class="tours-dest-quick-name">Pu Luong</span>
              <span class="tours-dest-quick-count">8 <?= $lang === 'vi' ? 'hành trình' : 'journeys' ?></span>
            </div>
          </button>

          <button type="button" class="tours-dest-quick-btn js-quick-dest <?= $currentDest === 'mai-chau' ? 'active' : '' ?>" data-dest="mai-chau">
            <img src="<?= asset('assets/images/water-wheels.webp') ?>" alt="Mai Chau" class="tours-dest-thumb">
            <div class="tours-dest-quick-info">
              <span class="tours-dest-quick-name">Mai Chau</span>
              <span class="tours-dest-quick-count">2 <?= $lang === 'vi' ? 'hành trình' : 'journeys' ?></span>
            </div>
          </button>

          <button type="button" class="tours-dest-quick-btn js-quick-dest <?= $currentDest === 'ninh-binh' ? 'active' : '' ?>" data-dest="ninh-binh">
            <img src="<?= asset('assets/images/bamboo-rafting.webp') ?>" alt="Ninh Binh" class="tours-dest-thumb">
            <div class="tours-dest-quick-info">
              <span class="tours-dest-quick-name">Ninh Binh</span>
              <span class="tours-dest-quick-count">1 <?= $lang === 'vi' ? 'hành trình' : 'journey' ?></span>
            </div>
          </button>

          <button type="button" class="tours-dest-quick-btn js-quick-dest <?= $currentDest === 'northern-vietnam' ? 'active' : '' ?>" data-dest="northern-vietnam">
            <img src="<?= asset('assets/images/hero.webp') ?>" alt="Northern Vietnam" class="tours-dest-thumb">
            <div class="tours-dest-quick-info">
              <span class="tours-dest-quick-name">North Frontier</span>
              <span class="tours-dest-quick-count">2 <?= $lang === 'vi' ? 'hành trình' : 'journeys' ?></span>
            </div>
          </button>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Main Listing Section -->
<section class="tours-main-section" id="tours-results-section">
  <div class="tours-layout-container">

    <!-- LEFT FILTER SIDEBAR (Desktop Sticky) -->
    <aside class="tours-sidebar" aria-label="Filter tours">
      <div class="tours-filter-heading-row">
        <h2 class="tours-filter-heading"><?= __('filter_by') ?></h2>
        <button type="button" class="tours-filter-clear-btn js-clear-filters" aria-label="Clear all filters"><?= __('filter_clear_all') ?></button>
      </div>

      <!-- DESTINATION -->
      <div class="tours-filter-group">
        <h3 class="tours-filter-group-title"><?= __('filter_destination') ?></h3>
        <ul class="tours-filter-list">
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_destination" value="all" class="filter-custom-input" <?= $currentDest === 'all' || empty($currentDest) ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('filter_all') ?></span>
              </span>
              <span class="filter-count-badge" data-count-type="dest" data-count-val="all"><?= count($allTours) ?></span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_destination" value="pu-luong" class="filter-custom-input" <?= $currentDest === 'pu-luong' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name">Pu Luong</span>
              </span>
              <span class="filter-count-badge" data-count-type="dest" data-count-val="pu-luong">8</span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_destination" value="mai-chau" class="filter-custom-input" <?= $currentDest === 'mai-chau' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name">Mai Chau</span>
              </span>
              <span class="filter-count-badge" data-count-type="dest" data-count-val="mai-chau">2</span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_destination" value="ninh-binh" class="filter-custom-input" <?= $currentDest === 'ninh-binh' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name">Ninh Binh</span>
              </span>
              <span class="filter-count-badge" data-count-type="dest" data-count-val="ninh-binh">1</span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_destination" value="northern-vietnam" class="filter-custom-input" <?= $currentDest === 'northern-vietnam' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name">Northern Vietnam</span>
              </span>
              <span class="filter-count-badge" data-count-type="dest" data-count-val="northern-vietnam">2</span>
            </label>
          </li>
        </ul>
      </div>

      <!-- EXPERIENCE -->
      <div class="tours-filter-group">
        <h3 class="tours-filter-group-title"><?= __('filter_experience') ?></h3>
        <ul class="tours-filter-list">
          <?php
          $expList = [
              ['slug' => 'adventure', 'name' => 'Adventure'],
              ['slug' => 'cultural', 'name' => 'Cultural'],
              ['slug' => 'trekking', 'name' => 'Trekking'],
              ['slug' => 'nature', 'name' => 'Nature'],
              ['slug' => 'local-life', 'name' => 'Local Life'],
              ['slug' => 'private', 'name' => 'Private']
          ];
          foreach ($expList as $exp):
              $isChecked = in_array($exp['slug'], (array)$currentExp);
          ?>
            <li>
              <label class="filter-control-label">
                <span class="filter-control-left">
                  <input type="checkbox" name="filter_experience[]" value="<?= $exp['slug'] ?>" class="filter-custom-input" <?= $isChecked ? 'checked' : '' ?>>
                  <span class="filter-check-mark">
                    <svg viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5L4.5 8.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </span>
                  <span class="filter-item-name"><?= $exp['name'] ?></span>
                </span>
                <span class="filter-count-badge" data-count-type="exp" data-count-val="<?= $exp['slug'] ?>">0</span>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- DURATION -->
      <div class="tours-filter-group">
        <h3 class="tours-filter-group-title"><?= __('filter_duration') ?></h3>
        <ul class="tours-filter-list">
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_duration" value="all" class="filter-custom-input" <?= $currentDur === 'all' || empty($currentDur) ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('filter_all') ?></span>
              </span>
              <span class="filter-count-badge" data-count-type="dur" data-count-val="all"><?= count($allTours) ?></span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_duration" value="day-trip" class="filter-custom-input" <?= $currentDur === 'day-trip' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('day_trip') ?></span>
              </span>
              <span class="filter-count-badge" data-count-type="dur" data-count-val="day-trip">7</span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_duration" value="2-3-days" class="filter-custom-input" <?= $currentDur === '2-3-days' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('two_three_days') ?></span>
              </span>
              <span class="filter-count-badge" data-count-type="dur" data-count-val="2-3-days">3</span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_duration" value="4-5-days" class="filter-custom-input" <?= $currentDur === '4-5-days' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('four_five_days') ?></span>
              </span>
              <span class="filter-count-badge" data-count-type="dur" data-count-val="4-5-days">1</span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="filter_duration" value="6-plus" class="filter-custom-input" <?= $currentDur === '6-plus' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('six_plus_days') ?></span>
              </span>
              <span class="filter-count-badge" data-count-type="dur" data-count-val="6-plus">1</span>
            </label>
          </li>
        </ul>
      </div>
    </aside>

    <!-- RIGHT CONTENT AREA -->
    <div class="tours-content-area">

      <!-- Mobile Filter & Sort Control Bar -->
      <div class="mobile-filter-bar">
        <button type="button" class="mobile-filter-trigger-btn" id="mobile-filter-btn" aria-label="Open filter options">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
          <span><?= __('filter_by') ?></span>
          <span class="active-badge" id="mobile-filter-badge" style="display: none;">0</span>
        </button>
        <button type="button" class="mobile-sort-trigger-btn" onclick="document.getElementById('tours-sort-select').focus(); document.getElementById('tours-sort-select').click();">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
          <span><?= __('sort_by') ?></span>
        </button>
      </div>

      <!-- Results Header -->
      <div class="tours-results-header">
        <div class="tours-count-display">
          <span class="tours-count-number" id="tours-count-num"><?= count($tours) ?></span> 
          <span id="tours-count-label"><?= count($tours) === 1 ? __('journey') : __('journeys') ?></span>
        </div>

        <div class="tours-sort-wrapper">
          <label for="tours-sort-select" class="tours-sort-label"><?= __('sort_by') ?>:</label>
          <select id="tours-sort-select" class="tours-sort-select" aria-label="Sort tours">
            <option value="recommended" <?= $currentSort === 'recommended' ? 'selected' : '' ?>><?= __('sort_recommended') ?></option>
            <option value="price-asc" <?= $currentSort === 'price-asc' ? 'selected' : '' ?>><?= __('sort_price_asc') ?></option>
            <option value="price-desc" <?= $currentSort === 'price-desc' ? 'selected' : '' ?>><?= __('sort_price_desc') ?></option>
            <option value="duration" <?= $currentSort === 'duration' ? 'selected' : '' ?>><?= __('sort_duration') ?></option>
            <option value="newest" <?= $currentSort === 'newest' ? 'selected' : '' ?>><?= __('sort_newest') ?></option>
          </select>
        </div>
      </div>

      <!-- Active Filter Chips Display -->
      <div class="tours-active-chips" id="tours-active-chips"></div>

      <!-- Compact 3-Column Tour Cards Grid -->
      <div class="tours-grid" id="tours-grid">
        <?php foreach ($allTours as $t): 
            $tourUrl = base_url($prefix . 'tours/' . $t['slug']);
            $durBadge = get_duration_badge($t, $lang);
            $destName = $t['destination_name'] ?: 'Pu Luong';
            $eyebrow = 'Tour · ' . e($destName);
            $formattedPriceUsd = format_price_usd($t['price_from_usd']);
            $formattedPriceVnd = format_price_vnd($t['price_from_vnd']);
            $isSig = !empty($t['is_signature']);
            $badgeText = $isSig ? ($lang === 'vi' ? 'Tour Đặc Sắc' : 'Signature Tour') : ((int)($t['duration_days'] ?? 1) > 1 ? ($lang === 'vi' ? 'Tour Trọn Gói' : 'Package Tour') : ($lang === 'vi' ? 'Tour Trong Ngày' : 'Day Tour'));
        ?>
          <article class="tours-card" data-tour-id="<?= $t['id'] ?>" data-destination="<?= e($t['destination_slug'] ?? '') ?>" data-price="<?= (float)$t['price_from_usd'] ?>" data-days="<?= (int)($t['duration_days'] ?? 1) ?>" data-signature="<?= $isSig ? 1 : 0 ?>">
            
            <!-- Media Aspect Ratio 16:10 -->
            <div class="tours-card-media">
              <a href="<?= $tourUrl ?>" aria-label="<?= e($t['title']) ?>">
                <img src="<?= asset($t['featured_image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($t['title']) ?>" class="tours-card-img" loading="lazy">
                <div class="tours-card-overlay"></div>
              </a>

              <!-- Type Badge on Top-Left -->
              <span class="tours-type-badge"><?= $badgeText ?></span>

              <!-- Duration Badge on Bottom-Right -->
              <span class="tours-duration-badge"><?= e($durBadge) ?></span>

              <!-- Wishlist / Favorite Icon on Top-Right -->
              <button type="button" class="tours-fav-btn" data-tour-id="<?= $t['id'] ?>" aria-label="Add to wishlist" title="Save to favorites">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
              </button>
            </div>

            <!-- Card Body Content -->
            <div class="tours-card-body">
              <div class="tours-card-eyebrow"><?= $eyebrow ?></div>

              <h2 class="tours-card-title">
                <a href="<?= $tourUrl ?>"><?= e($t['title']) ?></a>
              </h2>

              <!-- Footer with Price -->
              <div class="tours-card-footer">
                <div class="tours-card-price-box">
                  <span class="tours-price-label"><?= __('from_price') ?></span>
                  <span class="tours-price-amount"><?= $formattedPriceUsd ?></span>
                </div>
              </div>
            </div>

          </article>
        <?php endforeach; ?>
      </div>

      <!-- Empty State -->
      <div class="tours-empty-state" id="tours-empty-state" style="display: none;">
        <div class="tours-empty-icon">
          <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="tours-empty-title"><?= __('no_journeys_found') ?></h3>
        <p class="tours-empty-desc"><?= __('no_journeys_desc') ?></p>
        <button type="button" class="btn btn-brand js-clear-filters" style="padding: 10px 24px;"><?= __('filter_clear_all') ?></button>
      </div>

    </div>
  </div>
</section>

<!-- Mobile Bottom Sheet Drawer for Filters -->
<div class="filter-drawer-backdrop" id="mobile-filter-backdrop">
  <div class="filter-drawer-sheet" role="dialog" aria-modal="true" aria-label="Filter Options">
    <div class="filter-drawer-header">
      <h3 class="filter-drawer-title"><?= __('filter_by') ?></h3>
      <button type="button" class="filter-drawer-close" id="mobile-filter-close" aria-label="Close filters">✕</button>
    </div>

    <div class="filter-drawer-body">
      <!-- Destination -->
      <div class="tours-filter-group">
        <h4 class="tours-filter-group-title"><?= __('filter_destination') ?></h4>
        <ul class="tours-filter-list">
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_destination" value="all" class="filter-custom-input" <?= $currentDest === 'all' || empty($currentDest) ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('filter_all') ?></span>
              </span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_destination" value="pu-luong" class="filter-custom-input" <?= $currentDest === 'pu-luong' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name">Pu Luong</span>
              </span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_destination" value="mai-chau" class="filter-custom-input" <?= $currentDest === 'mai-chau' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name">Mai Chau</span>
              </span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_destination" value="ninh-binh" class="filter-custom-input" <?= $currentDest === 'ninh-binh' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name">Ninh Binh</span>
              </span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_destination" value="northern-vietnam" class="filter-custom-input" <?= $currentDest === 'northern-vietnam' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name">Northern Vietnam</span>
              </span>
            </label>
          </li>
        </ul>
      </div>

      <!-- Experience -->
      <div class="tours-filter-group">
        <h4 class="tours-filter-group-title"><?= __('filter_experience') ?></h4>
        <ul class="tours-filter-list">
          <?php foreach ($expList as $exp): 
              $isChecked = in_array($exp['slug'], (array)$currentExp);
          ?>
            <li>
              <label class="filter-control-label">
                <span class="filter-control-left">
                  <input type="checkbox" name="mobile_filter_experience[]" value="<?= $exp['slug'] ?>" class="filter-custom-input" <?= $isChecked ? 'checked' : '' ?>>
                  <span class="filter-check-mark">
                    <svg viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 5L4.5 8.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </span>
                  <span class="filter-item-name"><?= $exp['name'] ?></span>
                </span>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Duration -->
      <div class="tours-filter-group">
        <h4 class="tours-filter-group-title"><?= __('filter_duration') ?></h4>
        <ul class="tours-filter-list">
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_duration" value="all" class="filter-custom-input" <?= $currentDur === 'all' || empty($currentDur) ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('filter_all') ?></span>
              </span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_duration" value="day-trip" class="filter-custom-input" <?= $currentDur === 'day-trip' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('day_trip') ?></span>
              </span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_duration" value="2-3-days" class="filter-custom-input" <?= $currentDur === '2-3-days' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('two_three_days') ?></span>
              </span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_duration" value="4-5-days" class="filter-custom-input" <?= $currentDur === '4-5-days' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('four_five_days') ?></span>
              </span>
            </label>
          </li>
          <li>
            <label class="filter-control-label">
              <span class="filter-control-left">
                <input type="radio" name="mobile_filter_duration" value="6-plus" class="filter-custom-input" <?= $currentDur === '6-plus' ? 'checked' : '' ?>>
                <span class="filter-radio-mark"></span>
                <span class="filter-item-name"><?= __('six_plus_days') ?></span>
              </span>
            </label>
          </li>
        </ul>
      </div>
    </div>

    <div class="filter-drawer-footer">
      <button type="button" class="filter-drawer-reset-btn" id="mobile-filter-reset"><?= __('filter_reset') ?></button>
      <button type="button" class="filter-drawer-apply-btn" id="mobile-filter-apply"><?= __('filter_apply') ?></button>
    </div>
  </div>
</div>

<!-- Pass tours dataset to Javascript for instant filtering & dynamic updates -->
<script>
  window.VNU_ALL_TOURS = <?= json_encode($allTours, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;
</script>
<script defer src="<?= asset('assets/js/tours.js') ?>"></script>
