<?php
$isVi = $lang === 'vi';
$prefix = $isVi ? 'vi/' : '';

$gallery = !empty($tour['images']) ? $tour['images'] : [
    ['image_path' => $tour['featured_image'] ?: 'assets/images/hero.webp', 'caption' => $tour['title']],
    ['image_path' => 'assets/images/hieu-waterfall.webp', 'caption' => 'Hieu Waterfall'],
    ['image_path' => 'assets/images/bamboo-rafting.webp', 'caption' => 'Bamboo Rafting']
];

$mainImg = $gallery[0] ?? null;
$subImg1 = $gallery[1] ?? $mainImg;
$subImg2 = $gallery[2] ?? $mainImg;
$totalPhotos = count($gallery);
?>
<main class="tour-detail-page" style="padding-top: 30px; padding-bottom: 90px;">
  <div class="tour-container">

    <!-- 1. Breadcrumb & Title Specs Header -->
    <div style="margin-bottom: 24px;">
      <div style="display: flex; align-items: center; gap: 12px; font-size: 0.88rem; color: #64748B; margin-bottom: 12px; flex-wrap: wrap;">
        <a href="<?= base_url($prefix) ?>" style="color: #64748B; text-decoration: none;"><?= __('nav_home') ?></a>
        <span>/</span>
        <a href="<?= base_url($prefix . 'tours') ?>" style="color: #64748B; text-decoration: none;"><?= __('nav_tours') ?></a>
        <span>/</span>
        <span><?= e($tour['destination_name'] ?: 'Pu Luong') ?></span>
        <span style="background: rgba(0, 88, 37, 0.08); color: var(--color-brand-green); font-family: var(--font-heading); font-weight: 800; font-size: 0.78rem; padding: 3px 8px; border-radius: 4px; margin-left: 6px;">
          <?= e($tour['code']) ?>
        </span>
      </div>

      <h1 style="font-family: var(--font-heading); font-size: clamp(2.2rem, 4vw, 3.2rem); font-weight: 800; color: var(--color-brand-green); line-height: 1.2; margin-bottom: 16px;">
        <?= e($tour['title']) ?>
      </h1>

      <div class="tour-header-specs">
        <div class="tour-spec-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          <span><?= e($tour['destination_name'] ?: 'Pu Luong') ?></span>
        </div>
        <div class="tour-spec-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          <span><?= e($tour['duration_type'] === 'halfday' ? 'Half-Day (4 Hours)' : 'Full-Day (8 Hours)') ?></span>
        </div>
        <div class="tour-spec-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
          <span><?= e($tour['transportation'] ?: 'Motorbike / Scooter') ?></span>
        </div>
        <div class="tour-spec-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
          <span><?= ucfirst(e($tour['difficulty'])) ?> Difficulty</span>
        </div>
        <div class="tour-spec-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          <span><?= e($tour['group_size'] ?: 'Small Group / Private') ?></span>
        </div>
      </div>
    </div>

    <!-- 2. Asymmetric Photo Gallery -->
    <div class="tour-gallery-grid">
      <div>
        <img src="<?= asset($mainImg['image_path']) ?>" alt="<?= e($mainImg['caption'] ?: $tour['title']) ?>" class="gallery-main-img" onclick="openLightbox(0)">
      </div>
      <div class="gallery-stack">
        <div>
          <img src="<?= asset($subImg1['image_path']) ?>" alt="<?= e($subImg1['caption'] ?: $tour['title']) ?>" class="gallery-sub-img" onclick="openLightbox(1)">
        </div>
        <div class="gallery-more-box" onclick="openLightbox(2)">
          <img src="<?= asset($subImg2['image_path']) ?>" alt="<?= e($subImg2['caption'] ?: $tour['title']) ?>" class="gallery-sub-img">
          <div class="gallery-more-overlay">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            <?= $isVi ? 'Xem toàn bộ ảnh (' . $totalPhotos . ')' : 'View all photos (' . $totalPhotos . ')' ?>
          </div>
        </div>
      </div>
    </div>

    <!-- 3. Main Content & Sticky Booking Panel Grid -->
    <div class="tour-main-grid">
      
      <!-- Left Column: Tour Details -->
      <div>

        <!-- Tour Highlights -->
        <?php if (!empty($tour['highlights'])): ?>
          <div style="background: #FFFFFF; border-radius: 12px; padding: 32px; border: 1px solid rgba(0,0,0,0.06); margin-bottom: 36px;">
            <h2 style="font-family: var(--font-heading); font-size: 1.5rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 16px;">
              <?= $isVi ? 'Điểm nổi bật của hành trình' : 'Tour Highlights' ?>
            </h2>
            <div id="highlights-content" style="font-size: 1rem; line-height: 1.8; color: #1E293B;">
              <?= nl2br(e($tour['highlights'])) ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Overview Section -->
        <?php if (!empty($tour['overview'])): ?>
          <div style="margin-bottom: 44px;">
            <h2 style="font-family: var(--font-heading); font-size: 1.6rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 20px;">
              <?= $isVi ? 'Tổng quan hành trình' : 'Tour Overview' ?>
            </h2>
            <div style="font-size: 1.05rem; line-height: 1.8; color: #334155; max-width: 720px;">
              <?= nl2br(e($tour['overview'])) ?>
            </div>
            
            <?php if (!empty($gallery[1])): ?>
              <div style="margin-top: 28px;">
                <img src="<?= asset($gallery[1]['image_path']) ?>" alt="<?= e($gallery[1]['caption'] ?? 'Trải nghiệm du lịch') ?>" style="width: 100%; height: 360px; object-fit: cover; border-radius: 12px;" loading="lazy">
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- Detailed Itinerary Accordion -->
        <?php if (!empty($tour['itinerary'])): ?>
          <div style="margin-bottom: 44px;">
            <div class="itinerary-accordion-box">
              <h2 style="font-family: var(--font-heading); font-size: 1.6rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 24px;">
                <?= $isVi ? 'Lịch trình chi tiết' : 'Detailed Itinerary' ?>
              </h2>
              
              <div>
                <?php foreach ($tour['itinerary'] as $idx => $step): ?>
                  <div class="itinerary-item <?= $idx === 0 ? 'active' : '' ?>" id="itinerary-step-<?= $idx ?>">
                    <div class="itinerary-header" onclick="toggleItinerary(<?= $idx ?>)" role="button" aria-expanded="<?= $idx === 0 ? 'true' : 'false' ?>">
                      <div class="itinerary-title-group">
                        <span class="itinerary-dot"></span>
                        <span class="itinerary-time"><?= e($step['step_time']) ?></span>
                        <h3 style="font-family: var(--font-heading); font-size: 1.15rem; font-weight: 700; color: #1E293B; margin: 0;">
                          <?= e($step['title']) ?>
                        </h3>
                      </div>
                      <svg class="itinerary-chevron" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                    <div class="itinerary-body">
                      <?= nl2br(e($step['description'])) ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <!-- Pricing Table -->
        <?php if (!empty($tour['prices'])): ?>
          <div style="margin-bottom: 44px;">
            <h2 style="font-family: var(--font-heading); font-size: 1.6rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 20px;">
              <?= $isVi ? 'Bảng giá tour chi tiết' : 'Tour Pricing' ?>
            </h2>
            <div style="overflow-x: auto;">
              <table class="pricing-table-wrap">
                <thead>
                  <tr>
                    <th><?= $isVi ? 'Phương tiện / Tùy chọn' : 'Vehicle Option' ?></th>
                    <th><?= $isVi ? 'Quy mô nhóm' : 'Group Size' ?></th>
                    <th><?= $isVi ? 'Giá / Khách (VND)' : 'Price / Pax (VND)' ?></th>
                    <th><?= $isVi ? 'Giá / Khách (USD)' : 'Price / Pax (USD)' ?></th>
                    <th><?= $isVi ? 'Ghi chú' : 'Notes' ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($tour['prices'] as $p): ?>
                    <tr>
                      <td style="font-weight: 700; text-transform: capitalize; color: var(--color-brand-green);"><?= e($p['transport_type']) ?></td>
                      <td style="font-weight: 600;"><?= e($p['pax_tier']) ?></td>
                      <td style="color: var(--color-brand-green); font-weight: 800;"><?= format_price_vnd($p['price_vnd']) ?></td>
                      <td style="color: var(--color-brand-green); font-weight: 800;"><?= format_price_usd($p['price_usd']) ?></td>
                      <td style="color: #64748B; font-size: 0.9rem;"><?= e($p['note']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <p style="font-size: 0.88rem; color: #64748B; margin-top: 10px;">
              * <?= $isVi ? 'Phụ phí Hướng dẫn viên tiếng Anh: 265.000 VNĐ ($10 USD) / tour khi có yêu cầu riêng.' : 'English speaking guide surcharge: 265,000 VNĐ ($10 USD) per tour if required.' ?>
            </p>
          </div>
        <?php endif; ?>

        <!-- Included & Not Included -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 44px;">
          
          <div class="inc-exc-block">
            <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 16px;">
              <?= $isVi ? 'Giá tour đã bao gồm' : 'Included in Your Tour' ?>
            </h3>
            <ul class="inc-list">
              <?php foreach (array_filter(explode("\n", $tour['inclusions'] ?? '')) as $incItem): ?>
                <li>
                  <svg width="20" height="20" fill="none" stroke="#005825" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span><?= e(trim($incItem)) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="inc-exc-block">
            <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 800; color: #1E293B; margin-bottom: 16px;">
              <?= $isVi ? 'Giá tour chưa bao gồm' : 'Not Included' ?>
            </h3>
            <ul class="exc-list">
              <?php foreach (array_filter(explode("\n", $tour['exclusions'] ?? '')) as $excItem): ?>
                <li>
                  <svg width="20" height="20" fill="none" stroke="#EA580C" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                  <span><?= e(trim($excItem)) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

        </div>

        <!-- What to bring & Policies Accordions -->
        <?php if (!empty($tour['what_to_bring']) || !empty($tour['child_policy']) || !empty($tour['cancellation_policy'])): ?>
          <div style="background: #FFFFFF; border-radius: 12px; padding: 32px; border: 1px solid rgba(0,0,0,0.06); margin-bottom: 44px;">
            <h3 style="font-family: var(--font-heading); font-size: 1.35rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 20px;">
              <?= $isVi ? 'Thông tin chuẩn bị & Chính sách tour' : 'What to Bring & Tour Policies' ?>
            </h3>

            <?php if (!empty($tour['what_to_bring'])): ?>
              <div style="margin-bottom: 24px;">
                <h4 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: #1E293B; margin-bottom: 8px;">
                  <?= $isVi ? 'Cần chuẩn bị gì' : 'What to Bring' ?>
                </h4>
                <p style="color: #475569; font-size: 0.98rem; line-height: 1.7;"><?= nl2br(e($tour['what_to_bring'])) ?></p>
              </div>
            <?php endif; ?>

            <?php if (!empty($tour['child_policy'])): ?>
              <div style="margin-bottom: 24px;">
                <h4 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: #1E293B; margin-bottom: 8px;">
                  <?= $isVi ? 'Chính sách trẻ em' : 'Child Policy' ?>
                </h4>
                <p style="color: #475569; font-size: 0.98rem; line-height: 1.7;"><?= nl2br(e($tour['child_policy'])) ?></p>
              </div>
            <?php endif; ?>

            <?php if (!empty($tour['cancellation_policy'])): ?>
              <div>
                <h4 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: #1E293B; margin-bottom: 8px;">
                  <?= $isVi ? 'Chính sách đổi ngày & Hủy tour' : 'Cancellation & Date Change Policy' ?>
                </h4>
                <p style="color: #475569; font-size: 0.98rem; line-height: 1.7;"><?= nl2br(e($tour['cancellation_policy'])) ?></p>
              </div>
            <?php endif; ?>

          </div>
        <?php endif; ?>

      </div>

      <!-- Right Column: Sticky Booking Panel -->
      <div>
        <div id="booking-panel" class="booking-panel-sticky">
          
          <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
            <span style="font-family: var(--font-heading); font-size: 0.82rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; color: #64748B;">
              <?= $isVi ? 'GIÁ TỪ' : 'PRICE FROM' ?>
            </span>
            <div style="text-align: right;">
              <span style="font-family: var(--font-heading); font-size: 1.6rem; font-weight: 800; color: var(--color-brand-green);">
                <?= format_price_vnd($tour['price_from_vnd']) ?>
              </span>
              <span style="font-size: 0.9rem; color: #64748B; display: block; font-weight: 600;">
                (<?= format_price_usd($tour['price_from_usd']) ?> / pax)
              </span>
            </div>
          </div>

          <form action="<?= base_url($prefix . 'booking') ?>" method="GET">
            <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
            <input type="hidden" name="tour" value="<?= e($tour['slug']) ?>">

            <!-- Preferred Date -->
            <div style="margin-bottom: 18px;">
              <label for="preferred_date" style="display: block; font-family: var(--font-heading); font-size: 0.9rem; font-weight: 700; color: #1E293B; margin-bottom: 6px;">
                <?= $isVi ? 'Ngày dự kiến tham gia *' : 'Preferred Date *' ?>
              </label>
              <input type="date" id="preferred_date" name="date" class="form-control" required style="height: 48px;">
            </div>

            <!-- Guest Selection -->
            <div style="margin-bottom: 20px;">
              <label style="display: block; font-family: var(--font-heading); font-size: 0.9rem; font-weight: 700; color: #1E293B; margin-bottom: 8px;">
                <?= $isVi ? 'Số lượng khách' : 'Number of Guests' ?>
              </label>
              
              <div style="display: flex; justify-content: space-between; align-items: center; background: #F8FAFC; padding: 12px 16px; border-radius: 8px; border: 1px solid #E2E8F0; margin-bottom: 10px;">
                <div>
                  <span style="font-weight: 700; font-size: 0.95rem; color: #1E293B; display: block;"><?= $isVi ? 'Người lớn' : 'Adults' ?></span>
                  <span style="font-size: 0.8rem; color: #64748B;"><?= $isVi ? 'Từ 12 tuổi' : 'Age 12+' ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                  <button type="button" class="guest-counter-btn" onclick="updateGuests('adults', -1)">-</button>
                  <span id="adults-count" style="font-family: var(--font-heading); font-weight: 800; font-size: 1.1rem;">1</span>
                  <input type="hidden" id="adults-input" name="adults" value="1">
                  <button type="button" class="guest-counter-btn" onclick="updateGuests('adults', 1)">+</button>
                </div>
              </div>

              <div style="display: flex; justify-content: space-between; align-items: center; background: #F8FAFC; padding: 12px 16px; border-radius: 8px; border: 1px solid #E2E8F0;">
                <div>
                  <span style="font-weight: 700; font-size: 0.95rem; color: #1E293B; display: block;"><?= $isVi ? 'Trẻ em' : 'Children' ?></span>
                  <span style="font-size: 0.8rem; color: #64748B;"><?= $isVi ? 'Dưới 12 tuổi' : 'Under 12 yrs' ?></span>
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                  <button type="button" class="guest-counter-btn" onclick="updateGuests('children', -1)">-</button>
                  <span id="children-count" style="font-family: var(--font-heading); font-weight: 800; font-size: 1.1rem;">0</span>
                  <input type="hidden" id="children-input" name="children" value="0">
                  <button type="button" class="guest-counter-btn" onclick="updateGuests('children', 1)">+</button>
                </div>
              </div>
            </div>

            <!-- Submit Button (Brand Green) -->
            <button type="submit" class="btn btn-brand" style="width: 100%; min-height: 48px; background: var(--color-brand-green); color: #FFFFFF; font-family: var(--font-heading); font-weight: 800; font-size: 1rem; margin-bottom: 12px; border-radius: 8px;">
              <?= $isVi ? 'Gửi yêu cầu tour này' : 'Request This Tour' ?> &rarr;
            </button>
          </form>

          <!-- WhatsApp Action Button -->
          <a href="https://wa.me/84362191568?text=<?= urlencode('Hello, I would like to inquire about tour: ' . $tour['title'] . ' (' . $tour['code'] . ')') ?>" target="_blank" rel="noopener" class="btn btn-outline" style="width: 100%; min-height: 44px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-color: #25D366; color: #15803D; font-weight: 700; font-size: 0.95rem; margin-bottom: 16px; border-radius: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            <?= $isVi ? 'Tư vấn nhanh qua WhatsApp' : 'Chat on WhatsApp' ?>
          </a>

          <p style="font-size: 0.82rem; color: #64748B; text-align: center; line-height: 1.5; margin: 0;">
            <?= $isVi ? 'Gửi yêu cầu tư vấn trước. Đội ngũ tư vấn sẽ kiểm tra tình trạng dịch vụ và xác nhận thông tin cụ thể.' : 'Send your request first. Our travel team will check availability and confirm the final details.' ?>
          </p>

        </div>
      </div>

    </div>

    <!-- 4. Related Tours Section -->
    <?php if (!empty($relatedTours)): ?>
      <div style="margin-top: 80px; padding-top: 60px; border-top: 1px solid rgba(0,0,0,0.08);">
        <h2 style="font-family: var(--font-heading); font-size: 1.8rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 28px;">
          <?= $isVi ? 'Những hành trình gợi ý khác' : 'Similar Journeys You Might Enjoy' ?>
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 28px;">
          <?php foreach ($relatedTours as $rel): ?>
            <?php if ($rel['id'] === $tour['id']) continue; ?>
            <div style="background: #FFFFFF; border-radius: 12px; overflow: hidden; border: 1px solid rgba(0,0,0,0.06); display: flex; flex-direction: column;">
              <img src="<?= asset($rel['featured_image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($rel['title']) ?>" style="width: 100%; height: 220px; object-fit: cover;" loading="lazy">
              <div style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1;">
                <div style="font-size: 0.8rem; font-weight: 800; color: var(--color-brand-green); text-transform: uppercase; margin-bottom: 6px;">
                  <?= e($rel['destination_name'] ?: 'Pu Luong') ?>
                </div>
                <h3 style="font-family: var(--font-heading); font-size: 1.15rem; font-weight: 700; color: #1E293B; margin-bottom: 12px; line-height: 1.4;">
                  <a href="<?= base_url($prefix . 'tours/' . $rel['slug']) ?>" style="color: #1E293B; text-decoration: none;"><?= e($rel['title']) ?></a>
                </h3>
                <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.06);">
                  <div>
                    <span style="font-size: 0.8rem; color: #64748B; display: block;"><?= $isVi ? 'Giá từ' : 'From' ?></span>
                    <strong style="color: var(--color-brand-green); font-size: 1.05rem;"><?= format_price_vnd($rel['price_from_vnd']) ?></strong>
                  </div>
                  <a href="<?= base_url($prefix . 'tours/' . $rel['slug']) ?>" class="btn btn-outline" style="border-color: var(--color-brand-green); color: var(--color-brand-green); padding: 8px 16px; font-size: 0.85rem;">
                    <?= $isVi ? 'Xem Tour' : 'View Tour' ?> &rarr;
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>

  <!-- Mobile Sticky Bottom CTA Bar -->
  <div class="mobile-bottom-cta-bar">
    <div>
      <span style="font-size: 0.78rem; color: #64748B; display: block; text-transform: uppercase; font-weight: 700;"><?= $isVi ? 'Giá từ' : 'Price From' ?></span>
      <strong style="color: var(--color-brand-green); font-size: 1.1rem; font-family: var(--font-heading);"><?= format_price_vnd($tour['price_from_vnd']) ?></strong>
    </div>
    <a href="#booking-panel" class="btn btn-brand" style="background: var(--color-brand-green); color: #FFFFFF; padding: 10px 20px; font-weight: 800; font-size: 0.9rem; border-radius: 6px;">
      <?= $isVi ? 'Yêu cầu đặt tour' : 'Request Tour' ?>
    </a>
  </div>

  <!-- Lightbox Modal Container -->
  <div id="lightbox" class="lightbox-modal" role="dialog" aria-modal="true" onclick="closeLightboxOnBg(event)">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <button class="lightbox-prev" onclick="changeLightboxImg(-1)">&lsaquo;</button>
    <img id="lightbox-img" src="" alt="Gallery Image" class="lightbox-content-img">
    <button class="lightbox-next" onclick="changeLightboxImg(1)">&rsaquo;</button>
  </div>

