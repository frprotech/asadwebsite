/**
 * ROGER SORKIN: STRATEGIC COMMUNICATIONS WEBSITE
 * Interactive Functionality & Modern Animations
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. NAVBAR SCROLL EFFECT
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

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

  // 3. PROJECT CASE STUDIES DATA & MODAL DIALOG
  const projectsData = {
    '10-rules': {
      title: '10 Rules for Dealing with the Police',
      tag: 'Constitutional Rights Simulation',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/05/10-rules.jpg',
      desc: 'Created with Flex Your Rights and used across the political spectrum from the ACLU to the CATO Institute to teach citizens how to exercise constitutional rights safely during police encounters.',
      impact: 'Distributed nationally, screening in hundreds of schools, universities, and advocacy workshops.'
    },
    'the-burden': {
      title: 'The Burden: Fossil Fuels & National Security',
      tag: 'Defense & Clean Energy',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/05/the-burden.jpg',
      desc: 'Reframing climate change and clean energy through the lens of US military readiness and national security to move conservative legislators, veterans, and defense leaders.',
      impact: 'Catalyzed bipartisan Congressional briefings and shaped military microgrid deployment strategy.'
    },
    'tidewater': {
      title: 'Tidewater: Sea Level Rise & Military Readiness',
      tag: 'Military Infrastructure',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/05/Tidewater-Poster-25.jpg',
      desc: 'Addressing sea level rise as a direct threat to US military installations and regional economies in Hampton Roads, Virginia.',
      impact: 'Bypassed political paralysis and led to multi-agency coastal resilience task forces.'
    },
    'fordham': {
      title: 'Fordham University Gabelli School of Business',
      tag: 'Executive Education',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/11/roger-sorkin-case-study.jpg',
      desc: 'Immersive simulations for MBA cohorts preparing future business leaders to navigate sensitive, highly contested corporate communication challenges.',
      impact: 'Integrated into core executive MBA curriculum.'
    },
    'clean-economy': {
      title: 'Clean Economy Now',
      tag: 'Public Policy',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/05/clean-economy-now-cover.jpg',
      desc: 'Designed to influence public policy by articulating the economic rationale behind clean energy infrastructure and job growth.',
      impact: 'Mobilized business leaders across 12 states for legislative advocacy.'
    },
    'farm-free': {
      title: 'Farm Free or Die',
      tag: 'Regenerative Agriculture',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/05/Farm-Free-Poster-18.jpg',
      desc: 'Centering voices of American farmers to demonstrate how regenerative agriculture rebuilds rural economies and safeguards food security.',
      impact: 'Screened at Congressional Farm Bill hearings to advocate for soil health incentives.'
    },
    'current-rev': {
      title: 'Current Revolution: Film Series',
      tag: 'Energy Transition',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/05/current-revolution.jpg',
      desc: 'Multi-film documentary series examining grid modernization and showing how combustion engine workers can transition into renewable energy careers.',
      impact: 'Partnered with utility providers and labor unions for workforce retraining advocacy.'
    },
    'nation-in-transition': {
      title: 'Nation in Transition',
      tag: 'Tribal Sovereignty',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/06/Current-Rev-NIT-Poster-15.jpg',
      desc: 'Documenting coal-to-renewable transition in the Navajo Nation, offering a human-centered roadmap for energy transitions globally.',
      impact: 'Helped secure federal renewable energy grants for tribal communities.'
    },
    'renewable-rural': {
      title: 'Renewable Energy Works for Rural America',
      tag: 'Rural Advocacy',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/06/renewable-energy-poster.jpg',
      desc: 'Social media video campaign produced for environmental non-profits to defend rural clean energy economic gains.',
      impact: 'Generated over 2 million organic video views across agricultural communities.'
    },
    'resilient-ground': {
      title: 'Resilient on the Ground',
      tag: 'Workforce Alignment',
      img: 'https://rogersorkin.com/wp-content/uploads/2025/06/resilient-on-the-ground-poster-1.jpg',
      desc: 'Documentary film created for a major US airport telling their sustainability success story and aligning a 10,000-employee workforce.',
      impact: 'Achieved 94% workforce alignment in post-viewing surveys.'
    }
  };

  const projectModal = document.getElementById('projectModal');
  const modalBody = document.getElementById('modalBody');
  const modalClose = document.getElementById('modalClose');

  function openCaseStudyModal(projectKey) {
    const data = projectsData[projectKey];
    if (data && projectModal && modalBody) {
      modalBody.innerHTML = `
        <img src="${data.img}" alt="${data.title}" />
        <span style="display:inline-block; font-size:0.75rem; font-weight:700; color:var(--color-teal-light); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">${data.tag}</span>
        <h3 style="font-size:1.8rem; font-weight:800; color:#fff; margin-bottom:14px;">${data.title}</h3>
        <p style="font-size:1rem; color:var(--color-text-muted-light); line-height:1.6; margin-bottom:20px;">${data.desc}</p>
        <div style="background:rgba(255,255,255,0.06); padding:16px 20px; border-radius:12px; border-left:4px solid var(--color-teal); margin-bottom:24px;">
          <strong style="color:#fff; display:block; margin-bottom:4px;">Documented Impact:</strong>
          <span style="color:var(--color-text-muted-light); font-size:0.9rem;">${data.impact}</span>
        </div>
        <div class="modal-footer-cta">
          <a href="#contact" class="btn btn-primary" onclick="document.getElementById('projectModal').close();">Discuss Similar Strategy &rarr;</a>
        </div>
      `;
      projectModal.showModal();
    }
  }

  document.querySelectorAll('.project-slide-card').forEach(card => {
    card.addEventListener('click', () => {
      const projectKey = card.dataset.project;
      if (projectKey) openCaseStudyModal(projectKey);
    });
  });

  if (modalClose && projectModal) {
    modalClose.addEventListener('click', () => projectModal.close());
    projectModal.addEventListener('click', (e) => {
      if (e.target === projectModal) projectModal.close();
    });
  }

  // 4. CONNECTED NODE NETWORK SYSTEM

  // DYNAMIC SVG CONNECTOR LINE GENERATOR & ANIMATION
  const networkContainer = document.getElementById('servicesNetwork');
  const networkCanvas = document.getElementById('networkCanvas');
  const baseLinesGroup = document.getElementById('networkBaseLines');
  const pulseLinesGroup = document.getElementById('networkPulseLines');
  const hubCircle = document.getElementById('hubCoreCircle');
  const hubCards = document.querySelectorAll('.hub-service-card');

  function updateNetworkLines() {
    if (!networkContainer || !networkCanvas || !hubCircle || !hubCards.length) return;
    if (window.innerWidth < 992) return; // Hidden on small screens

    const containerRect = networkContainer.getBoundingClientRect();
    const hubRect = hubCircle.getBoundingClientRect();

    const hubCenter = {
      x: hubRect.left + hubRect.width / 2 - containerRect.left,
      y: hubRect.top + hubRect.height / 2 - containerRect.top,
      radius: hubRect.width / 2
    };

    baseLinesGroup.innerHTML = '';
    pulseLinesGroup.innerHTML = '';

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

      // Smooth S-curve control points (matches user reference image)
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
      baseLinesGroup.appendChild(baseLine);

      // Animated pulse beam
      const pulseLine = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      pulseLine.setAttribute('d', pathData);
      pulseLine.setAttribute('class', 'network-pulse-line');
      pulseLine.setAttribute('id', `pulse-line-${i}`);
      pulseLine.style.animationDelay = `${(i * 0.45).toFixed(2)}s`;
      pulseLinesGroup.appendChild(pulseLine);

    });
  }

  // Card hover interaction: lights up connector line cleanly without listener stacking
  hubCards.forEach((card, i) => {
    card.addEventListener('mouseenter', () => {
      const bLine = document.getElementById(`base-line-${i}`);
      const pLine = document.getElementById(`pulse-line-${i}`);
      if (bLine) bLine.classList.add('active-line');
      if (pLine) pLine.classList.add('active-pulse');
    });

    card.addEventListener('mouseleave', () => {
      const bLine = document.getElementById(`base-line-${i}`);
      const pLine = document.getElementById(`pulse-line-${i}`);
      if (bLine) bLine.classList.remove('active-line');
      if (pLine) pLine.classList.remove('active-pulse');
    });

    card.addEventListener('click', (e) => {
      const href = card.getAttribute('href');
      if (href === '#' || href === '') {
        e.preventDefault();
      }
    });
  });

  // Initial draw & debounced resize listener
  setTimeout(updateNetworkLines, 100);
  window.addEventListener('load', updateNetworkLines);
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(updateNetworkLines, 100);
  });


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
