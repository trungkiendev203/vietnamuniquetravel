<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: 120px 0 60px; text-align: center;">
  <div class="container">
    <h1 style="font-size: 3rem; color: #FFF; margin-bottom: 12px;"><?= __('nav_faq') ?></h1>
    <p style="color: rgba(255,255,255,0.8); max-width: 650px; margin: 0 auto;">
      Find quick answers to common questions regarding booking, tour preparations, and policies.
    </p>
  </div>
</section>

<section style="padding: 80px 0;">
  <div class="container" style="max-width: 850px;">
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <?php foreach ($faqs as $faq): ?>
        <details style="background: #FFF; padding: 24px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--color-border);" open>
          <summary style="font-size: 1.2rem; font-weight: 700; color: var(--color-brand-green); cursor: pointer; outline: none;">
            ❓ <?= e($faq['question']) ?>
          </summary>
          <div style="margin-top: 16px; color: var(--color-text-dark); line-height: 1.7; font-size: 0.98rem; padding-top: 12px; border-top: 1px solid var(--color-border);">
            <?= nl2br(e($faq['answer'])) ?>
          </div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
