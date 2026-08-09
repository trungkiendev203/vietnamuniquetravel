<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <h1>Booking Requests</h1>
</div>

<!-- Filters -->
<form action="<?= base_url('admin/bookings') ?>" method="GET" class="admin-card" style="display: flex; gap: 16px; align-items: center;">
  <select name="status" style="padding: 8px 12px; border-radius: 6px; border: 1px solid #CCC;">
    <option value="">All Statuses</option>
    <option value="new" <?= $status === 'new' ? 'selected' : '' ?>>New</option>
    <option value="contacted" <?= $status === 'contacted' ? 'selected' : '' ?>>Contacted</option>
    <option value="confirmed" <?= $status === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
    <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Completed</option>
    <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
  </select>

  <input type="text" name="search" value="<?= e($search ?? '') ?>" placeholder="Search code, customer name or email..." style="flex: 1; padding: 8px 12px; border-radius: 6px; border: 1px solid #CCC;">

  <button type="submit" class="btn btn-brand" style="padding: 8px 16px; font-size: 0.85rem;">Filter</button>
</form>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Code</th>
        <th>Customer</th>
        <th>Phone / WhatsApp</th>
        <th>Tour</th>
        <th>Travel Date</th>
        <th>Status</th>
        <th>Email Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bookings as $b): ?>
        <tr>
          <td><strong><?= e($b['booking_code']) ?></strong></td>
          <td><?= e($b['fullname']) ?><br><small style="color: #666;"><?= e($b['email']) ?></small></td>
          <td><?= e($b['phone_whatsapp']) ?></td>
          <td><?= e($b['tour_name']) ?></td>
          <td><?= e($b['travel_date']) ?></td>
          <td><span class="status-badge status-<?= e($b['status']) ?>"><?= e($b['status']) ?></span></td>
          <td>
            <small style="color: <?= $b['email_sent_customer'] ? '#059669' : '#DC2626' ?>;">
              <?= $b['email_sent_customer'] ? 'Sent' : 'Failed/Log' ?>
            </small>
          </td>
          <td><a href="<?= base_url('admin/bookings/' . $b['booking_code']) ?>" style="color: var(--admin-primary); font-weight: 700;">Manage &rarr;</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
