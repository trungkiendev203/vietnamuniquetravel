<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <h1>Booking Request: <?= e($booking['booking_code']) ?></h1>
  <a href="<?= base_url('admin/bookings') ?>" style="color: #666; font-weight: 600;">&larr; Back to Bookings</a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
  
  <div class="admin-card">
    <h2 style="font-size: 1.2rem; color: var(--admin-primary); margin-bottom: 16px;">Trip & Customer Details</h2>
    <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700; width: 180px;">Tour:</td><td><?= e($booking['tour_name']) ?></td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Travel Date:</td><td><?= e($booking['travel_date']) ?></td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Group Size:</td><td><?= e($booking['adults']) ?> Adults, <?= e($booking['children']) ?> Children</td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Full Name:</td><td><?= e($booking['fullname']) ?></td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Nationality:</td><td><?= e($booking['nationality']) ?></td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Email:</td><td><a href="mailto:<?= e($booking['email']) ?>"><?= e($booking['email']) ?></a></td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Phone / WhatsApp:</td><td><a href="https://wa.me/<?= preg_replace('#[^0-9]#', '', $booking['phone_whatsapp']) ?>" target="_blank" style="color: #25D366; font-weight: 700;"><?= e($booking['phone_whatsapp']) ?></a></td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Pickup Location:</td><td><?= e($booking['pickup_location']) ?></td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Dietary Requirements:</td><td><?= e($booking['dietary_requirements']) ?></td></tr>
      <tr style="border-bottom: 1px solid #EEE;"><td style="padding: 10px 0; font-weight: 700;">Health Notes:</td><td><?= e($booking['health_notes']) ?></td></tr>
      <tr><td style="padding: 10px 0; font-weight: 700;">Special Requests:</td><td><?= nl2br(e($booking['special_requests'])) ?></td></tr>
    </table>
  </div>

  <div class="admin-card">
    <h2 style="font-size: 1.2rem; color: var(--admin-primary); margin-bottom: 16px;">Management</h2>
    
    <form action="<?= base_url('admin/bookings/' . $booking['booking_code'] . '/update') ?>" method="POST">
      <?= csrf_field() ?>
      <div style="margin-bottom: 16px;">
        <label style="display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 6px;">Booking Status</label>
        <select name="status" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC;">
          <option value="new" <?= $booking['status'] === 'new' ? 'selected' : '' ?>>New</option>
          <option value="contacted" <?= $booking['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
          <option value="confirmed" <?= $booking['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
          <option value="completed" <?= $booking['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
          <option value="cancelled" <?= $booking['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 6px;">Internal Operation Notes</label>
        <textarea name="internal_notes" rows="4" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC;"><?= e($booking['internal_notes'] ?? '') ?></textarea>
      </div>

      <button type="submit" class="btn btn-brand" style="width: 100%; padding: 10px;">Update Status & Notes</button>
    </form>
  </div>

</div>
