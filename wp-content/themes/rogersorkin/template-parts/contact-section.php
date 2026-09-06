<?php
/**
 * Template Part: Contact Section Component
 * Accepts parameter $args['style'] => 'dark' (default) or 'light'
 */

$style = isset( $args['style'] ) ? $args['style'] : 'dark';
$is_light = ( $style === 'light' );
$sec_class = $is_light ? 'section section-light section-contact section-contact-light' : 'section section-dark section-contact';
$title_class = $is_light ? 'section-title-dark' : 'section-title-light';
$location = rs_get_option( 'contact_location', 'Washington, D.C. & Worldwide Projects' );
$linkedin = rs_get_option( 'linkedin_url', 'https://www.linkedin.com/in/rogersorkin/' );
$amres    = rs_get_option( 'amres_url', 'https://www.amresproject.org/' );
?>
<section class="<?php echo esc_attr( $sec_class ); ?>" id="contact">
  <div class="container">
    <div class="contact-grid">
      <div class="contact-info">
        <span class="section-tag">LET'S CONNECT</span>
        <h2 class="<?php echo esc_attr( $title_class ); ?>">Ready to Start Thinking About Your Communication Strategy?</h2>
        <p class="contact-desc">
          Whether you're preparing for a critical legislative push, navigating executive communication hurdles, or seeking to produce a high-impact documentary film, let's discuss how strategic narratives can turn your challenge into an advantage.
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
      </div>

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