</main>

<script>
// Gallery Data for Lightbox
const galleryPhotos = <?= json_encode(array_map(function($img) {
    return asset($img['image_path']);
}, $gallery)) ?>;

let currentIdx = 0;

function openLightbox(index) {
  currentIdx = index;
  const modal = document.getElementById('lightbox');
  const img = document.getElementById('lightbox-img');
  img.src = galleryPhotos[currentIdx];
  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeLightbox() {
  const modal = document.getElementById('lightbox');
  modal.classList.remove('open');
  document.body.style.overflow = '';
}

function closeLightboxOnBg(e) {
  if (e.target.id === 'lightbox') {
    closeLightbox();
  }
}

function changeLightboxImg(dir) {
  currentIdx = (currentIdx + dir + galleryPhotos.length) % galleryPhotos.length;
  document.getElementById('lightbox-img').src = galleryPhotos[currentIdx];
}

// Keyboard navigation for Lightbox
document.addEventListener('keydown', function(e) {
  const modal = document.getElementById('lightbox');
  if (!modal.classList.contains('open')) return;
  if (e.key === 'Escape') closeLightbox();
  if (e.key === 'ArrowLeft') changeLightboxImg(-1);
  if (e.key === 'ArrowRight') changeLightboxImg(1);
});

// Itinerary Accordion Toggle
function toggleItinerary(idx) {
  const item = document.getElementById('itinerary-step-' + idx);
  if (item) {
    const isActive = item.classList.contains('active');
    item.classList.toggle('active');
    const header = item.querySelector('.itinerary-header');
    if (header) header.setAttribute('aria-expanded', !isActive);
  }
}

// Guest Counter Update
function updateGuests(type, change) {
  const input = document.getElementById(type + '-input');
  const countDisplay = document.getElementById(type + '-count');
  let val = parseInt(input.value) + change;
  if (type === 'adults' && val < 1) val = 1;
  if (type === 'children' && val < 0) val = 0;
  input.value = val;
  countDisplay.innerText = val;
}
</script>
