<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
  <h1>Admin Notifications</h1>
  <?php if (!empty($notifications)): ?>
    <form action="<?= base_url('admin/notifications/mark-all-read') ?>" method="POST">
      <?= csrf_field() ?>
      <button type="submit" style="background: #3B82F6; color: #FFF; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 700; cursor: pointer;">
        ✓ Mark All as Read
      </button>
    </form>
  <?php endif; ?>
</div>

<div class="admin-card">
  <?php if (empty($notifications)): ?>
    <p style="text-align: center; color: #888; padding: 32px; margin: 0;">No notifications recorded yet.</p>
  <?php else: ?>
    <div style="display: flex; flex-direction: column; gap: 12px;">
      <?php foreach ($notifications as $n): ?>
        <div style="padding: 16px 20px; border-radius: 8px; border: 1px solid #E5E7EB; background: <?= $n['is_read'] ? '#FFFFFF' : '#EFF6FF' ?>; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
          <div style="flex: 1; min-width: 260px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
              <span style="font-size: 1.1rem;"><?= $n['type'] === 'booking' ? '📝' : '🔔' ?></span>
              <strong style="font-size: 1.05rem; color: #1E293B;"><?= e($n['title']) ?></strong>
              <?php if (!$n['is_read']): ?>
                <span class="badge badge-danger">Unread</span>
              <?php endif; ?>
            </div>
            <p style="margin: 0; color: #475569; font-size: 0.95rem; white-space: pre-line; line-height: 1.5;"><?= e($n['message']) ?></p>
            <span style="font-size: 0.8rem; color: #94A3B8; margin-top: 6px; display: block;"><?= e($n['created_at']) ?></span>
          </div>

          <div style="display: flex; gap: 8px; align-items: center;">
            <?php if (!empty($n['link'])): ?>
              <a href="<?= base_url('admin/notifications/' . $n['id'] . '/open') ?>" style="background: var(--admin-primary); color: #FFF; text-decoration: none; padding: 8px 14px; border-radius: 6px; font-weight: 700; font-size: 0.9rem;">
                Open Detail &rarr;
              </a>
            <?php endif; ?>

            <form action="<?= base_url('admin/notifications/' . $n['id'] . '/read') ?>" method="POST" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" style="background: none; border: 1px solid #CBD5E1; color: #475569; padding: 7px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <?= $n['is_read'] ? 'Mark Unread' : 'Mark Read' ?>
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
