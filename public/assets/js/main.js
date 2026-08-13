document.addEventListener('DOMContentLoaded', () => {

  // Mobile Drawer Toggle
  const toggleBtn = document.querySelector('.mobile-nav-toggle');
  const drawer = document.querySelector('.mobile-drawer');
  const overlay = document.querySelector('.drawer-overlay');
  const closeBtn = document.querySelector('.drawer-close');

  function openDrawer() {
    if (drawer && overlay) {
      drawer.classList.add('open');
      overlay.classList.add('active');
      document.body.style.overflow = 'hidden';
      if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
    }
  }

  function closeDrawer() {
    if (drawer && overlay) {
      drawer.classList.remove('open');
      overlay.classList.remove('active');
      document.body.style.overflow = '';
      if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
    }
  }

  if (toggleBtn) toggleBtn.addEventListener('click', openDrawer);
  if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
  if (overlay) overlay.addEventListener('click', closeDrawer);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDrawer();
  });

  // Client-side Form Validation
  const bookingForm = document.querySelector('.js-booking-form');
  if (bookingForm) {
    bookingForm.addEventListener('submit', (e) => {
      const requiredFields = bookingForm.querySelectorAll('[required]');
      let isValid = true;

      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add('is-invalid');
        } else {
          field.classList.remove('is-invalid');
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert('Please complete all required fields accurately.');
      }
    });
  }

  // Language Dropdown & Google Translate Sync
  const langWrapper = document.querySelector('.lang-dropdown-wrapper');
  if (langWrapper) {
    const langBtn = langWrapper.querySelector('.lang-dropdown-btn');
    const currentFlag = langBtn ? langBtn.querySelector('.current-flag') : null;
    const currentCode = langBtn ? langBtn.querySelector('.current-lang-code') : null;
    const langOptions = langWrapper.querySelectorAll('.lang-option');

    // Toggle Dropdown Menu
    if (langBtn) {
      langBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        langWrapper.classList.toggle('active');
        const isExpanded = langWrapper.classList.contains('active');
        langBtn.setAttribute('aria-expanded', isExpanded);
      });
    }

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (!langWrapper.contains(e.target)) {
        langWrapper.classList.remove('active');
        if (langBtn) langBtn.setAttribute('aria-expanded', 'false');
      }
    });

    // Helper to set Google Translate Cookie
    function setGTCookie(lang) {
      const hostname = window.location.hostname;
      const docLang = (document.documentElement.lang || 'en').toLowerCase();
      if (lang === 'en' || lang === 'vi') {
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=' + hostname;
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + hostname;
      } else {
        document.cookie = 'googtrans=/' + docLang + '/' + lang + '; path=/;';
        document.cookie = 'googtrans=/auto/' + lang + '; path=/;';
        document.cookie = 'googtrans=/' + docLang + '/' + lang + '; path=/; domain=' + hostname;
        document.cookie = 'googtrans=/auto/' + lang + '; path=/; domain=' + hostname;
      }
    }

    // Helper to get Cookie
    function getCookie(name) {
      const nameEQ = name + '=';
      const ca = document.cookie.split(';');
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
      }
      return null;
    }

    // Check if Google Translate cookie exists
    const googtrans = getCookie('googtrans');
    let activeGTLang = null;
    if (googtrans) {
      const parts = googtrans.split('/');
      if (parts.length > 0) {
        activeGTLang = parts[parts.length - 1];
      }
    }

    // Sync active state in dropdown if GT language active
    if (activeGTLang && activeGTLang !== 'en' && activeGTLang !== 'vi') {
      langOptions.forEach(opt => {
        if (opt.dataset.lang === activeGTLang) {
          opt.classList.add('active');
          if (currentFlag && opt.querySelector('img')) {
            currentFlag.src = opt.querySelector('img').src;
          }
          if (currentCode) {
            currentCode.textContent = activeGTLang.split('-')[0].toUpperCase();
          }
        } else {
          opt.classList.remove('active');
        }
      });
    }

    // Handle Option Click
    langOptions.forEach(opt => {
      opt.addEventListener('click', (e) => {
        const lang = opt.dataset.lang;
        const href = opt.getAttribute('href');

        if (lang === 'en' || lang === 'vi') {
          setGTCookie(lang);
          if (href && href !== '#') {
            window.location.href = href;
          } else {
            window.location.reload();
          }
        } else {
          e.preventDefault();
          setGTCookie(lang);
          
          const combo = document.querySelector('.goog-te-combo');
          if (combo) {
            combo.value = lang;
            combo.dispatchEvent(new Event('change', { bubbles: true }));
          } else {
            window.location.reload();
          }
        }
      });
    });
  }

  // Hide Google Translate Top Banner without removing worker iframe
  function killGTBanner() {
    const selector = '.goog-te-banner-frame, iframe.goog-te-banner-frame, .VIpgJd-Z44fyf-V77wed-b9VOHc, .VIpgJd-Z44fyf-V77wed, .VIpgJd-Z44fyf-O22p2-O0vWhd';
    const frames = document.querySelectorAll(selector);
    frames.forEach(frame => {
      frame.style.setProperty('display', 'none', 'important');
      frame.style.setProperty('visibility', 'hidden', 'important');
      frame.style.setProperty('height', '0px', 'important');
      frame.style.setProperty('opacity', '0', 'important');
    });
    if (document.body && document.body.style.top !== '0px') {
      document.body.style.top = '0px';
    }
  }

  setInterval(killGTBanner, 200);

  // Page Preloader Fadeout
  const preloader = document.getElementById('page-preloader');
  if (preloader) {
    const hidePreloader = () => {
      preloader.classList.add('fade-out');
      setTimeout(() => { preloader.style.display = 'none'; }, 550);
    };

    if (document.readyState === 'complete') {
      setTimeout(hidePreloader, 200);
    } else {
      window.addEventListener('load', () => setTimeout(hidePreloader, 200));
    }
    // Safety fallback
    setTimeout(hidePreloader, 2200);
  }

  // Scroll Reveal Animations (IntersectionObserver)
  if ('IntersectionObserver' in window) {
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -40px 0px' };
    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-revealed');
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    const revealSelectors = '.sovaba-hot-card, .tour-list-card, .vm-card, .why-carousel-sec, .tour-detail-card, .contact-form-box, .dest-spotlight-content, .dest-spotlight-img-box';
    document.querySelectorAll(revealSelectors).forEach((el, index) => {
      el.classList.add('reveal-on-scroll');
      el.style.transitionDelay = `${(index % 3) * 0.12}s`;
      revealObserver.observe(el);
    });
  }

  // Button Click Ripple Micro-Animation
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn, button, .nav-link, .sovaba-hot-link, .btn-search-pill');
    if (!btn) return;

    const circle = document.createElement('span');
    circle.classList.add('click-ripple-fx');
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    circle.style.width = circle.style.height = `${size}px`;
    circle.style.left = `${e.clientX - rect.left - size / 2}px`;
    circle.style.top = `${e.clientY - rect.top - size / 2}px`;

    const existing = btn.querySelector('.click-ripple-fx');
    if (existing) existing.remove();

    btn.appendChild(circle);
    setTimeout(() => circle.remove(), 600);
  });

  // Sticky Header & Back To Top Floating Button Handler
  const siteHeader = document.querySelector('.site-header');
  const backToTopBtn = document.getElementById('backToTopBtn');

  function handleScroll() {
    const scrollPos = window.scrollY || window.pageYOffset || document.documentElement.scrollTop;

    // Sticky Header: Keep header navigation visible when scrolling down
    if (siteHeader) {
      if (scrollPos > 60) {
        siteHeader.classList.add('scrolled');
      } else {
        siteHeader.classList.remove('scrolled');
      }
    }

    // Back to Top Button: Show when scrolled down past 280px
    if (backToTopBtn) {
      if (scrollPos > 280) {
        backToTopBtn.classList.add('visible');
      } else {
        backToTopBtn.classList.remove('visible');
      }
    }
  }

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll(); // Initial check on load

  if (backToTopBtn) {
    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
});
