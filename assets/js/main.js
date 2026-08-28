/**
 * School of Law — shared front-end JavaScript.
 * Plain vanilla JS, no build step, no external libraries.
 * Loaded on every page via <script defer src="assets/js/main.js">.
 *
 * Every feature below guards against missing elements so this single file
 * can safely run on any page, whether or not that page has the markup
 * a given feature depends on.
 */

document.addEventListener('DOMContentLoaded', () => {
  initMobileNav();
  initActiveNavLink();
  initNewsCarousel();
  initNewsFilterTabs();
  initFormValidation();
});

/* -----------------------------------------------------------------------
 * 1. Mobile nav toggle
 * ---------------------------------------------------------------------*/
function initMobileNav() {
  const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');

  if (!navToggle || !navLinks) return;

  const openNav = () => {
    navLinks.classList.add('is-open');
    navToggle.setAttribute('aria-expanded', 'true');
  };

  const closeNav = () => {
    navLinks.classList.remove('is-open');
    navToggle.setAttribute('aria-expanded', 'false');
  };

  navToggle.addEventListener('click', (event) => {
    // Stop this click from also being seen by the document listener below,
    // which would immediately close the nav it just opened.
    event.stopPropagation();
    if (navLinks.classList.contains('is-open')) {
      closeNav();
    } else {
      openNav();
    }
  });

  // Close when clicking outside the open nav.
  document.addEventListener('click', (event) => {
    if (!navLinks.classList.contains('is-open')) return;
    if (navLinks.contains(event.target)) return;
    closeNav();
  });

  // Close after following a link (helpful on mobile, where the menu
  // otherwise stays open over the newly-loaded page).
  navLinks.addEventListener('click', (event) => {
    if (event.target.closest('a')) closeNav();
  });
}

/* -----------------------------------------------------------------------
 * 2. Active-nav-link highlighting
 * ---------------------------------------------------------------------*/
function initActiveNavLink() {
  const navLinks = document.getElementById('navLinks');
  const currentPage = document.body.getAttribute('data-page');

  if (!navLinks || !currentPage) return;

  const match = navLinks.querySelector(`[data-page="${currentPage}"]`);
  if (match) match.classList.add('active');
}

/* -----------------------------------------------------------------------
 * 3. Simple news carousel (home page)
 * ---------------------------------------------------------------------*/
function initNewsCarousel() {
  const carousel = document.getElementById('newsCarousel');
  if (!carousel) return;

  const track = carousel.querySelector('.carousel-track');
  const slides = carousel.querySelectorAll('.carousel-slide');
  const dots = carousel.querySelectorAll('.carousel-controls .carousel-dot');

  if (!track || slides.length === 0) return;

  let currentIndex = 0;
  let intervalId = null;

  const goToSlide = (index) => {
    currentIndex = index;
    track.style.transform = `translateX(-${100 * index}%)`;
    dots.forEach((dot, dotIndex) => {
      dot.classList.toggle('active', dotIndex === index);
    });
  };

  const goToNextSlide = () => {
    const nextIndex = (currentIndex + 1) % slides.length;
    goToSlide(nextIndex);
  };

  const startAutoAdvance = () => {
    stopAutoAdvance(); // never leak more than one interval
    intervalId = setInterval(goToNextSlide, 5000);
  };

  const stopAutoAdvance = () => {
    if (intervalId !== null) {
      clearInterval(intervalId);
      intervalId = null;
    }
  };

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => goToSlide(index));
  });

  carousel.addEventListener('mouseenter', stopAutoAdvance);
  carousel.addEventListener('mouseleave', startAutoAdvance);

  goToSlide(0);
  startAutoAdvance();
}

/* -----------------------------------------------------------------------
 * 4. News filter tabs (news.php) — progressive enhancement only.
 *    The page already filters via URL query params without JS; this just
 *    makes tab clicks instant, without a page reload.
 * ---------------------------------------------------------------------*/
function initNewsFilterTabs() {
  const tagList = document.querySelector('.tag-list');
  if (!tagList) return;

  const tabButtons = tagList.querySelectorAll('.tab-btn');
  const newsCards = document.querySelectorAll('.card-news');

  if (tabButtons.length === 0) return;

  tabButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
      // Tabs are real <a href="news.php?category=..."> links so the page
      // still works without JS; once JS is running, filter in place instead.
      event.preventDefault();

      tabButtons.forEach((btn) => btn.classList.remove('active'));
      button.classList.add('active');

      const filter = button.getAttribute('data-filter');

      newsCards.forEach((card) => {
        const matches = filter === 'all' || card.getAttribute('data-category') === filter;
        card.style.display = matches ? '' : 'none';
      });
    });
  });
}

/* -----------------------------------------------------------------------
 * 5. Shared form validation helper
 *    UX convenience only — NOT a security boundary. The server
 *    independently re-validates every field regardless of what happens
 *    here; this just gives the visitor faster, in-page feedback.
 * ---------------------------------------------------------------------*/
function validate(form) {
  const requiredFields = form.querySelectorAll('[required]');
  let isValid = true;

  requiredFields.forEach((field) => {
    const errorTarget = field.closest('.form-group') || field;
    const isEmpty = field.value.trim() === '';

    // Reuse an existing error message node if this field already has one.
    let errorMessage = errorTarget.querySelector('.form-error');

    if (isEmpty) {
      isValid = false;
      errorTarget.classList.add('has-error');

      if (!errorMessage) {
        errorMessage = document.createElement('small');
        errorMessage.className = 'form-error';
        errorMessage.textContent = 'This field is required.';
        errorTarget.appendChild(errorMessage);
      }
    } else {
      errorTarget.classList.remove('has-error');
      if (errorMessage) errorMessage.remove();
    }
  });

  return isValid;
}

function initFormValidation() {
  const forms = document.querySelectorAll('form');

  forms.forEach((form) => {
    const hasRequiredField = form.querySelector('[required]');
    if (!hasRequiredField) return;

    form.addEventListener('submit', (event) => {
      if (!validate(form)) {
        event.preventDefault();
      }
    });
  });
}
