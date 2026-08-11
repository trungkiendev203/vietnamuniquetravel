<?php
$isVi = $lang === 'vi';
$prefix = $isVi ? 'vi/' : '';

$successMsg = \App\Core\Session::flash('success');
$errorMsg = \App\Core\Session::flash('error');
$contactErrors = \App\Core\Session::flash('contact_errors') ?? [];
$old = \App\Core\Session::flash('contact_old') ?? [];
?>
<main class="contact-page">

  <!-- 1. Editorial Hero Section -->
  <section style="padding: 60px 0 80px; background-color: #F8F6EF;">
    <div class="contact-container">
      <div class="contact-hero-grid">
        
        <div>
          <span class="about-eyebrow"><?= $isVi ? 'LIÊN HỆ VỚI CHÚNG TÔI' : 'CONTACT US' ?></span>
          <h1 class="contact-hero-h1">
            <?= $isVi ? 'Cùng lên kế hoạch cho<br>hành trình Việt Nam của bạn.' : 'Let’s plan your<br>Vietnam journey.' ?>
          </h1>
          <p class="contact-hero-desc">
            <?= $isVi 
              ? 'Hãy chia sẻ cùng chúng tôi điểm đến yêu thích và phong cách trải nghiệm bạn đang tìm kiếm. Đội ngũ chuyên gia bản địa của Vietnam Unique Travel sẽ đồng hành thiết kế nên một hành trình trọn vẹn dành riêng cho bạn.' 
              : 'Tell us where you would like to go and what kind of experience you are looking for. Our local travel specialists will help you shape a journey that feels right for you.' ?>
          </p>
          <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <a href="#contact-form" class="btn btn-gold" style="min-height: 48px; display: inline-flex; align-items: center;"><?= $isVi ? 'Gửi yêu cầu tư vấn' : 'Send an Enquiry' ?></a>
            <a href="https://wa.me/84362191568" target="_blank" rel="noopener" class="btn btn-outline" style="border-color: var(--color-brand-green); color: var(--color-brand-green); min-height: 48px; display: inline-flex; align-items: center;">
              <?= $isVi ? 'Tư vấn WhatsApp' : 'Chat on WhatsApp' ?>
            </a>
          </div>
        </div>

        <div>
          <img src="<?= asset('assets/images/bamboo-rafting.webp') ?>" alt="<?= $isVi ? 'Du lịch trải nghiệm Việt Nam' : 'Vietnam Authentic Travel Experience' ?>" class="contact-hero-img" loading="lazy">
        </div>

      </div>
    </div>
  </section>

  <!-- 2. Main Contact Block & Contact Form -->
  <section style="padding: 90px 0; background-color: #FFFFFF;">
    <div class="contact-container">
      <div class="contact-main-grid">
        
        <!-- Left: Contact Information List -->
        <div>
          <span class="about-eyebrow"><?= $isVi ? 'THÔNG TIN LIÊN HỆ' : 'DIRECT CONTACT' ?></span>
          <h2 style="font-family: var(--font-heading); font-size: clamp(1.8rem, 3vw, 2.4rem); font-weight: 800; color: var(--color-brand-green); margin-bottom: 24px; line-height: 1.25;">
            <?= $isVi ? 'Đội ngũ tư vấn luôn sẵn sàng' : 'Reach our team anytime' ?>
          </h2>

          <div class="contact-info-list">
            
            <div class="contact-info-item">
              <div class="contact-icon-box">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5m-4 0h4"></path></svg>
              </div>
              <div>
                <div class="contact-info-label"><?= $isVi ? 'ĐỊA CHỈ VĂN PHÒNG' : 'OFFICE ADDRESS' ?></div>
                <div class="contact-info-val">200 Ngõ 192 Lê Trọng Tấn, Phường Phương Liệt, Hà Nội</div>
              </div>
            </div>

            <div class="contact-info-item">
              <div class="contact-icon-box">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              </div>
              <div>
                <div class="contact-info-label"><?= $isVi ? 'HOTLINE CHÍNH' : 'HOTLINE' ?></div>
                <div class="contact-info-val"><a href="tel:+84362191568">+84 362 191 568</a></div>
              </div>
            </div>

            <div class="contact-info-item">
              <div class="contact-icon-box">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
              </div>
              <div>
                <div class="contact-info-label"><?= $isVi ? 'ĐIỆN THOẠI VĂN PHÒNG' : 'OFFICE PHONE' ?></div>
                <div class="contact-info-val"><a href="tel:+84943642389">+84 943 642 389</a></div>
              </div>
            </div>

            <div class="contact-info-item">
              <div class="contact-icon-box">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0 1 12 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2m4 6h.01M5 20h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"></path></svg>
              </div>
              <div>
                <div class="contact-info-label"><?= $isVi ? 'BỘ PHẬN KINH DOANH' : 'SALES DEPARTMENT' ?></div>
                <div class="contact-info-val"><a href="tel:+84988956496">+84 988 956 496</a></div>
              </div>
            </div>

            <div class="contact-info-item">
              <div class="contact-icon-box">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              </div>
              <div>
                <div class="contact-info-label">EMAIL</div>
                <div class="contact-info-val"><a href="mailto:sales.vietnamuniquetravel@gmail.com">sales.vietnamuniquetravel@gmail.com</a></div>
              </div>
            </div>

            <div class="contact-info-item">
              <div class="contact-icon-box">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
              </div>
              <div>
                <div class="contact-info-label"><?= $isVi ? 'KÊNH TRỰC TRUYẾN' : 'SUPPORT CHANNELS' ?></div>
                <div class="contact-info-val">WhatsApp, LINE, Zalo, iMessage</div>
              </div>
            </div>

          </div>
        </div>

        <!-- Right: Contact Form -->
        <div id="contact-form" class="contact-form-box">
          
          <h3 style="font-family: var(--font-heading); font-size: 1.5rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 8px;">
            <?= $isVi ? 'Gửi yêu cầu chuyến đi' : 'Send us a message' ?>
          </h3>
          <p style="font-size: 0.95rem; color: #475569; margin-bottom: 24px;">
            <?= $isVi ? 'Điền thông tin bên dưới, chúng tôi sẽ phản hồi trong vài phút.' : 'Fill out the form below and our travel consultants will respond shortly.' ?>
          </p>

          <?php if ($successMsg): ?>
            <div style="background-color: #ECFDF5; border: 1px solid #10B981; color: #065F46; padding: 16px; border-radius: 8px; font-size: 0.98rem; margin-bottom: 24px; line-height: 1.6;">
              <?= e($successMsg) ?>
            </div>
          <?php endif; ?>

          <?php if ($errorMsg): ?>
            <div style="background-color: #FEF2F2; border: 1px solid #EF4444; color: #991B1B; padding: 16px; border-radius: 8px; font-size: 0.98rem; margin-bottom: 24px; line-height: 1.6;">
              <?= e($errorMsg) ?>
            </div>
          <?php endif; ?>

          <form action="<?= base_url($prefix . 'contact/submit') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="text" name="website_url" style="display:none;" tabindex="-1" autocomplete="off">

            <div class="form-group">
              <label for="fullname"><?= $isVi ? 'Họ và tên *' : 'Full Name *' ?></label>
              <input type="text" id="fullname" name="fullname" class="form-control <?= isset($contactErrors['fullname']) ? 'is-invalid' : '' ?>" value="<?= e($old['fullname'] ?? '') ?>" placeholder="<?= $isVi ? 'Nhập họ và tên của bạn' : 'e.g. John Smith' ?>" required>
              <?php if (isset($contactErrors['fullname'])): ?>
                <div class="form-error-msg"><?= e($contactErrors['fullname']) ?></div>
              <?php endif; ?>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div class="form-group">
                <label for="email"><?= $isVi ? 'Địa chỉ Email *' : 'Email Address *' ?></label>
                <input type="email" id="email" name="email" class="form-control <?= isset($contactErrors['email']) ? 'is-invalid' : '' ?>" value="<?= e($old['email'] ?? '') ?>" placeholder="name@example.com" required>
                <?php if (isset($contactErrors['email'])): ?>
                  <div class="form-error-msg"><?= e($contactErrors['email']) ?></div>
                <?php endif; ?>
              </div>

              <div class="form-group">
                <label for="phone_whatsapp"><?= $isVi ? 'Số điện thoại / WhatsApp *' : 'Phone / WhatsApp *' ?></label>
                <input type="text" id="phone_whatsapp" name="phone_whatsapp" class="form-control <?= isset($contactErrors['phone_whatsapp']) ? 'is-invalid' : '' ?>" value="<?= e($old['phone_whatsapp'] ?? '') ?>" placeholder="+84 362 191 568" required>
                <?php if (isset($contactErrors['phone_whatsapp'])): ?>
                  <div class="form-error-msg"><?= e($contactErrors['phone_whatsapp']) ?></div>
                <?php endif; ?>
              </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div class="form-group">
                <label for="nationality"><?= $isVi ? 'Quốc tịch' : 'Nationality' ?></label>
                <input type="text" id="nationality" name="nationality" class="form-control" value="<?= e($old['nationality'] ?? '') ?>" placeholder="<?= $isVi ? 'Ví dụ: Việt Nam, Australia...' : 'e.g. Australia, France...' ?>">
              </div>

              <div class="form-group">
                <label for="subject"><?= $isVi ? 'Chủ đề quan tâm' : 'Subject' ?></label>
                <input type="text" id="subject" name="subject" class="form-control" value="<?= e($old['subject'] ?? '') ?>" placeholder="<?= $isVi ? 'Ví dụ: Private Tour Pu Luong...' : 'e.g. Pu Luong Trekking Tour...' ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="message"><?= $isVi ? 'Nội dung tin nhắn / Yêu cầu chuyến đi *' : 'Message / Trip Details *' ?></label>
              <textarea id="message" name="message" rows="4" class="form-control <?= isset($contactErrors['message']) ? 'is-invalid' : '' ?>" placeholder="<?= $isVi ? 'Hãy chia sẻ thời gian dự kiến, số người tham gia và yêu cầu riêng của bạn...' : 'Tell us about travel dates, group size, preferred destinations...' ?>" required><?= e($old['message'] ?? '') ?></textarea>
              <?php if (isset($contactErrors['message'])): ?>
                <div class="form-error-msg"><?= e($contactErrors['message']) ?></div>
              <?php endif; ?>
            </div>

            <div class="form-group" style="display: flex; align-items: flex-start; gap: 10px;">
              <input type="checkbox" id="agree_policy" name="agree_policy" value="1" style="margin-top: 4px; accent-color: var(--color-brand-green);" required>
              <label for="agree_policy" style="font-size: 0.88rem; font-weight: 500; color: #475569; margin: 0; line-height: 1.5;">
                <?= $isVi ? 'Tôi đồng ý với <a href="' . base_url($prefix . 'policy/privacy') . '" target="_blank" style="color: var(--color-brand-green); text-decoration: underline;">Chính sách bảo mật</a> của Vietnam Unique Travel. *' : 'I agree to the <a href="' . base_url($prefix . 'policy/privacy') . '" target="_blank" style="color: var(--color-brand-green); text-decoration: underline;">Privacy Policy</a> of Vietnam Unique Travel. *' ?>
              </label>
            </div>
            <?php if (isset($contactErrors['agree_policy'])): ?>
              <div class="form-error-msg" style="margin-top: -12px; margin-bottom: 16px;"><?= e($contactErrors['agree_policy']) ?></div>
            <?php endif; ?>

            <button type="submit" class="btn btn-gold" style="width: 100%; min-height: 48px; font-size: 1rem; font-weight: 700; margin-top: 8px;">
              <?= $isVi ? 'Gửi yêu cầu tin nhắn' : 'Send Message' ?>
            </button>
          </form>

        </div>

      </div>
    </div>
  </section>

  <!-- 3. Horizontal WhatsApp CTA Band -->
  <section style="padding: 40px 0; background-color: #F8F6EF;">
    <div class="contact-container">
      <div class="whatsapp-cta-band">
        
        <div>
          <span style="font-family: var(--font-heading); font-size: 0.8rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: var(--color-gold); display: block; margin-bottom: 8px;">
            <?= $isVi ? 'BẠN CẦN PHẢN HỒI NHANH?' : 'NEED A QUICK ANSWER?' ?>
          </span>
          <h2 style="font-family: var(--font-heading); font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; color: #FFFFFF; margin-bottom: 12px;">
            <?= $isVi ? 'Trực tiếp trao đổi cùng đội ngũ tư vấn' : 'Talk directly with our travel team.' ?>
          </h2>
          <p style="font-size: 1.05rem; color: rgba(255,255,255,0.85); line-height: 1.7; max-width: 650px; margin-bottom: 24px;">
            <?= $isVi 
              ? 'Nhắn tin trực tiếp qua WhatsApp để nhận tư vấn lịch trình chi tiết, lịch khởi hành và xác nhận dịch vụ nhanh chóng.' 
              : 'Chat directly with our operation consultants on WhatsApp for customized travel advice, pricing details, and quick tour confirmation.' ?>
          </p>
          <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
            <a href="https://wa.me/84362191568" target="_blank" rel="noopener" class="btn btn-gold" style="min-height: 48px; display: inline-flex; align-items: center; gap: 8px;">
              <?= $isVi ? 'Chat trên WhatsApp (+84 362 191 568)' : 'Chat on WhatsApp (+84 362 191 568)' ?>
            </a>
          </div>
        </div>

        <div>
          <img src="<?= asset('assets/images/silk-weaving.webp') ?>" alt="<?= $isVi ? 'Đội ngũ tư vấn' : 'Travel Consultant' ?>" class="whatsapp-avatar" loading="lazy">
        </div>

      </div>
    </div>
  </section>

  <!-- 4. Hanoi Office Section (Static Map & Directions) -->
  <section class="office-location-sec">
    <div class="contact-container">
      <div class="office-grid">
        
        <div>
          <span class="about-eyebrow"><?= $isVi ? 'VĂN PHÒNG TẠI HÀ NỘI' : 'OUR OFFICE IN HANOI' ?></span>
          <h2 style="font-family: var(--font-heading); font-size: clamp(1.8rem, 3vw, 2.4rem); font-weight: 800; color: var(--color-brand-green); margin-bottom: 20px; line-height: 1.25;">
            <?= $isVi ? 'Chào đón bạn ghé thăm' : 'Welcome to our Hanoi office' ?>
          </h2>
          <p style="font-size: 1.05rem; line-height: 1.8; color: #334155; margin-bottom: 20px;">
            <strong>CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG</strong><br>
            <?= $isVi ? 'Mã số thuế:' : 'Tax Code / MST:' ?> 0102126315<br>
            <?= $isVi ? 'Địa chỉ: 200 Ngõ 192 Lê Trọng Tấn, Phường Phương Liệt, Hà Nội' : 'Address: 200 Ngo 192 Le Trong Tan, Phuong Liet, Hanoi, Vietnam' ?>
          </p>
          <p style="font-size: 0.98rem; line-height: 1.7; color: #475569; margin-bottom: 28px;">
            <?= $isVi ? 'Thời gian làm việc: Thứ Hai – Thứ Bảy: 8:00 – 18:00 (GMT+7)' : 'Working Hours: Monday – Saturday: 8:00 AM – 6:00 PM (GMT+7)' ?>
          </p>
          <a href="https://maps.google.com/?q=200+Ngo+192+Le+Trong+Tan+Phuong+Liet+Ha+Noi" target="_blank" rel="noopener" class="btn btn-outline" style="border-color: var(--color-brand-green); color: var(--color-brand-green); display: inline-flex; align-items: center; gap: 8px;">
            <?= $isVi ? 'Mở chỉ đường Google Maps' : 'Open in Google Maps' ?> &rarr;
          </a>
        </div>

        <div>
          <a href="https://maps.google.com/?q=200+Ngo+192+Le+Trong+Tan+Phuong+Liet+Ha+Noi" target="_blank" rel="noopener" class="map-card-link" aria-label="Google Maps Hanoi Office Location">
            <img src="<?= asset('assets/images/water-wheels.webp') ?>" alt="Hanoi Office Location Map" loading="lazy">
            <div class="map-card-overlay">
              <span class="map-btn-badge">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <?= $isVi ? 'Xem bản đồ Google Maps' : 'View on Google Maps' ?>
              </span>
            </div>
          </a>
        </div>

      </div>
    </div>
  </section>

</main>
