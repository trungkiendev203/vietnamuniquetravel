<h1 style="margin-bottom: 24px;">Dashboard Overview</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px;">
  <div class="admin-card">
    <div style="font-size: 0.85rem; color: #666; font-weight: 700; text-transform: uppercase;">Total Bookings</div>
    <div style="font-size: 2.2rem; font-weight: 800; color: var(--admin-primary); margin-top: 8px;"><?= $stats['total_bookings'] ?></div>
  </div>

  <div class="admin-card">
    <div style="font-size: 0.85rem; color: #666; font-weight: 700; text-transform: uppercase;">New Requests</div>
    <div style="font-size: 2.2rem; font-weight: 800; color: #D97706; margin-top: 8px;"><?= $stats['new_bookings'] ?></div>
  </div>

  <div class="admin-card">
    <div style="font-size: 0.85rem; color: #666; font-weight: 700; text-transform: uppercase;">Confirmed Bookings</div>
    <div style="font-size: 2.2rem; font-weight: 800; color: #059669; margin-top: 8px;"><?= $stats['confirmed_bookings'] ?></div>
  </div>

  <div class="admin-card">
    <div style="font-size: 0.85rem; color: #666; font-weight: 700; text-transform: uppercase;">Active Tours</div>
    <div style="font-size: 2.2rem; font-weight: 800; color: #2563EB; margin-top: 8px;"><?= $stats['total_tours'] ?></div>
  </div>
</div>

<div class="admin-card">
  <h2 style="font-size: 1.3rem; margin-bottom: 16px;">Recent Booking Requests</h2>
  <table class="admin-table">
    <thead>
      <tr>
        <th>Code</th>
        <th>Customer</th>
        <th>Tour</th>
        <th>Travel Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($recentBookings)): ?>
        <tr><td colspan="6" style="text-align: center; color: #888;">No bookings recorded yet.</td></tr>
      <?php else: ?>
        <?php foreach ($recentBookings as $b): ?>
          <tr>
            <td><strong><?= e($b['booking_code']) ?></strong></td>
            <td><?= e($b['fullname']) ?><br><small style="color: #666;"><?= e($b['email']) ?></small></td>
            <td><?= e($b['tour_name']) ?></td>
            <td><?= e($b['travel_date']) ?></td>
            <td><span class="status-badge status-<?= e($b['status']) ?>"><?= e($b['status']) ?></span></td>
            <td><a href="<?= base_url('admin/bookings/' . $b['booking_code']) ?>" style="color: var(--admin-primary); font-weight: 700;">View Detail &rarr;</a></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
