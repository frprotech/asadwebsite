  <!-- Full-Screen Interactive Video Reel Modal -->
  <dialog class="modal-dialog video-reel-dialog" id="reelModal">
    <div class="modal-content glass-dialog video-reel-content">
      <button class="modal-close" id="reelClose" aria-label="Close showreel">&times;</button>
      <h3 style="font-size: 1.5rem; color: #fff; margin-bottom: 16px;">Roger Sorkin: Strategic Showreel</h3>
      <div class="video-reel-container">
        <video controls class="reel-video" id="modalReelVideo">
          <source src="<?php echo rs_image_url( rs_get_option( 'showreel_video_url', 'hero/RS-website-banner-4.mp4' ), 'hero/RS-website-banner-4.mp4' ); ?>" type="video/mp4">
        </video>
      </div>
    </div>
  </dialog>

  <!-- Modern Agency Footer -->
  <footer class="footer-modern">
    <div class="footer-ambient-bg">
      <img src="<?php echo rs_asset( 'logo icon.svg' ); ?>" alt="" class="footer-watermark-logo" aria-hidden="true" width="400" height="400" loading="lazy" decoding="async" />
    </div>

    <div class="container">
      <div class="footer-grid">
        <!-- Col 1: Brand & Identity -->
        <div class="footer-col brand-col">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-brand-logo">
            <div class="brand-logo-wrap">
              <img src="<?php echo rs_asset( 'logo icon.svg' ); ?>" alt="Roger Sorkin Logo Icon" class="logo-icon-img" width="40" height="40" loading="lazy" decoding="async" />
              <div class="brand-logo-text">
                <span class="logo-name" style="font-size: 1.25rem;"><?php echo esc_html( rs_get_option( 'brand_name', 'ROGER SORKIN' ) ); ?></span>
                <span class="logo-tagline" style="font-size: 0.65rem;"><?php echo esc_html( rs_get_option( 'brand_tagline', 'STRATEGIC NARRATIVES' ) ); ?></span>
              </div>
            </div>
          </a>
          <p class="footer-brand-desc">
            <?php echo esc_html( rs_get_option( 'footer_desc', 'Translating complex environmental, economic, and security challenges into bipartisan strategic narratives and attainable calls-to-action.' ) ); ?>
          </p>
        </div>

        <!-- Col 2: Quick Links -->
        <div class="footer-col nav-col">
          <h5 class="footer-col-title">Quick Links</h5>
          <?php
          if ( has_nav_menu( 'footer' ) ) {
              wp_nav_menu( array(
                  'theme_location' => 'footer',
                  'container'      => false,
                  'menu_class'     => 'footer-nav-list',
                  'items_wrap'     => '<ul class="footer-nav-list">%3$s</ul>',
                  'fallback_cb'    => false,
              ) );
          } else {
          ?>
          <ul class="footer-nav-list">
            <li><a href="<?php echo esc_url( rs_get_option( 'amres_url', 'https://www.amresproject.org/' ) ); ?>" target="_blank" rel="noopener">American Resilience Project</a></li>
            <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
            <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a></li>
            <li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">Projects</a></li>
            <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a></li>
            <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
            <li><a href="<?php echo esc_url( rs_get_option( 'linkedin_url', 'https://www.linkedin.com/in/rogersorkin/' ) ); ?>" target="_blank" rel="noopener">LinkedIn</a></li>
          </ul>
          <?php } ?>
        </div>

        <!-- Col 3: Newsletter Signup -->
        <div class="footer-col newsletter-col">
          <h5 class="footer-col-title">Subscribe to My Newsletter</h5>
          <p class="newsletter-subtext">Get updates on strategic communications, narrative risk, and documentary film initiatives.</p>
          
          <form class="newsletter-modern-form" id="newsletterForm">
            <div class="newsletter-input-group">
              <input type="email" placeholder="Enter your email..." required class="newsletter-modern-input" />
              <button type="submit" class="btn btn-primary btn-sm glow-btn">Subscribe</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Bottom Copyright Bar -->
    <div class="footer-bottom-modern">
      <div class="container footer-bottom-grid">
        <p class="copyright-text">&copy; Copyright <?php echo date('Y'); ?> <?php echo esc_html( rs_get_option( 'brand_name', 'Roger Sorkin' ) ); ?>. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
