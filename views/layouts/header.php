<?php
$currentLang = current_lang();
$prefix = $currentLang === 'vi' ? 'vi/' : '';
$currentPath = ltrim($_SERVER['REQUEST_URI'] ?? '', '/');
$currentPathWithoutLang = preg_replace('#^(en|vi)/?#i', '', $currentPath);

$isHomePage = empty($currentPathWithoutLang);
$isToursPage = (bool)preg_match('#^tours/?$#i', $currentPathWithoutLang);

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
$isTravelTipsPage = (bool)preg_match('#^(travel-tips|meo-du-lich|blog)#i', $currentPathWithoutLang);
$travelTipsUrl = base_url($currentLang === 'vi' ? 'vi/meo-du-lich' : 'travel-tips');

if ($currentPathWithoutLang === 'meo-du-lich') $enSwitchPath = 'travel-tips';
if ($currentPathWithoutLang === 'travel-tips') $viSwitchPath = 'meo-du-lich';

$isLightHeaderPage = $isAboutPage || $isContactPage || $isTourDetailPage || $isTourListPage || $isTravelTipsPage;

$enSwitchUrl = base_url($enSwitchPath);
$viSwitchUrl = base_url('vi/' . $viSwitchPath);
?>
<header class="site-header <?= $isLightHeaderPage ? 'header-light' : '' ?>">
  
  <!-- Far Left Corner Logo -->
    <a href="<?= base_url($prefix) ?>" class="brand-logo-far-left" aria-label="Vietnam Unique Travel">
      <img src="<?= asset('assets/images/vnu-logo-white.png') ?>" alt="Vietnam Unique Travel" class="logo-light-variant">
      <img src="<?= asset('assets/images/vnu-logo-transparent.png') ?>" alt="Vietnam Unique Travel" class="logo-dark-variant">
    </a>

  <div class="container nav-wrapper">
    <!-- Header Menu Links (Home, Tours, Travel Tips, About us, Contact us) -->
    <ul class="nav-menu">
      <li><a href="<?= base_url($prefix) ?>" class="nav-link <?= $isHomePage ? 'active' : '' ?>"><?= __('nav_home') ?></a></li>
      <li><a href="<?= base_url($prefix . 'tours') ?>" class="nav-link <?= $isToursPage ? 'active' : '' ?>"><?= __('nav_tours') ?></a></li>
      <li><a href="<?= $travelTipsUrl ?>" class="nav-link <?= $isTravelTipsPage ? 'active' : '' ?>"><?= $currentLang === 'vi' ? 'Mẹo Du Lịch' : 'Travel Tips' ?></a></li>
      <li><a href="<?= $aboutUrl ?>" class="nav-link <?= $isAboutPage ? 'active' : '' ?>"><?= __('nav_about') ?></a></li>
      <li><a href="<?= $contactUrl ?>" class="nav-link <?= $isContactPage ? 'active' : '' ?>"><?= __('nav_contact') ?></a></li>
    </ul>

    <div class="header-actions-group">
      <!-- Language Dropdown Selector (Flags + Google Translate) -->
      <div class="lang-dropdown-wrapper">
        <button class="lang-dropdown-btn" type="button" aria-expanded="false" aria-label="Select Language">
          <img src="https://flagcdn.com/w40/<?= $currentLang === 'vi' ? 'vn' : 'gb' ?>.png" alt="Flag" class="flag-icon current-flag">
          <span class="current-lang-code"><?= strtoupper($currentLang) ?></span>
          <svg class="dropdown-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <div class="lang-dropdown-menu">
          <a href="<?= $enSwitchUrl ?>" data-lang="en" class="lang-option <?= $currentLang === 'en' ? 'active' : '' ?>">
            <img src="https://flagcdn.com/w40/gb.png" alt="English" class="flag-icon">
            <span>English</span>
          </a>
          <a href="<?= $viSwitchUrl ?>" data-lang="vi" class="lang-option <?= $currentLang === 'vi' ? 'active' : '' ?>">
            <img src="https://flagcdn.com/w40/vn.png" alt="Tiếng Việt" class="flag-icon">
            <span>Tiếng Việt</span>
          </a>
          <div class="lang-dropdown-divider"></div>
          <a href="#" data-lang="fr" class="lang-option">
            <img src="https://flagcdn.com/w40/fr.png" alt="Français" class="flag-icon">
            <span>Français</span>
          </a>
          <a href="#" data-lang="de" class="lang-option">
            <img src="https://flagcdn.com/w40/de.png" alt="Deutsch" class="flag-icon">
            <span>Deutsch</span>
          </a>
          <a href="#" data-lang="ja" class="lang-option">
            <img src="https://flagcdn.com/w40/jp.png" alt="日本語" class="flag-icon">
            <span>日本語</span>
          </a>
          <a href="#" data-lang="es" class="lang-option">
            <img src="https://flagcdn.com/w40/es.png" alt="Español" class="flag-icon">
            <span>Español</span>
          </a>
          <a href="#" data-lang="zh-CN" class="lang-option">
            <img src="https://flagcdn.com/w40/cn.png" alt="中文" class="flag-icon">
            <span>中文 (简体)</span>
          </a>
          <a href="#" data-lang="ko" class="lang-option">
            <img src="https://flagcdn.com/w40/kr.png" alt="한국어" class="flag-icon">
            <span>한국어</span>
          </a>
          <a href="#" data-lang="it" class="lang-option">
            <img src="https://flagcdn.com/w40/it.png" alt="Italiano" class="flag-icon">
            <span>Italiano</span>
          </a>
          <a href="#" data-lang="ru" class="lang-option">
            <img src="https://flagcdn.com/w40/ru.png" alt="Русский" class="flag-icon">
            <span>Русский</span>
          </a>
        </div>
      </div>

      <a href="<?= base_url($prefix . 'booking') ?>" class="btn btn-gold header-book-btn"><?= __('btn_book_tour') ?></a>

      <button class="mobile-nav-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
        &#9776;
      </button>
    </div>
  </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="drawer-overlay"></div>
