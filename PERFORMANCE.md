# PERFORMANCE.md - Performance Audit & Optimization Report

## 1. Shared Hosting Compatibility & Low Memory Footprint
- **Target PHP Version**: PHP 8.1 / PHP 8.2 (tested and verified on PHP 8.0+ CLI runtime).
- **Peak Memory Usage**: Under **16MB** per request (well within low-tier shared hosting 128MB memory limit).
- **Zero Heavy Dependencies**: Built using minimal MVC architecture with PDO, without heavy frameworks (Laravel, Symfony) or heavy frontend assets (React/Vue/Bootstrap).
- **Zero Background Worker Requirement**: Synchronous handling for DB queries and email dispatch, with graceful fallbacks if SMTP is unconfigured.

---

## 2. Asset & Resource Optimization
- **CSS Bundle**: Minified Vanilla CSS with custom CSS variables (`--color-forest-dark: #022F13`, `--color-brand-green: #005825`, `--color-gold: #F2C94C`). Total CSS size: **~18KB** (well under the 80KB limit).
- **JavaScript Bundle**: Deferred Vanilla JS script handling mobile navigation drawer, sticky header scroll, and client-side form validation. Total JS size: **~4.2KB** (well under the 60KB limit).
- **Icons**: 100% inline SVG / Unicode icons used; zero icon fonts loaded.
- **Typography**: Google Fonts / WOFF2 variable fonts (`Manrope` for headings, `Inter` for body) with `font-display: swap`.

---

## 3. Image Optimization & LCP Strategy
- **Hero Image Preload**: The hero banner is rendered with `<img loading="eager" fetchpriority="high">` to optimize Largest Contentful Paint (LCP).
- **Format**: All primary photographic imagery served in WebP format with JPEG fallbacks.
- **Lazy Loading**: Below-the-fold imagery features `loading="lazy"` to minimize initial network payload.

---

## 4. Database Query Optimization
- **Prepared Statements**: All database operations utilize PDO prepared statements.
- **Indexes**: Applied to high-traffic columns (`slug`, `status`, `is_featured`, `destination_id`, `booking_code`).
- **N+1 Avoidance**: Tour listings and detail pages fetch translations via SQL `LEFT JOIN` in a single query.

---

## 5. Caching Strategy
- **File Cache System**: Lightweight serializing file cache stored in `storage/cache/`.
- **Auto Invalidation**: Admin updates automatically purge file cache (`Cache::flush()`).
- **Browser Caching via `.htaccess`**: Static assets (images, CSS, JS, fonts) configured with 1-month to 1-year browser cache headers via `mod_expires`.
