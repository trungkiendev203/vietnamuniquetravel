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
    }
  }

  function closeDrawer() {
    if (drawer && overlay) {
      drawer.classList.remove('open');
      overlay.classList.remove('active');
      document.body.style.overflow = '';
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
      if (lang === 'en' || lang === 'vi') {
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=' + hostname;
      } else {
        document.cookie = 'googtrans=/en/' + lang + '; path=/;';
        document.cookie = 'googtrans=/en/' + lang + '; path=/; domain=' + hostname;
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
            combo.dispatchEvent(new Event('change'));
          } else {
            window.location.reload();
          }
        }
      });
    });
  }
});
