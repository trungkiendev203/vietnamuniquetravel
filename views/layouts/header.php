<?php
$currentLang = current_lang();
$prefix = $currentLang === 'vi' ? 'vi/' : '';
$currentPath = ltrim($_SERVER['REQUEST_URI'] ?? '', '/');
$currentPathWithoutLang = preg_replace('#^(en|vi)/?#i', '', $currentPath);

$isAboutPage = (bool)preg_match('#^(about-us|ve-chung-toi)#i', $currentPathWithoutLang);
$aboutUrl = base_url($currentLang === 'vi' ? 'vi/ve-chung-toi' : 'about-us');

$isContactPage = (bool)preg_match('#^(contact|lien-he)#i', $currentPathWithoutLang);
$contactUrl = base_url($currentLang === 'vi' ? 'vi/lien-he' : 'contact');

$enSwitchPath = $currentPathWithoutLang;
if ($currentPathWithoutLang === 've-chung-toi') $enSwitchPath = 'about-us';
if ($currentPathWithoutLang === 'lien-he') $enSwitchPath = 'contact';

$viSwitchPath = $currentPathWithoutLang;
if ($currentPathWithoutLang === 'about-us') $viSwitchPath = 've-chung-toi';
if ($currentPathWithoutLang === 'contact') $viSwitchPath = 'lien-he';

$isTourDetailPage = (bool)preg_match('#^tours/[^/]+#i', $currentPathWithoutLang);
$isTourListPage = (bool)preg_match('#^tours/?$#i', $currentPathWithoutLang);
$isLightHeaderPage = $isAboutPage || $isContactPage || $isTourDetailPage || $isTourListPage;

$enSwitchUrl = base_url($enSwitchPath);
$viSwitchUrl = base_url('vi/' . $viSwitchPath);
?>
<header class="site-header <?= $isLightHeaderPage ? 'header-light' : '' ?>">
  
  <!-- Far Left Corner Logo -->
  <a href="<?= base_url($prefix) ?>" class="brand-logo-far-left" aria-label="Vietnam Unique Travel">
    <img src="<?= asset('assets/images/Unique-Travel-Full-Color-Transparent.png') ?>" alt="Vietnam Unique Travel">
  </a>

  <div class="container nav-wrapper">
    <!-- Right Side Menu Links -->
    <ul class="nav-menu">
      <li><a href="<?= base_url($prefix) ?>" class="nav-link"><?= __('nav_home') ?></a></li>
      <li><a href="<?= base_url($prefix . 'tours') ?>" class="nav-link"><?= __('nav_tours') ?></a></li>
      <li><a href="<?= base_url($prefix . 'destinations') ?>" class="nav-link"><?= __('nav_destinations') ?></a></li>
      <li><a href="<?= base_url($prefix . 'experiences') ?>" class="nav-link"><?= __('nav_experiences') ?></a></li>
      <li><a href="<?= $aboutUrl ?>" class="nav-link <?= $isAboutPage ? 'active' : '' ?>"><?= __('nav_about') ?></a></li>
      <li><a href="<?= base_url($prefix . 'responsible-tourism') ?>" class="nav-link"><?= __('nav_responsible') ?></a></li>
      <li><a href="<?= base_url($prefix . 'blog') ?>" class="nav-link"><?= __('nav_blog') ?></a></li>
      <li><a href="<?= $contactUrl ?>" class="nav-link <?= $isContactPage ? 'active' : '' ?>"><?= __('nav_contact') ?></a></li>
    </ul>

    <div style="display: flex; align-items: center; gap: 14px; flex-shrink: 0;">
      <div class="lang-switch">
        <a href="<?= $enSwitchUrl ?>" class="<?= $currentLang === 'en' ? 'active' : '' ?>">EN</a>
        <span>|</span>
        <a href="<?= $viSwitchUrl ?>" class="<?= $currentLang === 'vi' ? 'active' : '' ?>">VI</a>
      </div>

      <a href="<?= base_url($prefix . 'booking') ?>" class="btn btn-gold" style="padding: 9px 18px; font-size: 0.85rem;"><?= __('btn_book_tour') ?></a>

      <button class="mobile-nav-toggle" aria-label="Toggle navigation menu">
        &#9776;
      </button>
    </div>
  </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="drawer-overlay"></div>
<div class="mobile-drawer" role="dialog" aria-modal="true">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
    <img src="<?= asset('assets/images/Unique-Travel-Full-Color-Transparent.png') ?>" alt="Vietnam Unique Travel" style="height: 40px; width: auto;">
    <button class="drawer-close" style="background: none; border: none; color: #FFF; font-size: 2rem; cursor: pointer;">&times;</button>
  </div>
  <ul style="list-style: none; display: flex; flex-direction: column; gap: 20px;">
    <li><a href="<?= base_url($prefix) ?>" class="nav-link"><?= __('nav_home') ?></a></li>
    <li><a href="<?= base_url($prefix . 'tours') ?>" class="nav-link"><?= __('nav_tours') ?></a></li>
    <li><a href="<?= base_url($prefix . 'destinations') ?>" class="nav-link"><?= __('nav_destinations') ?></a></li>
    <li><a href="<?= base_url($prefix . 'experiences') ?>" class="nav-link"><?= __('nav_experiences') ?></a></li>
    <li><a href="<?= $aboutUrl ?>" class="nav-link <?= $isAboutPage ? 'active' : '' ?>"><?= __('nav_about') ?></a></li>
    <li><a href="<?= base_url($prefix . 'responsible-tourism') ?>" class="nav-link"><?= __('nav_responsible') ?></a></li>
    <li><a href="<?= base_url($prefix . 'blog') ?>" class="nav-link"><?= __('nav_blog') ?></a></li>
    <li><a href="<?= $contactUrl ?>" class="nav-link <?= $isContactPage ? 'active' : '' ?>"><?= __('nav_contact') ?></a></li>
  </ul>
  <div style="margin-top: auto;">
    <a href="<?= base_url($prefix . 'booking') ?>" class="btn btn-gold" style="width: 100%;"><?= __('btn_book_tour') ?></a>
  </div>
</div>
