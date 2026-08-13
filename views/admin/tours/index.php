<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
  <h1>Tour Management</h1>
  <a href="<?= base_url('admin/tours/create') ?>" class="btn-admin-action" style="background: var(--admin-primary); color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 6px; font-weight: 700; font-size: 0.95rem;">
    ➕ Add New Tour
  </a>
</div>

<!-- Search & Filter Bar -->
<div class="admin-card" style="margin-bottom: 24px; padding: 16px 20px;">
  <form action="<?= base_url('admin/tours') ?>" method="GET" style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 200px;">
      <input type="text" name="search" value="<?= e($search ?? '') ?>" placeholder="Search by tour code or title..." style="width: 100%; padding: 8px 12px; border: 1px solid #CCC; border-radius: 6px;">
    </div>
    <div>
      <select name="status" style="padding: 8px 12px; border: 1px solid #CCC; border-radius: 6px;">
        <option value="all" <?= ($status ?? 'all') === 'all' ? 'selected' : '' ?>>All Statuses</option>
        <option value="1" <?= ($status ?? '') === '1' ? 'selected' : '' ?>>Active (Visible)</option>
        <option value="0" <?= ($status ?? '') === '0' ? 'selected' : '' ?>>Hidden / Archived</option>
      </select>
    </div>
    <button type="submit" style="background: #3B82F6; color: #FFF; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 700; cursor: pointer;">
      Filter
    </button>
    <?php if (!empty($search) || ($status ?? 'all') !== 'all'): ?>
      <a href="<?= base_url('admin/tours') ?>" style="color: #666; text-decoration: underline; font-size: 0.9rem;">Reset</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Code</th>
        <th>Tour Title</th>
        <th>Duration</th>
        <th>Price (USD)</th>
        <th>Price (VND)</th>
        <th>Signature</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($tours)): ?>
        <tr><td colspan="8" style="text-align: center; color: #888; padding: 24px;">No tours found.</td></tr>
      <?php else: ?>
        <?php foreach ($tours as $t): ?>
          <tr>
            <td><strong><?= e($t['code']) ?></strong></td>
            <td>
              <span style="font-weight: 700; color: #1E293B;"><?= e($t['title']) ?></span>
              <br><small style="color: #64748B;">slug: <?= e($t['slug']) ?></small>
            </td>
            <td><?= e($t['duration_days']) ?> day(s) (<?= e($t['duration_type']) ?>)</td>
            <td><?= format_price_usd($t['price_from_usd']) ?></td>
            <td><?= format_price_vnd($t['price_from_vnd']) ?></td>
            <td>
              <form action="<?= base_url('admin/tours/' . $t['id'] . '/toggle-signature') ?>" method="POST" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 1.05rem;" title="Toggle Signature">
                  <?= $t['is_signature'] ? '⭐ Yes' : '☆ No' ?>
                </button>
              </form>
            </td>
            <td>
              <form action="<?= base_url('admin/tours/' . $t['id'] . '/toggle-status') ?>" method="POST" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" style="background: none; border: none; cursor: pointer; color: <?= $t['status'] ? '#059669' : '#DC2626' ?>; font-weight: 700;" title="Click to toggle status">
                  <?= $t['status'] ? '● Active' : '○ Hidden' ?>
                </button>
              </form>
            </td>
            <td>
              <div style="display: flex; gap: 8px; align-items: center;">
                <a href="<?= base_url('admin/tours/' . $t['id'] . '/edit') ?>" style="color: #2563EB; font-weight: 700; text-decoration: none;">✏️ Edit</a>
                <a href="<?= base_url('tours/' . $t['slug']) ?>" target="_blank" style="color: #059669; font-weight: 600; text-decoration: none;">🔗 Preview</a>
                <form action="<?= base_url('admin/tours/' . $t['id'] . '/delete') ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete/archive this tour?');">
                  <?= csrf_field() ?>
                  <button type="submit" style="background: none; border: none; color: #EF4444; font-weight: 700; cursor: pointer;">🗑️ Delete</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
