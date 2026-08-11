<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: 120px 0 60px; text-align: center;">
  <div class="container">
    <h1 style="font-size: 3rem; color: #FFF; margin-bottom: 12px;"><?= __('nav_tours') ?></h1>
    <p style="color: rgba(255,255,255,0.8); max-width: 650px; margin: 0 auto;">
      Discover authentic tours across Pu Luong Nature Reserve, Mai Chau, and northern Vietnam.
    </p>
  </div>
</section>

<section style="padding: 60px 0;">
  <div class="container">
    
    <!-- Filter bar -->
    <form action="<?= base_url($prefix . 'tours') ?>" method="GET" style="background: #FFF; padding: 20px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 40px; align-items: center;">
      <select name="destination" style="padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); flex: 1; font-family: var(--font-heading); font-size: 0.95rem;">
        <option value="">All Destinations</option>
        <?php foreach ($destinations as $d): ?>
          <option value="<?= $d['id'] ?>" <?= isset($_GET['destination']) && $_GET['destination'] == $d['id'] ? 'selected' : '' ?>><?= e($d['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <select name="duration" style="padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); flex: 1; font-family: var(--font-heading); font-size: 0.95rem;">
        <option value="">All Durations</option>
        <option value="halfday" <?= isset($_GET['duration']) && $_GET['duration'] === 'halfday' ? 'selected' : '' ?>>Half-Day</option>
        <option value="fullday" <?= isset($_GET['duration']) && $_GET['duration'] === 'fullday' ? 'selected' : '' ?>>Full-Day</option>
      </select>

      <select name="difficulty" style="padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--color-border); flex: 1; font-family: var(--font-heading); font-size: 0.95rem;">
        <option value="">All Difficulties</option>
        <option value="easy" <?= isset($_GET['difficulty']) && $_GET['difficulty'] === 'easy' ? 'selected' : '' ?>>Easy</option>
        <option value="medium" <?= isset($_GET['difficulty']) && $_GET['difficulty'] === 'medium' ? 'selected' : '' ?>>Medium</option>
        <option value="hard" <?= isset($_GET['difficulty']) && $_GET['difficulty'] === 'hard' ? 'selected' : '' ?>>Hard</option>
      </select>

      <button type="submit" class="btn btn-brand" style="padding: 10px 24px; font-family: var(--font-heading);">Filter</button>
    </form>

    <!-- Tour Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 32px;">
      <?php foreach ($tours as $t): ?>
        <div style="background: #FFF; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column;">
          <div style="position: relative;">
            <img src="<?= asset($t['featured_image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($t['title']) ?>" style="height: 220px; width: 100%; object-fit: cover;">
            <span style="position: absolute; top: 12px; right: 12px; background: var(--color-forest-dark); color: var(--color-gold); padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
              <?= e($t['code']) ?>
            </span>
          </div>

          <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
            <div style="color: var(--color-brand-green); font-size: 0.85rem; font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
              <?= e($t['destination_name'] ?: 'Pu Luong') ?>
            </div>
            <h3 style="font-size: 1.2rem; margin-bottom: 12px; color: var(--color-text-dark); line-height: 1.3;">
              <?= e($t['title']) ?>
            </h3>
            <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 20px; flex: 1;">
              <?= e($t['short_description']) ?>
            </p>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-border); padding-top: 16px;">
              <div>
                <span style="font-size: 0.8rem; color: var(--color-text-muted); display: block;">From</span>
                <strong style="font-size: 1.2rem; color: var(--color-brand-green);"><?= format_price_usd($t['price_from_usd']) ?></strong>
                <span style="font-size: 0.8rem; color: #888;">(<?= format_price_vnd($t['price_from_vnd']) ?>)</span>
              </div>
              <a href="<?= base_url($prefix . 'tours/' . $t['slug']) ?>" class="btn btn-brand" style="padding: 8px 18px; font-size: 0.85rem;">View Tour &rarr;</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
