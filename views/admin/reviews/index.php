<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
  <h1>Tour Review Moderation</h1>
</div>

<!-- Filter Bar -->
<div class="admin-card" style="margin-bottom: 24px; padding: 16px 20px;">
  <form action="<?= base_url('admin/reviews') ?>" method="GET" style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 200px;">
      <input type="text" name="search" value="<?= e($search ?? '') ?>" placeholder="Search client name, email or review..." style="width: 100%; padding: 8px 12px; border: 1px solid #CCC; border-radius: 6px;">
    </div>
    
    <div>
      <select name="status" style="padding: 8px 12px; border: 1px solid #CCC; border-radius: 6px;">
        <option value="all" <?= ($status ?? 'all') === 'all' ? 'selected' : '' ?>>All Statuses</option>
        <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Pending Moderation</option>
        <option value="approved" <?= ($status ?? '') === 'approved' ? 'selected' : '' ?>>Approved</option>
        <option value="rejected" <?= ($status ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
      </select>
    </div>

    <div>
      <select name="tour_id" style="padding: 8px 12px; border: 1px solid #CCC; border-radius: 6px; max-width: 220px;">
        <option value="">All Tours</option>
        <?php foreach ($tours as $t): ?>
          <option value="<?= $t['id'] ?>" <?= ($tourId ?? '') == $t['id'] ? 'selected' : '' ?>><?= e($t['code']) ?> - <?= e($t['title']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" style="background: #3B82F6; color: #FFF; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 700; cursor: pointer;">
      Filter
    </button>
    <?php if (!empty($search) || ($status ?? 'all') !== 'all' || !empty($tourId)): ?>
      <a href="<?= base_url('admin/reviews') ?>" style="color: #666; text-decoration: underline; font-size: 0.9rem;">Reset</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Rating</th>
        <th>Client Details</th>
        <th>Tour</th>
        <th>Booking Ref</th>
        <th>Review Content</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($reviews)): ?>
        <tr><td colspan="7" style="text-align: center; color: #888; padding: 24px;">No reviews found.</td></tr>
      <?php else: ?>
        <?php foreach ($reviews as $r): ?>
          <tr>
            <td>
              <span style="color: #F59E0B; font-weight: 800; font-size: 1.1rem;">
                <?= str_repeat('★', (int)$r['rating']) ?><?= str_repeat('☆', 5 - (int)$r['rating']) ?>
              </span>
              <br><small style="color: #666;"><?= (int)$r['rating'] ?>/5</small>
            </td>
            <td>
              <strong><?= e($r['client_name']) ?></strong>
              <br><small style="color: #64748B;"><?= e($r['email']) ?></small>
            </td>
            <td><?= e($r['tour_name'] ?: 'Tour #' . $r['tour_id']) ?></td>
            <td>
              <?php if (!empty($r['booking_code'])): ?>
                <a href="<?= base_url('admin/bookings/' . $r['booking_code']) ?>" style="color: #2563EB; font-weight: 700; text-decoration: none;">
                  <?= e($r['booking_code']) ?>
                </a>
              <?php else: ?>
                <span style="color: #94A3B8;">N/A</span>
              <?php endif; ?>
            </td>
            <td style="max-width: 300px; line-height: 1.4;">
              <?= e(mb_strimwidth($r['content'], 0, 120, '...')) ?>
            </td>
            <td>
              <?php
                $badgeStyle = 'background: #F3F4F6; color: #374151;';
                if ($r['status'] === 'approved') $badgeStyle = 'background: #D1FAE5; color: #065F46;';
                if ($r['status'] === 'pending') $badgeStyle = 'background: #FEF3C7; color: #92400E;';
                if ($r['status'] === 'rejected') $badgeStyle = 'background: #FEE2E2; color: #991B1B;';
              ?>
              <span style="padding: 4px 10px; border-radius: 9999px; font-weight: 800; font-size: 0.8rem; text-transform: uppercase; <?= $badgeStyle ?>">
                <?= e($r['status']) ?>
              </span>
            </td>
            <td>
              <div style="display: flex; gap: 6px; flex-wrap: wrap; align-items: center;">
                <?php if ($r['status'] !== 'approved'): ?>
                  <form action="<?= base_url('admin/reviews/' . $r['id'] . '/status') ?>" method="POST" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" style="background: #10B981; color: #FFF; border: none; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">Duyệt</button>
                  </form>
                <?php endif; ?>

                <?php if ($r['status'] !== 'rejected'): ?>
                  <form action="<?= base_url('admin/reviews/' . $r['id'] . '/status') ?>" method="POST" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" style="background: #F59E0B; color: #FFF; border: none; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">Từ chối</button>
                  </form>
                <?php endif; ?>

                <a href="<?= base_url('admin/reviews/' . $r['id']) ?>" style="color: #2563EB; font-weight: 700; font-size: 0.85rem; text-decoration: none; padding: 4px;">Chi tiết</a>

                <form action="<?= base_url('admin/reviews/' . $r['id'] . '/delete') ?>" method="POST" style="display:inline;" onsubmit="return confirm('Delete this review?');">
                  <?= csrf_field() ?>
                  <button type="submit" style="background: none; border: none; color: #EF4444; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Xóa</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
