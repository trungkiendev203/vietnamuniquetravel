/**
 * Vietnam Unique Travel - Tours Listing Filter & Discovery UX Controller
 */
document.addEventListener('DOMContentLoaded', () => {
  const toursGrid = document.getElementById('tours-grid');
  const countNumber = document.getElementById('tours-count-num');
  const countLabel = document.getElementById('tours-count-label');
  const sortSelect = document.getElementById('tours-sort-select');
  const activeChipsContainer = document.getElementById('tours-active-chips');
  const clearAllBtns = document.querySelectorAll('.js-clear-filters');
  const emptyState = document.getElementById('tours-empty-state');

  // Mobile Drawer elements
  const mobileFilterBtn = document.getElementById('mobile-filter-btn');
  const mobileFilterBackdrop = document.getElementById('mobile-filter-backdrop');
  const mobileFilterClose = document.getElementById('mobile-filter-close');
  const mobileFilterApply = document.getElementById('mobile-filter-apply');
  const mobileFilterReset = document.getElementById('mobile-filter-reset');
  const mobileFilterBadge = document.getElementById('mobile-filter-badge');

  // Get initial dataset from global window variable or DOM
  const allTours = window.VNU_ALL_TOURS || [];
  const currentLang = document.documentElement.lang || 'en';

  // Wishlist / Favorites from localStorage
  const getWishlist = () => {
    try {
      return JSON.parse(localStorage.getItem('vnu_wishlist') || '[]');
    } catch {
      return [];
    }
  };

  const toggleWishlist = (tourId) => {
    let list = getWishlist();
    if (list.includes(tourId)) {
      list = list.filter(id => id !== tourId);
    } else {
      list.push(tourId);
    }
    localStorage.setItem('vnu_wishlist', JSON.stringify(list));
    updateWishlistIcons();
  };

  const updateWishlistIcons = () => {
    const list = getWishlist();
    document.querySelectorAll('.tours-fav-btn').forEach(btn => {
      const id = parseInt(btn.dataset.tourId, 10);
      if (list.includes(id)) {
        btn.classList.add('active');
        btn.setAttribute('aria-label', 'Remove from wishlist');
      } else {
        btn.classList.remove('active');
        btn.setAttribute('aria-label', 'Add to wishlist');
      }
    });
  };

  // State object
  const state = {
    destination: 'all',
    experiences: [],
    duration: 'all',
    sort: 'recommended'
  };

  // Parse URL search params
  const loadStateFromUrl = () => {
    const params = new URLSearchParams(window.location.search);
    state.destination = params.get('destination') || 'all';
    
    const expParam = params.get('experience');
    state.experiences = expParam ? expParam.split(',').filter(Boolean) : [];

    state.duration = params.get('duration') || 'all';
    state.sort = params.get('sort') || 'recommended';

    if (sortSelect) {
      sortSelect.value = state.sort;
    }

    syncInputsWithState();
  };

  // Sync inputs in DOM with current state
  const syncInputsWithState = () => {
    // Destination radios/inputs
    document.querySelectorAll('input[name="filter_destination"], input[name="mobile_filter_destination"]').forEach(input => {
      input.checked = (input.value === state.destination);
    });

    // Quick destination header buttons
    document.querySelectorAll('.js-quick-dest').forEach(btn => {
      if (btn.dataset.dest === state.destination) {
        btn.classList.add('active');
      } else {
        btn.classList.remove('active');
      }
    });

    // Experience checkboxes
    document.querySelectorAll('input[name="filter_experience[]"], input[name="mobile_filter_experience[]"]').forEach(input => {
      input.checked = state.experiences.includes(input.value);
    });

    // Duration radios
    document.querySelectorAll('input[name="filter_duration"], input[name="mobile_filter_duration"]').forEach(input => {
      input.checked = (input.value === state.duration);
    });

    // Sort select
    if (sortSelect) {
      sortSelect.value = state.sort;
    }
  };

  // Update URL search params
  const updateUrl = () => {
    const params = new URLSearchParams();
    if (state.destination && state.destination !== 'all') {
      params.set('destination', state.destination);
    }
    if (state.experiences.length > 0) {
      params.set('experience', state.experiences.join(','));
    }
    if (state.duration && state.duration !== 'all') {
      params.set('duration', state.duration);
    }
    if (state.sort && state.sort !== 'recommended') {
      params.set('sort', state.sort);
    }

    const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
    window.history.pushState(state, '', newUrl);
  };

  // Filter tour data
  const filterTours = () => {
    let filtered = [...allTours];

    // Destination
    if (state.destination && state.destination !== 'all') {
      filtered = filtered.filter(t => {
        const destSlug = (t.destination_slug || '').toLowerCase();
        const tourSlug = (t.slug || '').toLowerCase();
        const filterVal = state.destination.toLowerCase();
        if (filterVal === 'pu-luong') return destSlug.includes('pu-luong') || tourSlug.includes('pu-luong');
        if (filterVal === 'mai-chau') return destSlug.includes('mai-chau') || tourSlug.includes('mai-chau');
        if (filterVal === 'ninh-binh') return destSlug.includes('ninh-binh') || tourSlug.includes('ninh-binh');
        if (filterVal === 'northern-vietnam') return destSlug.includes('ha-giang') || destSlug.includes('northern') || tourSlug.includes('northern') || tourSlug.includes('ha-giang');
        return destSlug.includes(filterVal) || tourSlug.includes(filterVal) || String(t.destination_id) === filterVal;
      });
    }

    // Experiences (Must match any of the selected experiences)
    if (state.experiences.length > 0) {
      filtered = filtered.filter(t => {
        const tCats = (t.category_slugs || []).map(s => s.toLowerCase());
        return state.experiences.some(exp => tCats.includes(exp.toLowerCase()));
      });
    }

    // Duration
    if (state.duration && state.duration !== 'all') {
      filtered = filtered.filter(t => {
        const durType = (t.duration_type || '').toLowerCase();
        const days = parseInt(t.duration_days, 10) || 1;
        const dur = state.duration.toLowerCase();

        if (dur === 'day-trip' || dur === '1') {
          return durType === 'halfday' || durType === 'fullday' || days === 1;
        }
        if (dur === '2-3-days' || dur === '2-3') {
          return days >= 2 && days <= 3;
        }
        if (dur === '4-5-days' || dur === '4-5') {
          return days >= 4 && days <= 5;
        }
        if (dur === '6-plus' || dur === '6+') {
          return days >= 6;
        }
        return true;
      });
    }

    // Sorting
    if (state.sort === 'price-asc') {
      filtered.sort((a, b) => parseFloat(a.price_from_usd || 0) - parseFloat(b.price_from_usd || 0));
    } else if (state.sort === 'price-desc') {
      filtered.sort((a, b) => parseFloat(b.price_from_usd || 0) - parseFloat(a.price_from_usd || 0));
    } else if (state.sort === 'duration') {
      filtered.sort((a, b) => {
        const daysA = parseInt(a.duration_days, 10) || 1;
        const daysB = parseInt(b.duration_days, 10) || 1;
        if (daysA !== daysB) return daysA - daysB;
        return (a.duration_type === 'halfday' ? 1 : 2) - (b.duration_type === 'halfday' ? 1 : 2);
      });
    } else if (state.sort === 'newest') {
      filtered.sort((a, b) => parseInt(b.id, 10) - parseInt(a.id, 10));
    } else {
      // Recommended: signature first
      filtered.sort((a, b) => {
        if ((b.is_signature || 0) !== (a.is_signature || 0)) {
          return (b.is_signature || 0) - (a.is_signature || 0);
        }
        return (a.sort_order || 0) - (b.sort_order || 0);
      });
    }

    renderResults(filtered);
    updateActiveChips();
    updateFilterCounts();
  };

  // Render cards in grid
  const renderResults = (tours) => {
    if (!toursGrid) return;

    if (countNumber) {
      countNumber.textContent = tours.length;
    }
    if (countLabel) {
      countLabel.textContent = tours.length === 1 ? 
        (currentLang === 'vi' ? 'HÀNH TRÌNH' : 'JOURNEY') : 
        (currentLang === 'vi' ? 'HÀNH TRÌNH' : 'JOURNEYS');
    }

    if (tours.length === 0) {
      toursGrid.style.display = 'none';
      if (emptyState) emptyState.style.display = 'block';
      return;
    }

    toursGrid.style.display = 'grid';
    if (emptyState) emptyState.style.display = 'none';

    // Show/hide tour cards in existing DOM
    const cardElements = toursGrid.querySelectorAll('.tours-card');
    const matchingIds = new Set(tours.map(t => parseInt(t.id, 10)));

    cardElements.forEach(card => {
      const id = parseInt(card.dataset.tourId, 10);
      if (matchingIds.has(id)) {
        card.style.display = 'flex';
      } else {
        card.style.display = 'none';
      }
    });

    // Reorder DOM cards based on sorted array
    tours.forEach(t => {
      const card = toursGrid.querySelector(`.tours-card[data-tour-id="${t.id}"]`);
      if (card) {
        toursGrid.appendChild(card);
      }
    });

    updateWishlistIcons();
  };

  // Active filter chips UI
  const updateActiveChips = () => {
    if (!activeChipsContainer) return;

    activeChipsContainer.innerHTML = '';
    let hasFilters = false;
    let filterCount = 0;

    // Destination chip
    if (state.destination && state.destination !== 'all') {
      hasFilters = true;
      filterCount++;
      const label = document.querySelector(`input[name="filter_destination"][value="${state.destination}"]`)
                      ?.closest('label')?.querySelector('.filter-item-name')?.textContent || state.destination;
      createChip(label, () => {
        state.destination = 'all';
        syncInputsWithState();
        updateUrl();
        filterTours();
      });
    }

    // Experience chips
    state.experiences.forEach(exp => {
      hasFilters = true;
      filterCount++;
      const label = document.querySelector(`input[name="filter_experience[]"][value="${exp}"]`)
                      ?.closest('label')?.querySelector('.filter-item-name')?.textContent || exp;
      createChip(label, () => {
        state.experiences = state.experiences.filter(e => e !== exp);
        syncInputsWithState();
        updateUrl();
        filterTours();
      });
    });

    // Duration chip
    if (state.duration && state.duration !== 'all') {
      hasFilters = true;
      filterCount++;
      const label = document.querySelector(`input[name="filter_duration"][value="${state.duration}"]`)
                      ?.closest('label')?.querySelector('.filter-item-name')?.textContent || state.duration;
      createChip(label, () => {
        state.duration = 'all';
        syncInputsWithState();
        updateUrl();
        filterTours();
      });
    }

    // Show/hide Clear All buttons
    clearAllBtns.forEach(btn => {
      if (hasFilters) {
        btn.classList.add('visible');
      } else {
        btn.classList.remove('visible');
      }
    });

    // Mobile badge count
    if (mobileFilterBadge) {
      if (filterCount > 0) {
        mobileFilterBadge.textContent = filterCount;
        mobileFilterBadge.style.display = 'inline-block';
      } else {
        mobileFilterBadge.style.display = 'none';
      }
    }
  };

  const createChip = (text, onRemove) => {
    const chip = document.createElement('span');
    chip.className = 'tours-chip';
    chip.innerHTML = `<span>${text}</span><button type="button" class="tours-chip-remove" aria-label="Remove filter">✕</button>`;
    chip.querySelector('.tours-chip-remove').addEventListener('click', onRemove);
    activeChipsContainer.appendChild(chip);
  };

  // Update dynamic count numbers on filter inputs
  const updateFilterCounts = () => {
    // Count for each destination
    document.querySelectorAll('.filter-count-badge[data-count-type="dest"]').forEach(badge => {
      const val = badge.dataset.countVal;
      if (val === 'all') {
        badge.textContent = allTours.length;
      } else {
        const count = allTours.filter(t => {
          const destSlug = (t.destination_slug || '').toLowerCase();
          const tourSlug = (t.slug || '').toLowerCase();
          if (val === 'pu-luong') return destSlug.includes('pu-luong') || tourSlug.includes('pu-luong');
          if (val === 'mai-chau') return destSlug.includes('mai-chau') || tourSlug.includes('mai-chau');
          if (val === 'ninh-binh') return destSlug.includes('ninh-binh') || tourSlug.includes('ninh-binh');
          if (val === 'northern-vietnam') return destSlug.includes('ha-giang') || destSlug.includes('northern') || tourSlug.includes('northern') || tourSlug.includes('ha-giang');
          return destSlug.includes(val);
        }).length;
        badge.textContent = count;
      }
    });

    // Count for each experience
    document.querySelectorAll('.filter-count-badge[data-count-type="exp"]').forEach(badge => {
      const val = badge.dataset.countVal;
      const count = allTours.filter(t => {
        const tCats = (t.category_slugs || []).map(s => s.toLowerCase());
        return tCats.includes(val.toLowerCase());
      }).length;
      badge.textContent = count;
    });

    // Count for each duration
    document.querySelectorAll('.filter-count-badge[data-count-type="dur"]').forEach(badge => {
      const val = badge.dataset.countVal;
      const count = allTours.filter(t => {
        const durType = (t.duration_type || '').toLowerCase();
        const days = parseInt(t.duration_days, 10) || 1;
        if (val === 'day-trip') return durType === 'halfday' || durType === 'fullday' || days === 1;
        if (val === '2-3-days') return days >= 2 && days <= 3;
        if (val === '4-5-days') return days >= 4 && days <= 5;
        if (val === '6-plus') return days >= 6;
        return true;
      }).length;
      badge.textContent = count;
    });
  };

  // Reset all filters
  const resetFilters = () => {
    state.destination = 'all';
    state.experiences = [];
    state.duration = 'all';
    syncInputsWithState();
    updateUrl();
    filterTours();
  };

  // Event Listeners
  // Quick Destination Buttons in Header
  document.addEventListener('click', (e) => {
    const quickBtn = e.target.closest('.js-quick-dest');
    if (quickBtn) {
      e.preventDefault();
      const dest = quickBtn.dataset.dest;
      state.destination = (state.destination === dest) ? 'all' : dest;
      syncInputsWithState();
      updateUrl();
      filterTours();

      // Smooth scroll down to results section
      const resultsSec = document.getElementById('tours-results-section');
      if (resultsSec) {
        const topOffset = resultsSec.getBoundingClientRect().top + window.pageYOffset - 90;
        window.scrollTo({ top: topOffset, behavior: 'smooth' });
      }
    }
  });

  // Destination radios
  document.addEventListener('change', (e) => {
    if (e.target.name === 'filter_destination' || e.target.name === 'mobile_filter_destination') {
      state.destination = e.target.value;
      syncInputsWithState();
      updateUrl();
      filterTours();
    }

    if (e.target.name === 'filter_experience[]' || e.target.name === 'mobile_filter_experience[]') {
      const checkedBoxes = document.querySelectorAll(`input[name="${e.target.name}"]:checked`);
      state.experiences = Array.from(checkedBoxes).map(cb => cb.value);
      syncInputsWithState();
      updateUrl();
      filterTours();
    }

    if (e.target.name === 'filter_duration' || e.target.name === 'mobile_filter_duration') {
      state.duration = e.target.value;
      syncInputsWithState();
      updateUrl();
      filterTours();
    }
  });

  // Sort dropdown
  if (sortSelect) {
    sortSelect.addEventListener('change', () => {
      state.sort = sortSelect.value;
      updateUrl();
      filterTours();
    });
  }

  // Clear all button clicks
  clearAllBtns.forEach(btn => {
    btn.addEventListener('click', resetFilters);
  });

  // Wishlist heart clicks
  document.addEventListener('click', (e) => {
    const favBtn = e.target.closest('.tours-fav-btn');
    if (favBtn) {
      e.preventDefault();
      e.stopPropagation();
      const tourId = parseInt(favBtn.dataset.tourId, 10);
      toggleWishlist(tourId);
    }
  });

  // Mobile Drawer toggles
  if (mobileFilterBtn && mobileFilterBackdrop) {
    mobileFilterBtn.addEventListener('click', () => {
      mobileFilterBackdrop.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  }

  const closeMobileDrawer = () => {
    if (mobileFilterBackdrop) {
      mobileFilterBackdrop.classList.remove('open');
      document.body.style.overflow = '';
    }
  };

  if (mobileFilterClose) mobileFilterClose.addEventListener('click', closeMobileDrawer);
  if (mobileFilterApply) mobileFilterApply.addEventListener('click', closeMobileDrawer);
  if (mobileFilterReset) {
    mobileFilterReset.addEventListener('click', () => {
      resetFilters();
    });
  }

  if (mobileFilterBackdrop) {
    mobileFilterBackdrop.addEventListener('click', (e) => {
      if (e.target === mobileFilterBackdrop) closeMobileDrawer();
    });
  }

  // Handle browser back/forward history
  window.addEventListener('popstate', () => {
    loadStateFromUrl();
    filterTours();
  });

  // Initialize
  loadStateFromUrl();
  filterTours();
  updateWishlistIcons();
});
