<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="padding: 140px 0 100px; text-align: center;">
  <div class="container" style="max-width: 680px;">
    
    <div style="background: #FFF; padding: 48px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
      <div style="font-size: 4rem; margin-bottom: 20px;">🎉</div>

      <?php if ($lang === 'vi'): ?>
        <h1 style="font-size: 2.4rem; color: var(--color-brand-green); margin-bottom: 16px;">Yêu Cầu Đã Được Gửi Thành Công!</h1>
        <p style="color: var(--color-text-dark); font-size: 1.1rem; line-height: 1.7; margin-bottom: 24px;">
          Mã xác nhận đơn hàng của quý khách: <strong style="color: var(--color-gold); background: var(--color-forest-dark); padding: 4px 12px; border-radius: 6px;"><?= e($code) ?></strong>
        </p>
        <p style="color: var(--color-text-muted); font-size: 0.98rem; line-height: 1.6; margin-bottom: 30px;">
          Cảm ơn Quý khách đã lựa chọn Vietnam Unique Travel. Đội ngũ tư vấn sẽ kiểm tra chỗ và liên hệ lại với Quý khách trong thời gian sớm nhất qua Email hoặc WhatsApp.
        </p>
      <?php else: ?>
        <h1 style="font-size: 2.4rem; color: var(--color-brand-green); margin-bottom: 16px;">Booking Request Received!</h1>
        <p style="color: var(--color-text-dark); font-size: 1.1rem; line-height: 1.7; margin-bottom: 24px;">
          Your Booking Reference: <strong style="color: var(--color-gold); background: var(--color-forest-dark); padding: 4px 12px; border-radius: 6px;"><?= e($code) ?></strong>
        </p>
        <p style="color: var(--color-text-muted); font-size: 0.98rem; line-height: 1.6; margin-bottom: 30px;">
          Thank you for choosing Vietnam Unique Travel. Our operation team will verify service availability and contact you shortly via Email or WhatsApp.
        </p>
      <?php endif; ?>

      <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="<?= base_url($prefix) ?>" class="btn btn-brand">Return to Homepage</a>
        <a href="https://wa.me/84362191568?text=<?= urlencode('Hello VNU, I just submitted booking reference: ' . $code) ?>" target="_blank" class="btn btn-gold" style="background: #25D366; color: #FFF;">
          💬 Chat on WhatsApp
        </a>
      </div>

    </div>

  </div>
</section>
