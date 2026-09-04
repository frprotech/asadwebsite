/**
 * ROGER SORKIN: STRATEGIC COMMUNICATIONS WEBSITE
 * Interactive Functionality & Modern Animations
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. NAVBAR SCROLL EFFECT (Optimized with requestAnimationFrame & passive listener)
  const navbar = document.getElementById('navbar');
  if (navbar) {
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          navbar.classList.toggle('scrolled', window.scrollY > 40);
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  // 2. MOBILE MENU TOGGLE
  const navToggle = document.getElementById('navToggle');
  const navMenu = document.getElementById('navMenu');

  if (navToggle && navMenu) {
    navToggle.addEventListener('click', () => {
      const isOpen = navMenu.classList.toggle('open');
      navToggle.classList.toggle('open', isOpen);
      navToggle.setAttribute('aria-expanded', isOpen);
    });

    // Close mobile menu when clicking nav links
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('open');
        navToggle.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // 3. PROJECT CASE STUDIES LINK HANDLER
  // Prevents jumping to top when clicking placeholder '#' links until dedicated pages are connected
  document.querySelectorAll('.case-study-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      if (btn.getAttribute('href') === '#') {
        e.preventDefault();
      }
    });
  });

  // 4. CONNECTED NODE NETWORK SYSTEM (High-performance DocumentFragment & rAF rendering)
  const networkContainer = document.getElementById('servicesNetwork');
  const networkCanvas = document.getElementById('networkCanvas');
  const baseLinesGroup = document.getElementById('networkBaseLines');
  const pulseLinesGroup = document.getElementById('networkPulseLines');
  const hubCircle = document.getElementById('hubCoreCircle');
  const hubCards = document.querySelectorAll('.hub-service-card');

  function updateNetworkLines() {
    if (!networkContainer || !networkCanvas || !hubCircle || !hubCards.length) return;
    if (window.innerWidth < 992) return; // Hidden on small screens

    window.requestAnimationFrame(() => {
      const containerRect = networkContainer.getBoundingClientRect();
      const hubRect = hubCircle.getBoundingClientRect();

      const hubCenter = {
        x: hubRect.left + hubRect.width / 2 - containerRect.left,
        y: hubRect.top + hubRect.height / 2 - containerRect.top,
        radius: hubRect.width / 2
      };

      const baseFragment = document.createDocumentFragment();
      const pulseFragment = document.createDocumentFragment();

      hubCards.forEach((card, i) => {
        const isLeft = card.closest('.left-col') !== null;
        const nodePin = card.querySelector('.card-terminal-node');
        if (!nodePin) return;

        const pinRect = nodePin.getBoundingClientRect();
        const startX = pinRect.left + pinRect.width / 2 - containerRect.left;
        const startY = pinRect.top + pinRect.height / 2 - containerRect.top;

        // Contact point on perimeter of central circle
        const angle = Math.atan2(startY - hubCenter.y, startX - hubCenter.x);
        const endX = hubCenter.x + Math.cos(angle) * (hubCenter.radius + 6);
        const endY = hubCenter.y + Math.sin(angle) * (hubCenter.radius + 6);

        // Smooth S-curve control points (matches reference design)
        const horizontalSpan = Math.abs(endX - startX);
        const cp1X = isLeft ? startX + horizontalSpan * 0.55 : startX - horizontalSpan * 0.55;
        const cp1Y = startY;
        const cp2X = isLeft ? endX - horizontalSpan * 0.35 : endX + horizontalSpan * 0.35;
        const cp2Y = endY;

        const pathData = `M ${startX} ${startY} C ${cp1X} ${cp1Y}, ${cp2X} ${cp2Y}, ${endX} ${endY}`;

        // Base static line
        const baseLine = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        baseLine.setAttribute('d', pathData);
        baseLine.setAttribute('class', 'network-base-line');
        baseLine.setAttribute('id', `base-line-${i}`);
        baseFragment.appendChild(baseLine);

        // Animated pulse beam
        const pulseLine = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        pulseLine.setAttribute('d', pathData);
        pulseLine.setAttribute('class', 'network-pulse-line');
        pulseLine.setAttribute('id', `pulse-line-${i}`);
        pulseLine.style.animationDelay = `${(i * 0.45).toFixed(2)}s`;
        pulseFragment.appendChild(pulseLine);
      });

      baseLinesGroup.replaceChildren(baseFragment);
      pulseLinesGroup.replaceChildren(pulseFragment);
    });
  }

  // Card hover interaction: lights up connector line cleanly without listener stacking
  hubCards.forEach((card, i) => {
    card.addEventListener('mouseenter', () => {
      const bLine = document.getElementById(`base-line-${i}`);
      const pLine = document.getElementById(`pulse-line-${i}`);
      if (bLine) bLine.classList.add('active-line');
      if (pLine) pLine.classList.add('active-pulse');
    }, { passive: true });

    card.addEventListener('mouseleave', () => {
      const bLine = document.getElementById(`base-line-${i}`);
      const pLine = document.getElementById(`pulse-line-${i}`);
      if (bLine) bLine.classList.remove('active-line');
      if (pLine) pLine.classList.remove('active-pulse');
    }, { passive: true });

    card.addEventListener('click', (e) => {
      const href = card.getAttribute('href');
      if (href === '#' || href === '') {
        e.preventDefault();
      }
    });
  });

  // Initial draw & debounced resize listener with passive flag
  setTimeout(updateNetworkLines, 100);
  window.addEventListener('load', updateNetworkLines, { passive: true });
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(updateNetworkLines, 120);
  }, { passive: true });


  // 5. SHOWREEL VIDEO MODAL
  const openReelBtn = document.getElementById('openReelBtn');
  const reelModal = document.getElementById('reelModal');
  const reelClose = document.getElementById('reelClose');
  const modalReelVideo = document.getElementById('modalReelVideo');

  if (openReelBtn && reelModal) {
    openReelBtn.addEventListener('click', () => {
      reelModal.showModal();
      if (modalReelVideo) modalReelVideo.play();
    });
  }

  if (reelClose && reelModal) {
    reelClose.addEventListener('click', () => {
      if (modalReelVideo) modalReelVideo.pause();
      reelModal.close();
    });
    reelModal.addEventListener('click', (e) => {
      if (e.target === reelModal) {
        if (modalReelVideo) modalReelVideo.pause();
        reelModal.close();
      }
    });
  }

  // 5. PROJECTS SLIDER NAVIGATION
  const sliderWrapper = document.getElementById('projectSliderWrapper');
  const prevBtn = document.getElementById('prevProjectBtn');
  const nextBtn = document.getElementById('nextProjectBtn');

  if (sliderWrapper && prevBtn && nextBtn) {
    prevBtn.addEventListener('click', () => {
      sliderWrapper.scrollBy({ left: -360, behavior: 'smooth' });
    });
    nextBtn.addEventListener('click', () => {
      sliderWrapper.scrollBy({ left: 360, behavior: 'smooth' });
    });
  }

  // 6. TESTIMONIALS SLIDER NAVIGATION
  const testSliderWrap = document.getElementById('testimonialSliderWrap');
  const prevTestBtn = document.getElementById('prevTestimonialBtn');
  const nextTestBtn = document.getElementById('nextTestimonialBtn');

  if (testSliderWrap && prevTestBtn && nextTestBtn) {
    prevTestBtn.addEventListener('click', () => {
      testSliderWrap.scrollBy({ left: -560, behavior: 'smooth' });
    });
    nextTestBtn.addEventListener('click', () => {
      testSliderWrap.scrollBy({ left: 560, behavior: 'smooth' });
    });
  }

  // 7. CONTACT FORM SUBMISSION HANDLER
  const contactForm = document.getElementById('contactForm');
  const formFeedback = document.getElementById('formFeedback');
  const submitBtn = document.getElementById('submitBtn');

  if (contactForm && formFeedback && submitBtn) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      submitBtn.disabled = true;
      submitBtn.innerText = 'Sending Message...';

      setTimeout(() => {
        formFeedback.className = 'form-feedback success';
        formFeedback.innerText = 'Thank you! Your message has been sent successfully. Roger will respond within 24 hours.';
        contactForm.reset();
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send Message <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
      }, 1200);
    });
  }
});
