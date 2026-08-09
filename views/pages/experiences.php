<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: 120px 0 60px; text-align: center;">
  <div class="container">
    <h1 style="font-size: 3rem; color: #FFF; margin-bottom: 12px;"><?= __('nav_experiences') ?></h1>
    <p style="color: rgba(255,255,255,0.8); max-width: 650px; margin: 0 auto;">
      From mountain treks to silk weaving looms, immerse yourself in hand-crafted experiences.
    </p>
  </div>
</section>

<section style="padding: 80px 0;">
  <div class="container">
    <div style="display: flex; flex-direction: column; gap: 40px;">
      <?php foreach ($categories as $cat): ?>
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 32px; background: #FFF; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); align-items: center;">
          <img src="<?= asset($cat['image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($cat['name']) ?>" style="width: 100%; height: 260px; object-fit: cover;">
          <div style="padding: 32px;">
            <h2 style="font-size: 1.8rem; color: var(--color-brand-green); margin-bottom: 12px;"><?= e($cat['name']) ?></h2>
            <p style="color: var(--color-text-dark); font-size: 1rem; line-height: 1.7; margin-bottom: 20px;"><?= e($cat['description']) ?></p>
            <a href="<?= base_url($prefix . 'tours') ?>" class="btn btn-gold">Find Matching Tours &rarr;</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
