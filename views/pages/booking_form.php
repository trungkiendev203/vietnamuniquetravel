<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: clamp(80px, 12vw, 120px) 0 50px; text-align: center;">
  <div class="container">
    <h1 style="font-size: clamp(2rem, 6vw, 3rem); color: #FFF; margin-bottom: 12px; font-family: var(--font-heading);"><?= __('btn_book_tour') ?></h1>
    <p style="color: rgba(255,255,255,0.85); max-width: 650px; margin: 0 auto; font-size: clamp(0.95rem, 2.5vw, 1.05rem); line-height: 1.6;">
      Submit your booking request. Our consultants will verify availability and confirm within minutes.
    </p>
  </div>
</section>

<section style="padding: clamp(30px, 6vw, 80px) 0;">
  <div class="container" style="max-width: 800px;">
    
    <?php if (\App\Core\Session::has('_flash')): ?>
      <?php if ($msg = \App\Core\Session::flash('error')): ?>
        <div style="background: #F8D7DA; color: #721C24; padding: 16px 20px; border-radius: var(--radius-sm); margin-bottom: 24px; font-weight: 600;">
          ⚠️ <?= e($msg) ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <form action="<?= base_url($prefix . 'booking/submit') ?>" method="POST" class="js-booking-form booking-main-form" style="background: #FFF; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-border);">
      <?= csrf_field() ?>

      <!-- Honeypot anti-spam input -->
      <div style="display: none;">
        <input type="text" name="website_hp" value="">
      </div>

      <!-- TRIP INFORMATION SECTION -->
      <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem); color: var(--color-brand-green); margin-bottom: 24px; border-bottom: 2px solid var(--color-ivory); padding-bottom: 10px; font-family: var(--font-heading);">
        1. <?= __('trip_info') ?>
      </h2>

      <div style="margin-bottom: 20px;">
        <label style="display: block; font-weight: 700; margin-bottom: 6px;">Tour of Interest *</label>
        <select name="tour_name" required style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
          <?php foreach ($tours as $t): ?>
            <option value="<?= e($t['title']) ?>" <?= $selectedTour && $selectedTour['id'] == $t['id'] ? 'selected' : '' ?>>
              [<?= e($t['code']) ?>] <?= e($t['title']) ?> (From <?= format_price_usd($t['price_from_usd']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 180px), 1fr)); gap: 16px; margin-bottom: 20px;">
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('select_date') ?> *</label>
          <input type="date" name="travel_date" required style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('adults') ?> *</label>
          <input type="number" name="adults" min="1" value="<?= e($_GET['adults'] ?? 1) ?>" required style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('children') ?></label>
          <input type="number" name="children" min="0" value="<?= e($_GET['children'] ?? 0) ?>" style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('pickup_location') ?> *</label>
        <input type="text" name="pickup_location" placeholder="e.g., Pù Luông Mist Valley Home / Hanoi Hotel address" required style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 16px; margin-bottom: 24px;">
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('dietary_req') ?></label>
          <input type="text" name="dietary_requirements" placeholder="e.g. Vegetarian, Halal, Vegan, No Seafood" style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('health_notes') ?></label>
          <input type="text" name="health_notes" placeholder="e.g. Asthma, allergies, physical limits" style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
      </div>

      <div style="margin-bottom: 30px;">
        <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('special_req') ?></label>
        <textarea name="special_requests" rows="3" placeholder="Any additional customized preferences or questions..." style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-family: var(--font-body); font-size: 16px;"></textarea>
      </div>

      <!-- CUSTOMER DETAILS SECTION -->
      <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem); color: var(--color-brand-green); margin-bottom: 24px; border-bottom: 2px solid var(--color-ivory); padding-bottom: 10px; font-family: var(--font-heading);">
        2. <?= __('customer_info') ?>
      </h2>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 16px; margin-bottom: 20px;">
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('fullname') ?> *</label>
          <input type="text" name="fullname" required style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('nationality') ?></label>
          <input type="text" name="nationality" placeholder="e.g. France, Germany, Australia, USA" style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 16px; margin-bottom: 24px;">
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('email') ?> *</label>
          <input type="email" name="email" required style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
        <div>
          <label style="display: block; font-weight: 700; margin-bottom: 6px;"><?= __('phone_whatsapp') ?> *</label>
          <input type="text" name="phone_whatsapp" placeholder="+1 234 567 890" required style="width: 100%; padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); font-size: 16px;">
        </div>
      </div>

      <div style="margin-bottom: 30px;">
        <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 0.95rem; color: var(--color-text-dark);">
          <input type="checkbox" name="agree_policy" value="1" required style="margin-top: 4px; width: 18px; height: 18px;">
          <span><?= __('agree_policy') ?> *</span>
        </label>
      </div>

      <button type="submit" class="btn btn-gold" style="width: 100%; min-height: 50px; font-size: 1.05rem;">
        <?= __('submit_booking') ?> &rarr;
      </button>
    </form>

  </div>
</section>
