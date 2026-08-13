<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($seo['title'] ?? 'Admin Panel - Vietnam Unique Travel') ?></title>
  <link rel="stylesheet" href="<?= asset('assets/css/admin.css') ?>">
  <style>
    .badge {
      display: inline-block;
      padding: 2px 8px;
      font-size: 0.75rem;
      font-weight: 700;
      border-radius: 9999px;
      margin-left: 6px;
    }
    .badge-warning { background: #F59E0B; color: #FFFFFF; }
    .badge-danger { background: #EF4444; color: #FFFFFF; }
    .badge-info { background: #3B82F6; color: #FFFFFF; }
    .badge-success { background: #10B981; color: #FFFFFF; }
  </style>
</head>
<body class="admin-body">

  <?php
    $unreadCount = 0;
    $pendingReviewCount = 0;
    if (\App\Core\Session::has('admin_id')) {
        try {
            $notifM = new \App\Models\Notification();
            $unreadCount = $notifM->getUnreadCount();

            $revM = new \App\Models\Review();
            $pendingReviewCount = $revM->getPendingCount();
        } catch (\Throwable $e) {}
    }
    $currentUri = $_SERVER['REQUEST_URI'] ?? '';
  ?>

  <aside class="admin-sidebar">
    <h2>VNU ADMIN</h2>
    <ul class="admin-nav">
      <li>
        <a href="<?= base_url('admin/dashboard') ?>" class="<?= strpos($currentUri, 'dashboard') !== false ? 'active' : '' ?>">
          📊 Dashboard
        </a>
      </li>
      <li>
        <a href="<?= base_url('admin/notifications') ?>" class="<?= strpos($currentUri, 'notifications') !== false ? 'active' : '' ?>">
          🔔 Notifications
          <?php if ($unreadCount > 0): ?>
            <span class="badge badge-danger"><?= $unreadCount ?></span>
          <?php endif; ?>
        </a>
      </li>
      <li>
        <a href="<?= base_url('admin/bookings') ?>" class="<?= strpos($currentUri, 'bookings') !== false ? 'active' : '' ?>">
          📝 Bookings
        </a>
      </li>
      <li>
        <a href="<?= base_url('admin/tours') ?>" class="<?= strpos($currentUri, 'tours') !== false ? 'active' : '' ?>">
          🗺️ Tours
        </a>
      </li>
      <li>
        <a href="<?= base_url('admin/reviews') ?>" class="<?= strpos($currentUri, 'reviews') !== false ? 'active' : '' ?>">
          ⭐ Reviews
          <?php if ($pendingReviewCount > 0): ?>
            <span class="badge badge-warning"><?= $pendingReviewCount ?></span>
          <?php endif; ?>
        </a>
      </li>
      <li>
        <a href="<?= base_url('admin/settings') ?>" class="<?= strpos($currentUri, 'settings') !== false ? 'active' : '' ?>">
          ⚙️ Settings
        </a>
      </li>
      <li style="margin-top: 30px;">
        <a href="<?= base_url('admin/logout') ?>" style="color: #F87171;">
          🚪 Logout
        </a>
      </li>
    </ul>
  </aside>

  <main class="admin-main">
    <?php if (\App\Core\Session::has('_flash')): ?>
      <?php if ($msg = \App\Core\Session::flash('success')): ?>
        <div style="background: #D4EDDA; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
          <?= e($msg) ?>
        </div>
      <?php endif; ?>
      <?php if ($msg = \App\Core\Session::flash('error')): ?>
        <div style="background: #F8D7DA; color: #721C24; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
          <?= e($msg) ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?= $content ?>
  </main>

</body>
</html>
