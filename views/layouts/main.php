<!DOCTYPE html>
<html lang="<?= e($lang ?? 'en') ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title><?= e($seo['title'] ?? 'Vietnam Unique Travel') ?></title>
  <meta name="description" content="<?= e($seo['description'] ?? 'Authentic & Responsible Travel Experiences in Vietnam.') ?>">
  <link rel="canonical" href="<?= e($seo['canonical'] ?? base_url()) ?>">

  <!-- Hreflang Tags -->
  <link rel="alternate" hreflang="en" href="<?= base_url('en') ?>">
  <link rel="alternate" hreflang="vi" href="<?= base_url('vi') ?>">

  <?php
    $rawOgImage = $seo['image'] ?? asset('assets/images/og-share-banner.jpg');
    if (!str_starts_with($rawOgImage, 'http://') && !str_starts_with($rawOgImage, 'https://')) {
        $rawOgImage = base_url(ltrim($rawOgImage, '/'));
    }
    $ogTitle = $seo['title'] ?? 'Vietnam Unique Travel — Authentic & Responsible Journeys';
    $ogDesc = $seo['description'] ?? 'Discover Vietnam through authentic, community-based, nature and cultural private tours.';
    $ogUrl = $seo['canonical'] ?? base_url();
    $currentLocale = ($lang ?? 'en') === 'vi' ? 'vi_VN' : 'en_US';
  ?>

  <!-- OpenGraph / Facebook / Zalo Metadata -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Vietnam Unique Travel">
  <meta property="og:locale" content="<?= $currentLocale ?>">
  <meta property="og:url" content="<?= e($ogUrl) ?>">
  <meta property="og:title" content="<?= e($ogTitle) ?>">
  <meta property="og:description" content="<?= e($ogDesc) ?>">
  <meta property="og:image" content="<?= e($rawOgImage) ?>">
  <meta property="og:image:secure_url" content="<?= e($rawOgImage) ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:type" content="image/jpeg">
  <meta property="og:image:alt" content="<?= e($ogTitle) ?>">

  <!-- Twitter Card Metadata -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($ogTitle) ?>">
  <meta name="twitter:description" content="<?= e($ogDesc) ?>">
  <meta name="twitter:image" content="<?= e($rawOgImage) ?>">

  <!-- Schema.org Microdata -->
  <meta itemprop="name" content="<?= e($ogTitle) ?>">
  <meta itemprop="description" content="<?= e($ogDesc) ?>">
  <meta itemprop="image" content="<?= e($rawOgImage) ?>">

  <!-- Optimized Google Fonts with full Vietnamese support -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,700&family=Inter:wght@400;500;600;700&subset=vietnamese,latin,latin-ext&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= asset('assets/css/main.css') ?>?v=<?= file_exists(__DIR__ . '/../../public/assets/css/main.css') ? filemtime(__DIR__ . '/../../public/assets/css/main.css') : '3.1' ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/components.css') ?>?v=<?= file_exists(__DIR__ . '/../../public/assets/css/components.css') ? filemtime(__DIR__ . '/../../public/assets/css/components.css') : '3.1' ?>">
  
  <script defer src="<?= asset('assets/js/main.js') ?>?v=<?= file_exists(__DIR__ . '/../../public/assets/js/main.js') ? filemtime(__DIR__ . '/../../public/assets/js/main.js') : '3.1' ?>"></script>
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

  <!-- Floating AI Robot Chatbot -->
  <?php require __DIR__ . '/chatbot.php'; ?>

  <!-- Back to Top Button -->
  <button id="backToTopBtn" class="back-to-top-btn" type="button" aria-label="<?= ($lang ?? 'en') === 'vi' ? 'Cuộn lên đầu trang' : 'Back to top' ?>" title="<?= ($lang ?? 'en') === 'vi' ? 'Cuộn lên đầu trang' : 'Back to top' ?>">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
  </button>

</body>
</html>
