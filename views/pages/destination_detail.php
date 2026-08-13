<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: clamp(80px, 12vw, 120px) 0 50px;">
  <div class="container">
    <h1 style="font-size: clamp(2rem, 6vw, 3rem); color: #FFF; margin-bottom: 12px; font-family: var(--font-heading);"><?= e($destination['name']) ?></h1>
    <p style="color: rgba(255,255,255,0.85); font-size: clamp(0.95rem, 2.5vw, 1.1rem); max-width: 750px; line-height: 1.6;"><?= e($destination['short_description']) ?></p>
  </div>
</section>

<section style="padding: clamp(40px, 8vw, 60px) 0;">
  <div class="container">
    <div style="background: #FFF; padding: clamp(20px, 4vw, 32px); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); margin-bottom: 40px; border: 1px solid var(--color-border);">
      <h2 style="font-size: clamp(1.3rem, 3.5vw, 1.6rem); color: var(--color-forest-dark); margin-bottom: 16px; font-family: var(--font-heading);">About <?= e($destination['name']) ?></h2>
      <div style="color: var(--color-text-dark); line-height: 1.8; font-size: 1rem;">
        <?= nl2br(e($destination['description'])) ?>
      </div>
    </div>

    <h2 style="font-size: clamp(1.4rem, 4vw, 2rem); color: var(--color-forest-dark); margin-bottom: 24px; font-family: var(--font-heading);">Tours in <?= e($destination['name']) ?></h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr)); gap: 24px;">
      <?php foreach ($tours as $t): ?>
        <div style="background: #FFF; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; border: 1px solid var(--color-border);">
          <img src="<?= asset($t['featured_image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($t['title']) ?>" style="height: 200px; width: 100%; object-fit: cover;" loading="lazy">
          <div style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
            <h3 style="font-size: 1.15rem; margin-bottom: 8px; color: var(--color-text-dark); font-family: var(--font-heading);"><?= e($t['title']) ?></h3>
            <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 16px; flex: 1; line-height: 1.5;"><?= e($t['short_description']) ?></p>
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-border); padding-top: 12px;">
              <strong style="color: var(--color-brand-green); font-size: 1.1rem;"><?= format_price_usd($t['price_from_usd']) ?></strong>
              <a href="<?= base_url($prefix . 'tours/' . $t['slug']) ?>" class="btn btn-brand" style="padding: 8px 16px; font-size: 0.85rem; min-height: 38px;">View &rarr;</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
