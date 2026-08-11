<?php
$currentLang = current_lang();
$prefix = $currentLang === 'vi' ? 'vi/' : '';
?>
<footer style="background-color: #022F13; color: #FFFFFF; padding: 80px 0 30px; border-top: 1px solid rgba(255,255,255,0.08);">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 60px;">
      
      <!-- Col 1: Brand Info -->
      <div>
        <div style="margin-bottom: 20px;">
          <img src="<?= asset('assets/images/Unique-Travel-Full-Color-Transparent.png') ?>" alt="Vietnam Unique Travel" style="height: 80px; width: auto; object-fit: contain;">
        </div>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.95rem; margin-bottom: 16px;">
          <strong>CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG</strong><br>
          Mã số thuế / MST: 0102126315
        </p>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">
          Specializing in authentic, high-value, nature and ethnic culture experiences across Vietnam.
        </p>
      </div>

      <!-- Col 2: Quick Links -->
      <div>
        <h4 style="color: var(--color-gold); font-size: 1.1rem; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;"><?= __('quick_links') ?></h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 10px; color: rgba(255,255,255,0.8); font-size: 0.95rem;">
          <li><a href="<?= base_url($prefix . 'tours') ?>"><?= __('nav_tours') ?></a></li>
          <li><a href="<?= base_url($prefix . 'destinations') ?>"><?= __('nav_destinations') ?></a></li>
          <li><a href="<?= base_url($prefix . 'experiences') ?>"><?= __('nav_experiences') ?></a></li>
          <li><a href="<?= base_url($prefix . ($currentLang === 'vi' ? 've-chung-toi' : 'about-us')) ?>"><?= __('nav_about') ?></a></li>
          <li><a href="<?= base_url($prefix . 'responsible-tourism') ?>"><?= __('nav_responsible') ?></a></li>
          <li><a href="<?= base_url($prefix . 'faq') ?>"><?= __('nav_faq') ?></a></li>
        </ul>
      </div>

      <!-- Col 3: Policies -->
      <div>
        <h4 style="color: var(--color-gold); font-size: 1.1rem; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;"><?= __('legal') ?></h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 10px; color: rgba(255,255,255,0.8); font-size: 0.95rem;">
          <li><a href="<?= base_url($prefix . 'policy/privacy') ?>">Privacy Policy</a></li>
          <li><a href="<?= base_url($prefix . 'policy/terms') ?>">Terms & Conditions</a></li>
          <li><a href="<?= base_url($prefix . 'policy/booking') ?>">Booking & Cancellation Policy</a></li>
        </ul>
      </div>

      <!-- Col 4: Contact Info -->
      <div>
        <h4 style="color: var(--color-gold); font-size: 1.1rem; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;"><?= __('contact_us') ?></h4>
        <p style="color: rgba(255,255,255,0.85); font-size: 0.95rem; margin-bottom: 10px; line-height: 1.6;">
          200 Ngõ 192 Lê Trọng Tấn, Phường Phương Liệt, Hà Nội
        </p>
        <p style="color: rgba(255,255,255,0.85); font-size: 0.95rem; margin-bottom: 8px;">
          Hotline / WhatsApp: <a href="tel:+84362191568" style="color: #FFF; font-weight: 700;">+84 362 191 568</a>
        </p>
        <p style="color: rgba(255,255,255,0.85); font-size: 0.95rem; margin-bottom: 16px;">
          Email: <a href="mailto:sales.vietnamuniquetravel@gmail.com" style="color: #FFF;">sales.vietnamuniquetravel@gmail.com</a>
        </p>
        <div>
          <a href="<?= base_url($prefix . ($currentLang === 'vi' ? 'lien-he' : 'contact')) ?>" style="color: var(--color-gold); font-size: 0.95rem; font-weight: 600; text-decoration: underline;"><?= __('nav_contact') ?> &rarr;</a>
        </div>
      </div>

    </div>

    <div style="text-align: center; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.5); font-size: 0.85rem;">
      <?= __('copyright') ?>
    </div>
  </div>
</footer>

<!-- Google Translate Element Initialization -->
<div id="google_translate_element" style="position: absolute; left: -9999px; top: -9999px; width: 1px; height: 1px; overflow: hidden; opacity: 0; pointer-events: none;"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: '<?= $currentLang ?>',
    includedLanguages: 'en,vi,fr,de,ja,es,zh-CN,ko,it,ru',
    autoDisplay: false
  }, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
