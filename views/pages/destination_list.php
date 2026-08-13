<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: clamp(80px, 12vw, 120px) 0 50px; text-align: center;">
  <div class="container">
    <h1 style="font-size: clamp(2rem, 6vw, 3rem); color: #FFF; margin-bottom: 12px; font-family: var(--font-heading);"><?= __('nav_destinations') ?></h1>
    <p style="color: rgba(255,255,255,0.8); max-width: 650px; margin: 0 auto; font-size: clamp(0.95rem, 2.5vw, 1.05rem); line-height: 1.6;">
      Immerse yourself in Vietnam's most inspiring, nature-rich and culturally authentic regions.
    </p>
  </div>
</section>

<section style="padding: clamp(40px, 8vw, 80px) 0;">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap: 24px;">
      <?php foreach ($destinations as $d): ?>
        <div style="background: #FFF; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; border: 1px solid var(--color-border);">
          <img src="<?= asset($d['image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($d['name']) ?>" style="height: 220px; width: 100%; object-fit: cover;" loading="lazy">
          <div style="padding: 22px; display: flex; flex-direction: column; flex: 1;">
            <h2 style="font-size: 1.35rem; color: var(--color-brand-green); margin-bottom: 10px; font-family: var(--font-heading);"><?= e($d['name']) ?></h2>
            <p style="color: var(--color-text-muted); font-size: 0.92rem; margin-bottom: 20px; flex: 1; line-height: 1.6;"><?= e($d['short_description']) ?></p>
            <a href="<?= base_url($prefix . 'destinations/' . $d['slug']) ?>" class="btn btn-brand" style="align-self: start; padding: 10px 22px; font-size: 0.88rem; min-height: 42px;">
              Explore Destination &rarr;
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