<div class="mobile-drawer" role="dialog" aria-modal="true" aria-label="Mobile Navigation">
  <div class="drawer-header">
    <img src="<?= asset('assets/images/vnu-logo-white.png') ?>" alt="Vietnam Unique Travel" class="drawer-logo">
    <button class="drawer-close" aria-label="Close navigation menu">&times;</button>
  </div>
  <ul class="drawer-nav-list">
    <li><a href="<?= base_url($prefix) ?>" class="drawer-nav-link <?= $isHomePage ? 'active' : '' ?>"><?= __('nav_home') ?></a></li>
    <li><a href="<?= base_url($prefix . 'tours') ?>" class="drawer-nav-link <?= $isToursPage ? 'active' : '' ?>"><?= __('nav_tours') ?></a></li>
    <li><a href="<?= $travelTipsUrl ?>" class="drawer-nav-link <?= $isTravelTipsPage ? 'active' : '' ?>">💡 <?= $currentLang === 'vi' ? 'Mẹo Du Lịch' : 'Travel Tips' ?></a></li>
    <li><a href="<?= base_url($prefix . 'destinations') ?>" class="drawer-nav-link"><?= __('nav_destinations') ?></a></li>
    <li><a href="<?= base_url($prefix . 'experiences') ?>" class="drawer-nav-link"><?= __('nav_experiences') ?></a></li>
    <li><a href="<?= $aboutUrl ?>" class="drawer-nav-link <?= $isAboutPage ? 'active' : '' ?>"><?= __('nav_about') ?></a></li>
    <li><a href="<?= base_url($prefix . 'responsible-tourism') ?>" class="drawer-nav-link"><?= __('nav_responsible') ?></a></li>
    <li><a href="<?= $contactUrl ?>" class="drawer-nav-link <?= $isContactPage ? 'active' : '' ?>"><?= __('nav_contact') ?></a></li>
  </ul>
  <div class="drawer-footer-cta">
    <a href="<?= base_url($prefix . 'booking') ?>" class="btn btn-gold drawer-cta-btn"><?= __('btn_book_tour') ?></a>
  </div>
</div>
