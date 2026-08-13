<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <h1>Review Detail #<?= $review['id'] ?></h1>
  <a href="<?= base_url('admin/reviews') ?>" style="color: #666; font-weight: 600; text-decoration: none;">&larr; Back to Review List</a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
  <!-- Left Column: Edit Form -->
  <div class="admin-card">
    <h2 style="font-size: 1.2rem; margin-bottom: 16px; border-bottom: 1px solid #EEE; padding-bottom: 8px;">Edit Review Details</h2>

    <form action="<?= base_url('admin/reviews/' . $review['id'] . '/update') ?>" method="POST">
      <?= csrf_field() ?>

      <div style="margin-bottom: 16px;">
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Client Name *</label>
        <input type="text" name="client_name" value="<?= e($review['client_name']) ?>" required style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>

      <div style="margin-bottom: 16px;">
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Rating (1 to 5 Stars)</label>
        <select name="rating" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <option value="<?= $i ?>" <?= (int)$review['rating'] === $i ? 'selected' : '' ?>><?= $i ?> Stars (<?= str_repeat('★', $i) ?>)</option>
          <?php endfor; ?>
        </select>
      </div>

      <div style="margin-bottom: 16px;">
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Review Content *</label>
        <textarea name="content" rows="6" required style="width: 100%; padding: 10px; border: 1px solid #CCC; border-radius: 6px; line-height: 1.6;"><?= e($review['content']) ?></textarea>
      </div>

      <div style="margin-bottom: 24px;">
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Moderation Status</label>
        <select name="status" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
          <option value="pending" <?= $review['status'] === 'pending' ? 'selected' : '' ?>>Pending Moderation</option>
          <option value="approved" <?= $review['status'] === 'approved' ? 'selected' : '' ?>>Approved (Public)</option>
          <option value="rejected" <?= $review['status'] === 'rejected' ? 'selected' : '' ?>>Rejected (Hidden)</option>
        </select>
      </div>

      <button type="submit" style="background: var(--admin-primary); color: #FFF; border: none; padding: 10px 24px; border-radius: 6px; font-weight: 700; cursor: pointer;">
        💾 Save Review Changes
      </button>
    </form>
  </div>

  <!-- Right Column: Meta Information & Quick Actions -->
  <div>
    <div class="admin-card" style="margin-bottom: 20px;">
      <h3 style="font-size: 1.1rem; margin-bottom: 12px; border-bottom: 1px solid #EEE; padding-bottom: 8px;">Metadata</h3>
      
      <p style="margin-bottom: 10px;"><strong>Client Email:</strong><br><span style="color: #4B5563;"><?= e($review['email']) ?></span></p>

      <p style="margin-bottom: 10px;"><strong>Tour:</strong><br><span><?= e($review['tour_name'] ?: 'Tour #' . $review['tour_id']) ?></span></p>

      <p style="margin-bottom: 10px;"><strong>Booking Reference:</strong><br>
        <?php if (!empty($review['booking_code'])): ?>
          <a href="<?= base_url('admin/bookings/' . $review['booking_code']) ?>" style="color: #2563EB; font-weight: 700; text-decoration: none;">
            <?= e($review['booking_code']) ?>
          </a>
        <?php else: ?>
          <span style="color: #94A3B8;">No booking code linked</span>
        <?php endif; ?>
      </p>

      <p style="margin-bottom: 10px;"><strong>Created At:</strong><br><span style="color: #6B7280;"><?= e($review['created_at']) ?></span></p>
    </div>

    <!-- Actions -->
    <div class="admin-card">
      <h3 style="font-size: 1.1rem; margin-bottom: 12px;">Quick Moderation Actions</h3>
      <div style="display: flex; flex-direction: column; gap: 10px;">
        <form action="<?= base_url('admin/reviews/' . $review['id'] . '/status') ?>" method="POST">
          <?= csrf_field() ?>
          <input type="hidden" name="status" value="approved">
          <button type="submit" style="width: 100%; background: #10B981; color: #FFF; border: none; padding: 10px; border-radius: 6px; font-weight: 800; cursor: pointer;">
            ✓ Approve Review
          </button>
        </form>

        <form action="<?= base_url('admin/reviews/' . $review['id'] . '/status') ?>" method="POST">
          <?= csrf_field() ?>
          <input type="hidden" name="status" value="rejected">
          <button type="submit" style="width: 100%; background: #F59E0B; color: #FFF; border: none; padding: 10px; border-radius: 6px; font-weight: 800; cursor: pointer;">
            ✗ Reject Review
          </button>
        </form>

        <form action="<?= base_url('admin/reviews/' . $review['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Permanently delete this review?');">
          <?= csrf_field() ?>
          <button type="submit" style="width: 100%; background: #EF4444; color: #FFF; border: none; padding: 10px; border-radius: 6px; font-weight: 800; cursor: pointer; margin-top: 10px;">
            🗑 Delete Review
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
