<?php
$prefix = current_lang() === 'vi' ? 'vi/' : '';
?>
<section style="padding: 140px 0 100px; text-align: center;">
  <div class="container" style="max-width: 600px;">
    <div style="background: #FFF; padding: 48px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
      <div style="font-size: 5rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 10px; font-family: var(--font-heading);">404</div>
      <h1 style="font-size: 2rem; color: var(--color-forest-dark); margin-bottom: 16px;">Page Not Found</h1>
      <p style="color: var(--color-text-muted); font-size: 1.05rem; margin-bottom: 30px;">
        The page you are looking for does not exist or has been moved.
      </p>
      <a href="<?= base_url($prefix) ?>" class="btn btn-gold">
        Return to Homepage &rarr;
      </a>
    </div>
  </div>
</section>
