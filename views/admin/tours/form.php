<?php
$isEdit = !empty($tour);
$tEn = $tour['translations']['en'] ?? [];
$tVi = $tour['translations']['vi'] ?? [];
$selectedCatIds = $tour['category_ids'] ?? [];
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <h1><?= $isEdit ? 'Edit Tour: ' . e($tour['code']) : 'Add New Tour' ?></h1>
  <a href="<?= base_url('admin/tours') ?>" style="color: #666; font-weight: 600; text-decoration: none;">&larr; Back to Tour List</a>
</div>

<form action="<?= base_url('admin/tours/save') ?>" method="POST">
  <?= csrf_field() ?>
  <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= $tour['id'] ?>">
  <?php endif; ?>

  <!-- Basic & Core Specifications Card -->
  <div class="admin-card" style="margin-bottom: 24px;">
    <h2 style="font-size: 1.2rem; margin-bottom: 16px; border-bottom: 1px solid #EEE; padding-bottom: 8px;">1. Basic Specifications</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Tour Code *</label>
        <input type="text" name="code" value="<?= e($tour['code'] ?? '') ?>" required placeholder="e.g. VNU-PL-01" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Slug (URL Path) *</label>
        <input type="text" name="slug" value="<?= e($tour['slug'] ?? '') ?>" required placeholder="e.g. pu-luong-adventure" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Status</label>
        <select name="status" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
          <option value="1" <?= ($tour['status'] ?? 1) == 1 ? 'selected' : '' ?>>Active (Visible Publicly)</option>
          <option value="0" <?= ($tour['status'] ?? 1) == 0 ? 'selected' : '' ?>>Hidden (Admin Only)</option>
        </select>
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Destination</label>
        <select name="destination_id" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
          <option value="">-- Select Destination --</option>
          <?php foreach ($destinations as $d): ?>
            <option value="<?= $d['id'] ?>" <?= ($tour['destination_id'] ?? '') == $d['id'] ? 'selected' : '' ?>><?= e($d['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 16px;">
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Duration Type</label>
        <select name="duration_type" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
          <option value="fullday" <?= ($tour['duration_type'] ?? '') === 'fullday' ? 'selected' : '' ?>>Full-Day</option>
          <option value="halfday" <?= ($tour['duration_type'] ?? '') === 'halfday' ? 'selected' : '' ?>>Half-Day</option>
          <option value="multiday" <?= ($tour['duration_type'] ?? '') === 'multiday' ? 'selected' : '' ?>>Multi-Day</option>
        </select>
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Duration (Days)</label>
        <input type="number" name="duration_days" value="<?= e($tour['duration_days'] ?? 1) ?>" min="1" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Difficulty</label>
        <select name="difficulty" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
          <option value="easy" <?= ($tour['difficulty'] ?? '') === 'easy' ? 'selected' : '' ?>>Easy</option>
          <option value="medium" <?= ($tour['difficulty'] ?? '') === 'medium' ? 'selected' : '' ?>>Medium</option>
          <option value="hard" <?= ($tour['difficulty'] ?? '') === 'hard' ? 'selected' : '' ?>>Hard</option>
        </select>
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Transportation</label>
        <input type="text" name="transportation" value="<?= e($tour['transportation'] ?? '') ?>" placeholder="e.g. Motorbike / Car" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Group Size</label>
        <input type="text" name="group_size" value="<?= e($tour['group_size'] ?? '') ?>" placeholder="e.g. Small Group / Private" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>
    </div>

    <!-- Pricing & Images -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-top: 16px;">
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Base Price USD ($)</label>
        <input type="number" step="0.01" name="price_from_usd" value="<?= e($tour['price_from_usd'] ?? 0) ?>" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Base Price VND (VNĐ)</label>
        <input type="number" name="price_from_vnd" value="<?= e($tour['price_from_vnd'] ?? 0) ?>" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>

      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 6px;">Featured Image Path</label>
        <input type="text" name="featured_image" value="<?= e($tour['featured_image'] ?? '') ?>" placeholder="assets/images/..." style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>
    </div>

    <!-- Categories / Experience Tags -->
    <div style="margin-top: 16px;">
      <label style="font-weight: 700; display: block; margin-bottom: 8px;">Categories / Experiences</label>
      <div style="display: flex; flex-wrap: wrap; gap: 12px;">
        <?php foreach ($categories as $c): ?>
          <label style="display: flex; align-items: center; gap: 6px; font-size: 0.95rem;">
            <input type="checkbox" name="category_ids[]" value="<?= $c['id'] ?>" <?= in_array($c['id'], $selectedCatIds) ? 'checked' : '' ?>>
            <?= e($c['name']) ?>
          </label>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Flags -->
    <div style="display: flex; gap: 24px; align-items: center; margin-top: 16px;">
      <label style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
        <input type="checkbox" name="is_featured" value="1" <?= !empty($tour['is_featured']) ? 'checked' : '' ?>> Featured Tour
      </label>
      <label style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
        <input type="checkbox" name="is_signature" value="1" <?= !empty($tour['is_signature']) ? 'checked' : '' ?>> Signature Tour
      </label>
      <div>
        <label style="font-weight: 700; margin-right: 6px;">Signature Order:</label>
        <input type="number" name="signature_number" value="<?= e($tour['signature_number'] ?? 0) ?>" style="width: 80px; padding: 4px; border: 1px solid #CCC; border-radius: 4px;">
      </div>
    </div>
  </div>

  <!-- English Content Card -->
  <div class="admin-card" style="margin-bottom: 24px;">
    <h2 style="font-size: 1.2rem; margin-bottom: 16px; border-bottom: 1px solid #EEE; padding-bottom: 8px;">2. English Content (EN)</h2>
    
    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Tour Title (EN) *</label>
      <input type="text" name="title_en" value="<?= e($tEn['title'] ?? '') ?>" required style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
    </div>

    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Sub-Title (EN)</label>
      <input type="text" name="sub_title_en" value="<?= e($tEn['sub_title'] ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
    </div>

    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Short Description (EN)</label>
      <textarea name="short_description_en" rows="3" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tEn['short_description'] ?? '') ?></textarea>
    </div>

    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Highlights (EN) - 1 line per item</label>
      <textarea name="highlights_en" rows="4" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tEn['highlights'] ?? '') ?></textarea>
    </div>

    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Overview (EN)</label>
      <textarea name="overview_en" rows="5" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tEn['overview'] ?? '') ?></textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 12px;">
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 4px;">Inclusions (EN)</label>
        <textarea name="inclusions_en" rows="4" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tEn['inclusions'] ?? '') ?></textarea>
      </div>
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 4px;">Exclusions (EN)</label>
        <textarea name="exclusions_en" rows="4" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tEn['exclusions'] ?? '') ?></textarea>
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 12px;">
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 4px;">What to bring (EN)</label>
        <textarea name="what_to_bring_en" rows="3" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tEn['what_to_bring'] ?? '') ?></textarea>
      </div>
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 4px;">SEO Title (EN)</label>
        <input type="text" name="seo_title_en" value="<?= e($tEn['seo_title'] ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
      </div>
    </div>
  </div>

  <!-- Vietnamese Content Card -->
  <div class="admin-card" style="margin-bottom: 24px;">
    <h2 style="font-size: 1.2rem; margin-bottom: 16px; border-bottom: 1px solid #EEE; padding-bottom: 8px;">3. Vietnamese Content (VI)</h2>
    
    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Tên Tour (VI)</label>
      <input type="text" name="title_vi" value="<?= e($tVi['title'] ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;">
    </div>

    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Mô tả ngắn (VI)</label>
      <textarea name="short_description_vi" rows="3" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tVi['short_description'] ?? '') ?></textarea>
    </div>

    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Điểm nổi bật (VI) - mỗi dòng 1 ý</label>
      <textarea name="highlights_vi" rows="4" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tVi['highlights'] ?? '') ?></textarea>
    </div>

    <div style="margin-bottom: 12px;">
      <label style="font-weight: 700; display: block; margin-bottom: 4px;">Tổng quan (VI)</label>
      <textarea name="overview_vi" rows="5" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tVi['overview'] ?? '') ?></textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 4px;">Bao gồm (VI)</label>
        <textarea name="inclusions_vi" rows="4" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tVi['inclusions'] ?? '') ?></textarea>
      </div>
      <div>
        <label style="font-weight: 700; display: block; margin-bottom: 4px;">Không bao gồm (VI)</label>
        <textarea name="exclusions_vi" rows="4" style="width: 100%; padding: 8px; border: 1px solid #CCC; border-radius: 6px;"><?= e($tVi['exclusions'] ?? '') ?></textarea>
      </div>
    </div>
  </div>

  <div style="margin-bottom: 40px; text-align: right;">
    <button type="submit" style="background: var(--admin-primary); color: #FFF; border: none; padding: 12px 32px; border-radius: 8px; font-weight: 800; font-size: 1.05rem; cursor: pointer;">
      💾 <?= $isEdit ? 'Save Changes' : 'Create Tour' ?>
    </button>
  </div>
</form>
