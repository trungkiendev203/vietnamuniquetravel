<h1 style="font-size: 1.6rem; color: #022F13; text-align: center; margin-bottom: 8px;">VNU Admin Login</h1>
<p style="text-align: center; color: #666; font-size: 0.9rem; margin-bottom: 24px;">Vietnam Unique Travel Management</p>

<?php if (\App\Core\Session::has('_flash')): ?>
  <?php if ($msg = \App\Core\Session::flash('error')): ?>
    <div style="background: #F8D7DA; color: #721C24; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
      <?= e($msg) ?>
    </div>
  <?php endif; ?>
<?php endif; ?>

<form action="<?= base_url('admin/login') ?>" method="POST">
  <?= csrf_field() ?>
  <div style="margin-bottom: 16px;">
    <label style="display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 6px;">Username</label>
    <input type="text" name="username" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC; font-size: 1rem;">
  </div>

  <div style="margin-bottom: 24px;">
    <label style="display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 6px;">Password</label>
    <input type="password" name="password" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CCC; font-size: 1rem;">
  </div>

  <button type="submit" class="btn btn-brand" style="width: 100%; padding: 12px;">Sign In &rarr;</button>
</form>
