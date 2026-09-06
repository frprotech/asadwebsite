<?php
/**
 * Template Name: Contact Page
 */

get_header();

$pid          = get_the_ID();
$location     = rs_get_option( 'contact_location', 'Washington, D.C. & Worldwide Projects' );
$linkedin     = rs_get_option( 'linkedin_url', 'https://www.linkedin.com/in/rogersorkin/' );
$amres        = rs_get_option( 'amres_url', 'https://www.amresproject.org/' );

$badge        = rs_get_field( 'hero_badge_text', $pid, 'STRATEGIC ADVISORY • CONSULTATION INQUIRIES' );
$title_line1  = rs_get_field( 'hero_title_line1', $pid, "Let's Build Common Ground" );
$title_line2  = rs_get_field( 'hero_title_line2', $pid, 'Through High-Impact Storytelling' );
$subtitle     = rs_get_field( 'hero_subtitle', $pid, "Whether you are navigating executive communication hurdles, preparing a high-stakes legislative campaign, or commissioning an impact documentary, let's discuss how strategic narratives can turn your challenge into an advantage." );

$default_stats = array(
    array( 'number' => 'Global', 'label' => 'D.C. & Worldwide Projects' ),
    array( 'number' => '24-48h', 'label' => 'Direct Response Window' ),
    array( 'number' => '30 Min', 'label' => 'Initial Consultation' ),
    array( 'number' => '100%', 'label' => 'Strict Confidentiality' ),
);
$trust_stats = rs_get_stats( $pid, $default_stats );
?>

  <main id="main-content">
    <!-- PAGE HERO BANNER -->
    <section class="page-hero-section">
      <div class="page-hero-orb" aria-hidden="true"></div>
      <div class="container page-hero-container">
        
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="breadcrumb-link">Home</a>
          <span class="breadcrumb-sep">/</span>
          <span class="breadcrumb-current" aria-current="page">Contact Roger Sorkin</span>
        </nav>

        <div class="pill-badge-hero">
          <span class="live-pulse"></span>
          <span class="badge-text"><?php echo esc_html( $badge ); ?></span>
        </div>

        <h1 class="page-hero-title">
          <?php echo esc_html( $title_line1 ); ?><br class="hero-title-break">
          <span class="text-gradient"><?php echo esc_html( $title_line2 ); ?></span>
        </h1>

        <p class="page-hero-subtitle">
          <?php echo esc_html( $subtitle ); ?>
        </p>

        <div class="trust-bar">
          <?php foreach ( $trust_stats as $idx => $st ) : ?>
            <?php if ( $idx > 0 ) : ?><div class="trust-divider"></div><?php endif; ?>
            <div class="trust-item">
              <span class="trust-number"><?php echo esc_html( $st['number'] ); ?></span>
              <span class="trust-label"><?php echo esc_html( $st['label'] ); ?></span>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    </section>

    <!-- CONTACT FORM & DIRECT INQUIRIES SECTION -->
    <section class="section section-light section-contact section-contact-light" id="contact-section">
      <div class="container">
        <div class="contact-grid">
          
          <!-- Left Column: Direct Inquiries & Focus Areas -->
          <div class="contact-info">
            <span class="section-tag">START THE CONVERSATION</span>
            <h2 class="section-title-dark">Ready to Start Thinking About Your Communication Strategy?</h2>
            <p class="contact-desc">
              Every partnership begins with a direct, confidential dialogue. Roger works directly with executive leaders, policy architects, foundations, and advocacy teams to diagnose narrative risks and forge enduring consensus.
            </p>

            <div class="contact-details-list">
              <div class="contact-detail-row">
                <div class="detail-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <span><?php echo esc_html( $location ); ?></span>
              </div>
              <div class="contact-detail-row">
                <div class="detail-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                </div>
                <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener">Connect on LinkedIn &rarr;</a>
              </div>
              <div class="contact-detail-row">
                <div class="detail-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                </div>
                <a href="<?php echo esc_url( $amres ); ?>" target="_blank" rel="noopener">American Resilience Project &rarr;</a>
              </div>
            </div>

            <!-- Direct Capabilities Callout -->
            <div class="contact-capabilities-card" style="margin-top: 32px; background: #ffffff; border: 1px solid var(--color-border-light); border-radius: 12px; padding: 24px;">
              <h3 class="contact-capabilities-title" style="font-size: 1.1rem; color: var(--color-navy-dark); margin-bottom: 16px;">Primary Advisory Formats</h3>
              <div class="contact-capabilities-list" style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                <div class="contact-capability-item" style="display: flex; align-items: center; gap: 10px; font-size: 0.95rem; color: var(--color-text-body);">
                  <span class="contact-capability-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-teal);"></span>
                  <span>Fractional CCO Leadership</span>
                </div>
                <div class="contact-capability-item" style="display: flex; align-items: center; gap: 10px; font-size: 0.95rem; color: var(--color-text-body);">
                  <span class="contact-capability-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-teal);"></span>
                  <span>Executive Media Coaching</span>
                </div>
                <div class="contact-capability-item" style="display: flex; align-items: center; gap: 10px; font-size: 0.95rem; color: var(--color-text-body);">
                  <span class="contact-capability-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-teal);"></span>
                  <span>Narrative Risk Audits</span>
                </div>
                <div class="contact-capability-item" style="display: flex; align-items: center; gap: 10px; font-size: 0.95rem; color: var(--color-text-body);">
                  <span class="contact-capability-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--color-teal);"></span>
                  <span>Documentary Film Production</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column: Interactive Contact Form -->
          <div class="contact-form-wrap">
            <form class="contact-form" id="contactForm">
              <div class="form-row">
                <div class="form-group">
                  <label for="name">Name *</label>
                  <input type="text" id="name" name="name" required placeholder="Jane Doe" class="form-input" />
                </div>
                <div class="form-group">
                  <label for="email">Email *</label>
                  <input type="email" id="email" name="email" required placeholder="jane@organization.org" class="form-input" />
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="phone">Phone Number</label>
                  <input type="tel" id="phone" name="phone" placeholder="+1 (555) 000-0000" class="form-input" />
                </div>
                <div class="form-group">
                  <label for="organization">Organization</label>
                  <input type="text" id="organization" name="organization" placeholder="Global Resilience Initiative" class="form-input" />
                </div>
              </div>

              <div class="form-group">
                <label for="message">How Can Roger Help? *</label>
                <textarea id="message" name="message" rows="4" required placeholder="Tell us briefly about your communication challenge..." class="form-input"></textarea>
              </div>
              
              <button type="submit" class="btn btn-primary btn-block btn-lg glow-btn" id="submitBtn">
                Send Message
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
              </button>
              <div class="form-feedback" id="formFeedback"></div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();
