<!DOCTYPE html>
<html lang="<?= e($lang ?? 'en') ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($seo['title'] ?? 'Vietnam Unique Travel') ?></title>
  <meta name="description" content="<?= e($seo['description'] ?? 'Authentic & Responsible Travel Experiences in Vietnam.') ?>">
  <link rel="canonical" href="<?= e($seo['canonical'] ?? base_url()) ?>">

  <!-- Hreflang Tags -->
  <link rel="alternate" hreflang="en" href="<?= base_url('en') ?>">
  <link rel="alternate" hreflang="vi" href="<?= base_url('vi') ?>">

  <!-- OpenGraph Metadata -->
  <meta property="og:title" content="<?= e($seo['title'] ?? 'Vietnam Unique Travel') ?>">
  <meta property="og:description" content="<?= e($seo['description'] ?? 'Authentic & Responsible Travel Experiences in Vietnam.') ?>">
  <meta property="og:image" content="<?= e($seo['image'] ?? asset('assets/images/hero.webp')) ?>">
  <meta property="og:url" content="<?= e($seo['canonical'] ?? base_url()) ?>">
  <meta property="og:type" content="website">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700;1,800;1,900&family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= asset('assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/components.css') ?>">
  
  <script defer src="<?= asset('assets/js/main.js') ?>"></script>
</head>
<body>

  <!-- Premium Page Loading Screen -->
  <div id="page-preloader" aria-hidden="true">
    <div class="preloader-content">
      <img src="<?= asset('assets/images/vnu-logo-white.png') ?>" alt="Vietnam Unique Travel" class="preloader-logo">
      <div class="preloader-spinner"></div>
    </div>
  </div>

  <?php require __DIR__ . '/header.php'; ?>

  <main id="main-content">
    <?= $content ?>
  </main>

  <?php require __DIR__ . '/footer.php'; ?>

  <!-- Floating Speed-Dial Contact Buttons (Reference Style) -->
  <div style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 10px; align-items: center;">
    <!-- Phone -->
    <a href="tel:+84362191568" style="background: #644732; color: #FFF; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(0,0,0,0.25); transition: transform 0.25s;" aria-label="Call Hotline" title="Call Us: +84 362 191 568">
      <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z"/></svg>
    </a>
    <!-- WhatsApp -->
    <a href="https://wa.me/84362191568" target="_blank" rel="noopener" style="background: #25D366; color: #FFF; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 4px 14px rgba(0,0,0,0.25); transition: transform 0.25s;" aria-label="Chat on WhatsApp" title="WhatsApp Us">
      💬
    </a>
    <!-- Zalo -->
    <a href="https://zalo.me/84362191568" target="_blank" rel="noopener" style="background: #0068FF; color: #FFF; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.78rem; letter-spacing: -0.5px; box-shadow: 0 4px 14px rgba(0,0,0,0.25); transition: transform 0.25s;" aria-label="Chat on Zalo" title="Zalo Support">
      Zalo
    </a>
    <!-- Email -->
    <a href="mailto:sales.vietnamuniquetravel@gmail.com" style="background: #C89539; color: #FFF; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(0,0,0,0.25); transition: transform 0.25s;" aria-label="Send Email" title="Email Us">
      <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
    </a>
  </div>

</body>
</html>
