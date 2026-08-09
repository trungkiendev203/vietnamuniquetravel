<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($seo['title'] ?? 'Admin Login') ?></title>
  <link rel="stylesheet" href="<?= asset('assets/css/main.css') ?>">
</head>
<body style="background-color: #022F13; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: var(--font-body);">
  <div style="background: #FFF; border-radius: var(--radius-lg); padding: 40px; width: 100%; max-width: 420px; box-shadow: var(--shadow-lg);">
    <?= $content ?>
  </div>
</body>
</html>
