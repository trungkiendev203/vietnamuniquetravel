<h1 style="margin-bottom: 24px;">System Settings</h1>

<div class="admin-card" style="max-width: 700px;">
  <form action="<?= base_url('admin/settings/save') ?>" method="POST">
    <?= csrf_field() ?>

    <div style="margin-bottom: 16px;">
      <label style="display: block; font-weight: 700; margin-bottom: 6px;">Brand Name</label>
      <input type="text" name="site_name" value="<?= e($settings['site_name'] ?? 'Vietnam Unique Travel') ?>" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC;">
    </div>

    <div style="margin-bottom: 16px;">
      <label style="display: block; font-weight: 700; margin-bottom: 6px;">Business Entity Name</label>
      <input type="text" name="company_name" value="<?= e($settings['company_name'] ?? 'CÔNG TY CỔ PHẦN DU LỊCH THÀNH HƯNG') ?>" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC;">
    </div>

    <div style="margin-bottom: 16px;">
      <label style="display: block; font-weight: 700; margin-bottom: 6px;">Tax Code (MST)</label>
      <input type="text" name="tax_code" value="<?= e($settings['tax_code'] ?? '0102126315') ?>" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC;">
    </div>

    <div style="margin-bottom: 16px;">
      <label style="display: block; font-weight: 700; margin-bottom: 6px;">Hotline Number</label>
      <input type="text" name="hotline" value="<?= e($settings['hotline'] ?? '+84 362 191 568') ?>" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC;">
    </div>

    <div style="margin-bottom: 16px;">
      <label style="display: block; font-weight: 700; margin-bottom: 6px;">Email Address</label>
      <input type="email" name="email" value="<?= e($settings['email'] ?? 'sales.vietnamuniquetravel@gmail.com') ?>" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC;">
    </div>

    <div style="margin-bottom: 24px;">
      <label style="display: block; font-weight: 700; margin-bottom: 6px;">Office Address</label>
      <input type="text" name="address" value="<?= e($settings['address'] ?? '200 Ngõ 192 Lê Trọng Tấn, Phường Phương Liệt, Hà Nội') ?>" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC;">
    </div>

    <button type="submit" class="btn btn-brand" style="padding: 12px 24px;">Save Settings</button>
  </form>
</div>
