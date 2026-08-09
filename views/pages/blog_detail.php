<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: 120px 0 60px;">
  <div class="container" style="max-width: 900px;">
    <h1 style="font-size: 2.8rem; color: #FFF; margin-bottom: 16px; line-height: 1.2;"><?= e($post['title']) ?></h1>
    <p style="color: var(--color-gold); font-size: 0.95rem; font-weight: 700;">
      Published on <?= date('F d, Y', strtotime($post['published_at'])) ?>
    </p>
  </div>
</section>

<section style="padding: 60px 0;">
  <div class="container" style="max-width: 900px;">
    <img src="<?= asset($post['featured_image'] ?: 'assets/images/hero.webp') ?>" alt="<?= e($post['title']) ?>" style="width: 100%; height: 420px; object-fit: cover; border-radius: var(--radius-lg); margin-bottom: 40px; box-shadow: var(--shadow-sm);">

    <div style="background: #FFF; padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); line-height: 1.8; font-size: 1.05rem; color: var(--color-text-dark);">
      <?= $post['content'] ?>
    </div>
  </div>
</section>
