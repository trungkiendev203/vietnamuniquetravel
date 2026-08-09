<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: 120px 0 60px;">
  <div class="container">
    <h1 style="font-size: 3rem; color: #FFF; margin-bottom: 12px;"><?= e($destination['name']) ?></h1>
    <p style="color: rgba(255,255,255,0.85); font-size: 1.1rem; max-width: 750px;"><?= e($destination['short_description']) ?></p>
  </div>
</section>

<section style="padding: 60px 0;">
  <div class="container">
    <div style="background: #FFF; padding: 32px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); margin-bottom: 60px;">
      <h2 style="font-size: 1.6rem; color: var(--color-forest-dark); margin-bottom: 16px;">About <?= e($destination['name']) ?></h2>
      <div style="color: var(--color-text-dark); line-height: 1.8; font-size: 1.05rem;">
        <?= nl2br(e($destination['description'])) ?>
      </div>
    </div>

    <h2 style="font-size: 2rem; color: var(--color-forest-dark); margin-bottom: 30px;">Tours in <?= e($destination['name']) ?></h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 32px;">
      <?php foreach ($tours as $t): ?>
        <div style="background: #FFF; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column;">
          <img src="<?= asset($t['featured_image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($t['title']) ?>" style="height: 200px; width: 100%; object-fit: cover;">
          <div style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
            <h3 style="font-size: 1.15rem; margin-bottom: 8px; color: var(--color-text-dark);"><?= e($t['title']) ?></h3>
            <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 16px; flex: 1;"><?= e($t['short_description']) ?></p>
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-border); padding-top: 12px;">
              <strong style="color: var(--color-brand-green); font-size: 1.1rem;"><?= format_price_usd($t['price_from_usd']) ?></strong>
              <a href="<?= base_url($prefix . 'tours/' . $t['slug']) ?>" class="btn btn-brand" style="padding: 6px 14px; font-size: 0.85rem;">View &rarr;</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
