<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <meta name="referrer" content="strict-origin-when-cross-origin" />

  <!-- Favicons -->
  <link rel="icon" type="image/x-icon" href="<?php echo rs_asset('icons/favicon.ico'); ?>" />
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo rs_asset('icons/favicon-32x32.png'); ?>" />
  <link rel="icon" type="image/png" sizes="192x192" href="<?php echo rs_asset('icons/icon-192x192.png'); ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo rs_asset('icons/apple-touch-icon.png'); ?>" />

  <?php wp_head(); ?>
</head>
<body <?php body_class('luxury-agency-theme'); ?>>
  <?php wp_body_open(); ?>
  
  <!-- Accessibility Skip Link -->
  <a class="skip-link" href="#main-content">Skip to Main Content</a>

  <!-- Modern Floating Header -->
  <header class="navbar" id="navbar">
    <div class="container nav-container">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-logo" aria-label="Roger Sorkin Homepage">
        <div class="brand-logo-wrap">
          <img src="<?php echo rs_asset( 'logo icon.svg' ); ?>" alt="Roger Sorkin Logo Icon" class="logo-icon-img" width="40" height="40" fetchpriority="high" />
          <div class="brand-logo-text">
            <span class="logo-name"><?php echo esc_html( rs_get_option( 'brand_name', 'ROGER SORKIN' ) ); ?></span>
            <span class="logo-tagline"><?php echo esc_html( rs_get_option( 'brand_tagline', 'STRATEGIC NARRATIVES' ) ); ?></span>
          </div>
        </div>
      </a>

      <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="nav-toggle-box">
          <span class="nav-toggle-bar"></span>
          <span class="nav-toggle-bar"></span>
          <span class="nav-toggle-bar"></span>
        </span>
      </button>

      <div class="nav-backdrop" id="navBackdrop" aria-hidden="true"></div>

      <nav class="nav-menu" id="navMenu">
        <?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-list',
                'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
                'fallback_cb'    => false,
            ) );
        } else {
        ?>
        <ul class="nav-list">
          <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="nav-link">About</a></li>
          <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="nav-link">Services</a></li>
          <li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="nav-link">Projects</a></li>
          <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="nav-link">Blog</a></li>
          <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="nav-link">Contact</a></li>
        </ul>
        <?php } ?>
        
        <div class="nav-actions">
          <a href="<?php echo esc_url( rs_get_option( 'header_cta_url', home_url( '/contact/' ) ) ); ?>" class="btn btn-primary btn-sm glow-btn">
            <?php echo esc_html( rs_get_option( 'header_cta_label', 'Work With Me' ) ); ?>
          </a>
        </div>
      </nav>
    </div>
  </header>
