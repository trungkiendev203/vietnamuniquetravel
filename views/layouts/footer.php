<?php
$currentLang = current_lang();
$prefix = $currentLang === 'vi' ? 'vi/' : '';
?>
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      
      <!-- Col 1: Brand Logo & Bio -->
      <div class="footer-brand-col">
        <div class="footer-logo-wrap">
          <a href="<?= base_url($prefix) ?>" aria-label="Vietnam Unique Travel" class="footer-logo-link">
            <img src="<?= asset('assets/images/vnu-logo-white.png') ?>" alt="Vietnam Unique Travel" class="footer-logo-img">
          </a>
        </div>
        <p class="footer-bio-text">
          <?= $currentLang === 'vi' 
            ? 'Thương hiệu lữ hành chuyên cung cấp các chương trình du lịch trải nghiệm độc đáo, văn hóa bản địa và du lịch có trách nhiệm tại Việt Nam. Vận hành bởi CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG, Hà Nội.' 
            : 'Your trusted partner for authentic experiential, nature and responsible journeys across Vietnam. Operated by Thanh Hung Tourism JSC, Hanoi.' 
          ?>
        </p>
        <!-- Social Icons (Min 44x44px Touch Targets) -->
        <div class="footer-social-row">
          <a href="#" aria-label="Facebook" class="footer-social-btn">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <a href="#" aria-label="Instagram" class="footer-social-btn">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          <a href="#" aria-label="YouTube" class="footer-social-btn">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="#022F13"/></svg>
          </a>
          <a href="https://wa.me/84362191568" target="_blank" rel="noopener" aria-label="WhatsApp" class="footer-social-btn" style="font-size: 1.1rem;">
            💬
          </a>
        </div>
      </div>

      <!-- Col 2: EXPLORE -->
      <div class="footer-nav-col">
        <h4 class="footer-col-title">EXPLORE</h4>
        <ul class="footer-nav-list">
          <li><a href="<?= base_url($prefix . 'destinations') ?>"><?= __('nav_destinations') ?></a></li>
          <li><a href="<?= base_url($prefix . 'tours') ?>"><?= __('nav_tours') ?></a></li>
          <li><a href="<?= base_url($prefix . 'experiences') ?>"><?= __('nav_experiences') ?></a></li>
          <li><a href="<?= base_url($prefix . 'tours') ?>"><?= $currentLang === 'vi' ? 'Lịch Trình Việt Nam' : 'Vietnam Itineraries' ?></a></li>
          <li><a href="<?= base_url($prefix . 'tours') ?>"><?= $currentLang === 'vi' ? 'Phong Cách Du Lịch' : 'Travel Styles' ?></a></li>
        </ul>
      </div>

      <!-- Col 3: COMPANY -->
      <div class="footer-nav-col">
        <h4 class="footer-col-title">COMPANY</h4>
        <ul class="footer-nav-list">
          <li><a href="<?= base_url($prefix . ($currentLang === 'vi' ? 've-chung-toi' : 'about-us')) ?>"><?= __('nav_about') ?></a></li>
          <li><a href="<?= base_url($prefix . ($currentLang === 'vi' ? 'meo-du-lich' : 'travel-tips')) ?>"><?= $currentLang === 'vi' ? 'Mẹo Du Lịch' : 'Travel Tips' ?></a></li>
          <li><a href="<?= base_url($prefix . 'responsible-tourism') ?>"><?= __('nav_responsible') ?></a></li>
          <li><a href="<?= base_url($prefix . 'faq') ?>"><?= $currentLang === 'vi' ? 'Hỏi Đáp' : 'FAQ' ?></a></li>
          <li><a href="<?= base_url($prefix . ($currentLang === 'vi' ? 'lien-he' : 'contact')) ?>"><?= __('nav_contact') ?></a></li>
        </ul>
      </div>

      <!-- Col 4: LEGAL -->
      <div class="footer-nav-col">
        <h4 class="footer-col-title">LEGAL</h4>
        <ul class="footer-nav-list">
          <li><a href="<?= base_url($prefix . 'legal-policy') ?>"><?= $currentLang === 'vi' ? 'Chính Sách Bảo Mật' : 'Privacy Policy' ?></a></li>
          <li><a href="<?= base_url($prefix . 'legal-policy') ?>"><?= $currentLang === 'vi' ? 'Điều Khoản Dịch Vụ' : 'Terms of Service' ?></a></li>
          <li><a href="<?= base_url($prefix . 'responsible-tourism') ?>"><?= $currentLang === 'vi' ? 'Hợp Tác Đối Tác' : 'Partnerships' ?></a></li>
          <li><a href="<?= base_url($prefix . 'legal-policy') ?>"><?= $currentLang === 'vi' ? 'Chính Sách Hủy Tour' : 'Cancellation & Refund Policy' ?></a></li>
        </ul>
      </div>

      <!-- Col 5: CONTACT -->
      <div class="footer-contact-col">
        <h4 class="footer-col-title">CONTACT</h4>
        <ul class="footer-contact-list">
          <li>
            <span class="contact-bullet-icon">📍</span>
            <span>200 Ngõ 192 Lê Trọng Tấn, Phường Phương Liệt, Hà Nội</span>
          </li>
          <li>
            <span class="contact-bullet-icon">✉️</span>
            <a href="mailto:sales.vietnamuniquetravel@gmail.com" class="footer-contact-link">sales.vietnamuniquetravel@gmail.com</a>
          </li>
          <li>
            <span class="contact-bullet-icon">📞</span>
            <a href="tel:+84362191568" class="footer-contact-phone">+84 (0) 362 191 568</a>
          </li>
          <li>
            <span class="contact-bullet-icon">🕒</span>
            <span>24/7 Support</span>
          </li>
        </ul>
      </div>

    </div>
  </div>

  <!-- Bottom Copyright Bar -->
  <div class="footer-bottom-bar">
    <div class="container footer-bottom-inner">
      <div class="footer-copy-text">
        © 2026 Vietnam Unique Travel — Thanh Hung Tourism JSC. All rights reserved.
      </div>
      <div class="footer-bottom-links">
        <a href="<?= base_url($prefix . 'legal-policy') ?>">Privacy Policy</a>
        <span>·</span>
        <a href="<?= base_url($prefix . 'legal-policy') ?>">Terms of Service</a>
      </div>
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
