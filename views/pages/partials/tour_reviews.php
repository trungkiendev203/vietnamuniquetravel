<?php
$isVi = $lang === 'vi';
$avgRating = $ratingStats['avg_rating'] ?? 5.0;
$totalReviews = $ratingStats['total_reviews'] ?? 0;
?>

<div id="reviews" style="margin-top: 60px; padding-top: 40px; border-top: 1px solid rgba(0,0,0,0.08);">
  
  <!-- Header & Rating Summary -->
  <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 16px; margin-bottom: 28px;">
    <div>
      <h2 style="font-family: var(--font-heading); font-size: 1.8rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 6px;">
        <?= $isVi ? 'Đánh giá từ du khách' : 'Traveler Reviews' ?>
      </h2>
      <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 1.4rem; font-weight: 800; color: #F59E0B; font-family: var(--font-heading);"><?= number_format($avgRating, 1) ?></span>
        <span style="color: #F59E0B; font-size: 1.2rem;">
          <?= str_repeat('★', (int)round($avgRating)) ?><?= str_repeat('☆', 5 - (int)round($avgRating)) ?>
        </span>
        <span style="color: #64748B; font-size: 0.95rem; font-weight: 600;">
          (<?= $totalReviews ?> <?= $isVi ? 'đánh giá đã duyệt' : 'verified reviews' ?>)
        </span>
      </div>
    </div>
  </div>

  <!-- Flash Messages -->
  <?php if (\App\Core\Session::has('_flash')): ?>
    <?php if ($msg = \App\Core\Session::flash('success')): ?>
      <div style="background: #D1FAE5; color: #065F46; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; font-weight: 700;">
        <?= e($msg) ?>
      </div>
    <?php endif; ?>
    <?php if ($msg = \App\Core\Session::flash('error')): ?>
      <div style="background: #FEE2E2; color: #991B1B; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; font-weight: 700;">
        <?= e($msg) ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 36px;">
    <!-- Left: List of Approved Reviews -->
    <div>
      <?php if (empty($approvedReviews)): ?>
        <div style="background: #F8FAFC; padding: 24px; border-radius: 10px; border: 1px solid #E2E8F0; color: #64748B;">
          <?= $isVi ? 'Chưa có đánh giá nào cho tour này. Hãy là người đầu tiên chia sẻ cảm nhận!' : 'No reviews yet for this journey. Be the first to share your experience!' ?>
        </div>
      <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 20px;">
          <?php foreach ($approvedReviews as $rev): ?>
            <div style="background: #FFFFFF; border-radius: 10px; padding: 20px; border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div>
                  <strong style="font-size: 1.05rem; color: #1E293B;"><?= e($rev['client_name']) ?></strong>
                  <div style="color: #F59E0B; font-size: 0.95rem; margin-top: 2px;">
                    <?= str_repeat('★', (int)$rev['rating']) ?><?= str_repeat('☆', 5 - (int)$rev['rating']) ?>
                  </div>
                </div>
                <span style="font-size: 0.8rem; color: #94A3B8;"><?= e(date('M d, Y', strtotime($rev['created_at']))) ?></span>
              </div>
              <p style="color: #334155; font-size: 0.98rem; line-height: 1.7; margin: 0; white-space: pre-line;"><?= e($rev['content']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Right: Write a Review Form -->
    <div>
      <div style="background: #FFFFFF; border-radius: 12px; padding: 28px; border: 1px solid rgba(0,0,0,0.08); position: sticky; top: 100px;">
        <h3 style="font-family: var(--font-heading); font-size: 1.3rem; font-weight: 800; color: var(--color-brand-green); margin-bottom: 16px;">
          <?= $isVi ? 'Viết đánh giá của bạn' : 'Write a Review' ?>
        </h3>

        <form action="<?= base_url(($isVi ? 'vi/' : '') . 'tours/' . $tour['slug'] . '/review') ?>" method="POST">
          <?= csrf_field() ?>
          <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-weight: 700; font-size: 0.88rem; color: #1E293B; margin-bottom: 4px;">
              <?= $isVi ? 'Họ và tên *' : 'Full Name *' ?>
            </label>
            <input type="text" name="client_name" required maxlength="100" style="width: 100%; height: 42px; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 6px;">
          </div>



          <div style="margin-bottom: 14px;">
            <label style="display: block; font-weight: 700; font-size: 0.88rem; color: #1E293B; margin-bottom: 4px;">
              <?= $isVi ? 'Đánh giá số sao' : 'Rating' ?>
            </label>
            <select name="rating" style="width: 100%; height: 42px; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 6px;">
              <option value="5">⭐⭐⭐⭐⭐ (5/5 Excellent)</option>
              <option value="4">⭐⭐⭐⭐☆ (4/5 Very Good)</option>
              <option value="3">⭐⭐⭐☆☆ (3/5 Average)</option>
              <option value="2">⭐⭐☆☆☆ (2/5 Poor)</option>
              <option value="1">⭐☆☆☆☆ (1/5 Terrible)</option>
            </select>
          </div>

          <div style="margin-bottom: 18px;">
            <label style="display: block; font-weight: 700; font-size: 0.88rem; color: #1E293B; margin-bottom: 4px;">
              <?= $isVi ? 'Nội dung cảm nhận *' : 'Review Content *' ?>
            </label>
            <textarea name="content" required minlength="10" maxlength="2000" rows="4" placeholder="<?= $isVi ? 'Chia sẻ trải nghiệm của bạn về chuyến đi...' : 'Share your journey experience...' ?>" style="width: 100%; padding: 10px 12px; border: 1px solid #CBD5E1; border-radius: 6px; line-height: 1.5;"></textarea>
          </div>

          <button type="submit" class="btn btn-brand" style="width: 100%; height: 46px; background: var(--color-brand-green); color: #FFF; font-weight: 800; border-radius: 6px;">
            <?= $isVi ? 'Gửi đánh giá' : 'Submit Review' ?> &rarr;
          </button>
        </form>
      </div>
    </div>
  </div>

</div>
