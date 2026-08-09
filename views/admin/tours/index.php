<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <h1>Tour Management</h1>
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
      <?php foreach ($tours as $t): ?>
        <tr>
          <td><strong><?= e($t['code']) ?></strong></td>
          <td><?= e($t['title']) ?></td>
          <td><?= e($t['duration_type']) ?></td>
          <td><?= format_price_usd($t['price_from_usd']) ?></td>
          <td><?= format_price_vnd($t['price_from_vnd']) ?></td>
          <td>
            <form action="<?= base_url('admin/tours/' . $t['id'] . '/toggle-signature') ?>" method="POST" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 1.1rem;">
                <?= $t['is_signature'] ? '⭐ Yes' : '☆ No' ?>
              </button>
            </form>
          </td>
          <td>
            <form action="<?= base_url('admin/tours/' . $t['id'] . '/toggle-status') ?>" method="POST" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" style="background: none; border: none; cursor: pointer; color: <?= $t['status'] ? '#059669' : '#DC2626' ?>; font-weight: 700;">
                <?= $t['status'] ? 'Active' : 'Disabled' ?>
              </button>
            </form>
          </td>
          <td>
            <a href="<?= base_url('tours/' . $t['slug']) ?>" target="_blank" style="color: var(--admin-primary); font-weight: 600;">Preview 🔗</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
