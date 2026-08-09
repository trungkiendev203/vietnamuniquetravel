<?php
$prefix = $lang === 'vi' ? 'vi/' : '';
?>
<section style="background-color: var(--color-forest-dark); color: #FFF; padding: 120px 0 60px; text-align: center;">
  <div class="container">
    <h1 style="font-size: 3rem; color: #FFF; margin-bottom: 12px;"><?= e($title) ?></h1>
    <p style="color: rgba(255,255,255,0.85); max-width: 650px; margin: 0 auto;">
      Official Policies of Vietnam Unique Travel (CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG).
    </p>
  </div>
</section>

<section style="padding: 80px 0;">
  <div class="container" style="max-width: 900px;">
    <div style="background: #FFF; padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); line-height: 1.8; color: var(--color-text-dark); font-size: 1.02rem;">
      
      <?php if ($type === 'privacy'): ?>
        <h2>Privacy Policy</h2>
        <p>Vietnam Unique Travel is committed to protecting your personal privacy. We collect only essential information required for tour reservation, customer care, and emergency contact.</p>
        <p>Your personal details will never be sold, rented, or shared with third parties without your prior explicit consent, unless required by local law or necessary service partners (such as hotel accommodation or local transport providers).</p>

      <?php elseif ($type === 'terms'): ?>
        <h2>Terms & Conditions</h2>
        <p>When booking services with Vietnam Unique Travel, clients agree to:</p>
        <ul>
          <li>Provide accurate personal and contact details during tour registration.</li>
          <li>Comply strictly with instructions provided by our professional local guides for safety.</li>
          <li>Respect local ethnic Thai and Muong culture, customs, and community etiquette.</li>
          <li>Refrain from actions that may jeopardize personal or group safety.</li>
        </ul>

      <?php else: ?>
        <h2>Booking, Cancellation & Date-Change Policy</h2>
        <h3>1. Booking Confirmation</h3>
        <p>Tour bookings are officially confirmed once payment is completed according to Vietnam Unique Travel instructions.</p>

        <h3>2. Date-Change Policy</h3>
        <p>Clients may request a date change at least <strong>24 hours prior</strong> to the scheduled departure time without surcharge, subject to service availability.</p>

        <h3>3. Cancellation Policy</h3>
        <p>Cancellations requested at least <strong>24 hours prior</strong> to departure are eligible for full refund or rescheduling support. For cancellations within less than 24 hours, fees depend on specific vendor terms.</p>

      <?php endif; ?>

    </div>
  </div>
</section>
