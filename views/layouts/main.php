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
  <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Great+Vibes&family=Pinyon+Script&family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= asset('assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/components.css') ?>">
  
  <script defer src="<?= asset('assets/js/main.js') ?>"></script>
</head>
<body>

  <?php require __DIR__ . '/header.php'; ?>

  <main id="main-content">
    <?= $content ?>
  </main>

  <?php require __DIR__ . '/footer.php'; ?>

  <!-- Floating Contact Buttons -->
  <div style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 12px;">
    <a href="https://wa.me/84362191568" target="_blank" rel="noopener" style="background: #25D366; color: #FFF; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.2);" aria-label="Chat on WhatsApp">
      💬
    </a>
  </div>

</body>
</html>
