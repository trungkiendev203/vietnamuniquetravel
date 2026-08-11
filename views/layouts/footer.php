<?php
$currentLang = current_lang();
$prefix = $currentLang === 'vi' ? 'vi/' : '';
?>
<footer style="background-color: #161311; color: #FFFFFF; padding: 70px 0 0; border-top: 1px solid rgba(255,255,255,0.08); font-size: 0.9rem;">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 36px; padding-bottom: 50px;">
      
      <!-- Col 1: Brand Logo & Bio -->
      <div style="grid-column: span 1;">
        <div style="background: #FFFFFF; padding: 10px 16px; border-radius: 12px; display: inline-block; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
          <img src="<?= asset('assets/images/vnu-logo-transparent.png') ?>" alt="Vietnam Unique Travel" style="height: 52px; width: auto; display: block;">
        </div>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.88rem; line-height: 1.6; margin-bottom: 20px;">
          <?= $currentLang === 'vi' 
            ? 'Đối tác tin cậy cho các tour du lịch may đo trải dài khắp Việt Nam & Đông Dương. Vận hành bởi CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG, Hà Nội.' 
            : 'Your trusted partner for tailor-made tours across Vietnam & Indochina. Operated by Thanh Hung Tourism JSC, Hanoi.' 
          ?>
        </p>
        <!-- Social Icons -->
        <div style="display: flex; gap: 10px;">
          <a href="#" aria-label="Facebook" style="width: 36px; height: 36px; background: rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #FFF; transition: background 0.3s;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <a href="#" aria-label="Instagram" style="width: 36px; height: 36px; background: rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #FFF; transition: background 0.3s;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          <a href="#" aria-label="YouTube" style="width: 36px; height: 36px; background: rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #FFF; transition: background 0.3s;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="#161311"/></svg>
          </a>
          <a href="https://wa.me/84362191568" target="_blank" rel="noopener" aria-label="WhatsApp" style="width: 36px; height: 36px; background: rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #FFF; font-size: 1rem; transition: background 0.3s;">
            💬
          </a>
        </div>
      </div>

      <!-- Col 2: EXPLORE -->
      <div>
        <h4 style="color: var(--color-gold); font-size: 0.85rem; font-weight: 800; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1.5px;">EXPLORE</h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 12px; color: rgba(255,255,255,0.7); font-size: 0.88rem;">
          <li><a href="<?= base_url($prefix . 'destinations') ?>" style="transition: color 0.2s;"><?= __('nav_destinations') ?></a></li>
          <li><a href="<?= base_url($prefix . 'tours') ?>" style="transition: color 0.2s;"><?= __('nav_tours') ?></a></li>
          <li><a href="<?= base_url($prefix . 'experiences') ?>" style="transition: color 0.2s;"><?= __('nav_experiences') ?></a></li>
          <li><a href="<?= base_url($prefix . 'tours') ?>" style="transition: color 0.2s;"><?= $currentLang === 'vi' ? 'Lịch Trình Việt Nam' : 'Vietnam Itineraries' ?></a></li>
          <li><a href="<?= base_url($prefix . 'tours') ?>" style="transition: color 0.2s;"><?= $currentLang === 'vi' ? 'Phong Cách Du Lịch' : 'Travel Styles' ?></a></li>
        </ul>
      </div>

      <!-- Col 3: COMPANY -->
      <div>
        <h4 style="color: var(--color-gold); font-size: 0.85rem; font-weight: 800; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1.5px;">COMPANY</h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 12px; color: rgba(255,255,255,0.7); font-size: 0.88rem;">
          <li><a href="<?= base_url($prefix . ($currentLang === 'vi' ? 've-chung-toi' : 'about-us')) ?>" style="transition: color 0.2s;"><?= __('nav_about') ?></a></li>
          <li><a href="<?= base_url($prefix . 'responsible-tourism') ?>" style="transition: color 0.2s;"><?= $currentLang === 'vi' ? 'Cẩm Nang Du Lịch' : 'Travel Guide' ?></a></li>
          <li><a href="<?= base_url($prefix . 'faq') ?>" style="transition: color 0.2s;"><?= $currentLang === 'vi' ? 'Đánh Giá Từ Khách Hàng' : 'Reviews' ?></a></li>
          <li><a href="<?= base_url($prefix . ($currentLang === 'vi' ? 'lien-he' : 'contact')) ?>" style="transition: color 0.2s;"><?= __('nav_contact') ?></a></li>
        </ul>
      </div>

      <!-- Col 4: LEGAL -->
      <div>
        <h4 style="color: var(--color-gold); font-size: 0.85rem; font-weight: 800; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1.5px;">LEGAL</h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 12px; color: rgba(255,255,255,0.7); font-size: 0.88rem;">
          <li><a href="<?= base_url($prefix . 'legal-policy') ?>" style="transition: color 0.2s;"><?= $currentLang === 'vi' ? 'Chính Sách Bảo Mật' : 'Privacy Policy' ?></a></li>
          <li><a href="<?= base_url($prefix . 'legal-policy') ?>" style="transition: color 0.2s;"><?= $currentLang === 'vi' ? 'Điều Khoản Dịch Vụ' : 'Terms of Service' ?></a></li>
          <li><a href="<?= base_url($prefix . 'responsible-tourism') ?>" style="transition: color 0.2s;"><?= $currentLang === 'vi' ? 'Hợp Tác Đối Tác' : 'Partnerships' ?></a></li>
          <li><a href="<?= base_url($prefix . 'legal-policy') ?>" style="transition: color 0.2s;"><?= $currentLang === 'vi' ? 'Chính Sách Hủy Tour' : 'Cancellation & Refund Policy' ?></a></li>
        </ul>
      </div>

      <!-- Col 5: CONTACT -->
      <div>
        <h4 style="color: var(--color-gold); font-size: 0.85rem; font-weight: 800; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1.5px;">CONTACT</h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 14px; color: rgba(255,255,255,0.75); font-size: 0.88rem;">
          <li style="display: flex; gap: 10px; align-items: flex-start;">
            <span style="color: var(--color-gold); font-size: 0.95rem; margin-top: 1px;">📍</span>
            <span>200 Ngõ 192 Lê Trọng Tấn, Phường Phương Liệt, Hà Nội</span>
          </li>
          <li style="display: flex; gap: 10px; align-items: center;">
            <span style="color: var(--color-gold); font-size: 0.95rem;">✉️</span>
            <a href="mailto:sales.vietnamuniquetravel@gmail.com" style="color: rgba(255,255,255,0.85);">sales.vietnamuniquetravel@gmail.com</a>
          </li>
          <li style="display: flex; gap: 10px; align-items: center;">
            <span style="color: var(--color-gold); font-size: 0.95rem;">📞</span>
            <a href="tel:+84362191568" style="color: #FFF; font-weight: 700;">+84 (0) 362 191 568</a>
          </li>
          <li style="display: flex; gap: 10px; align-items: center;">
            <span style="color: var(--color-gold); font-size: 0.95rem;">🕒</span>
            <span>24/7 Support</span>
          </li>
        </ul>
      </div>

    </div>
  </div>

  <!-- Bottom Copyright Bar -->
  <div style="border-top: 1px solid rgba(255,255,255,0.08); padding: 22px 0; color: rgba(255,255,255,0.5); font-size: 0.82rem;">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
      <div>
        © 2026 Vietnam Unique Travel — Thanh Hung Tourism JSC. All rights reserved.
      </div>
      <div style="display: flex; gap: 16px;">
        <a href="<?= base_url($prefix . 'legal-policy') ?>" style="color: rgba(255,255,255,0.5); transition: color 0.2s;">Privacy Policy</a>
        <span>·</span>
        <a href="<?= base_url($prefix . 'legal-policy') ?>" style="color: rgba(255,255,255,0.5); transition: color 0.2s;">Terms of Service</a>
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
