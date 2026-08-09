<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: 120px 0 60px; text-align: center;">
  <div class="container">
    <h1 style="font-size: 3rem; color: #FFF; margin-bottom: 12px;"><?= __('nav_destinations') ?></h1>
    <p style="color: rgba(255,255,255,0.8); max-width: 650px; margin: 0 auto;">
      Immerse yourself in Vietnam's most inspiring, nature-rich and culturally authentic regions.
    </p>
  </div>
</section>

<section style="padding: 80px 0;">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px;">
      <?php foreach ($destinations as $d): ?>
        <div style="background: #FFF; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column;">
          <img src="<?= asset($d['image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($d['name']) ?>" style="height: 240px; width: 100%; object-fit: cover;">
          <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
            <h2 style="font-size: 1.4rem; color: var(--color-brand-green); margin-bottom: 10px;"><?= e($d['name']) ?></h2>
            <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 20px; flex: 1;"><?= e($d['short_description']) ?></p>
            <a href="<?= base_url($prefix . 'destinations/' . $d['slug']) ?>" class="btn btn-brand" style="align-self: start; padding: 8px 20px; font-size: 0.88rem;">
              Explore Destination &rarr;
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
