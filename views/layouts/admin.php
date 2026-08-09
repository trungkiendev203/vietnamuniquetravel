<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($seo['title'] ?? 'Admin Panel - Vietnam Unique Travel') ?></title>
  <link rel="stylesheet" href="<?= asset('assets/css/admin.css') ?>">
</head>
<body class="admin-body">

  <aside class="admin-sidebar">
    <h2>VNU ADMIN</h2>
    <ul class="admin-nav">
      <li><a href="<?= base_url('admin/dashboard') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : '' ?>">📊 Dashboard</a></li>
      <li><a href="<?= base_url('admin/bookings') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'bookings') !== false ? 'active' : '' ?>">📝 Bookings</a></li>
      <li><a href="<?= base_url('admin/tours') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'tours') !== false ? 'active' : '' ?>">🗺️ Tours</a></li>
      <li><a href="<?= base_url('admin/settings') ?>" class="<?= strpos($_SERVER['REQUEST_URI'], 'settings') !== false ? 'active' : '' ?>">⚙️ Settings</a></li>
      <li style="margin-top: 30px;"><a href="<?= base_url('admin/logout') ?>" style="color: #F87171;">🚪 Logout</a></li>
    </ul>
  </aside>

  <main class="admin-main">
    <?php if (\App\Core\Session::has('_flash')): ?>
      <?php if ($msg = \App\Core\Session::flash('success')): ?>
        <div style="background: #D4EDDA; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
          <?= e($msg) ?>
        </div>
      <?php endif; ?>
      <?php if ($msg = \App\Core\Session::flash('error')): ?>
        <div style="background: #F8D7DA; color: #721C24; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
          <?= e($msg) ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?= $content ?>
  </main>

</body>
</html>
