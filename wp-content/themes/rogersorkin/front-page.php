<?php
/**
 * Template Name: Homepage
 * The template for displaying the Front Page (Homepage)
 */

get_header();

// Hero Data
$hero_badge     = rs_get_field( 'hero_badge_text', get_the_ID(), 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM' );
$hero_line1     = rs_get_field( 'hero_title_line1', get_the_ID(), 'Turning narrative risk' );
$hero_line2     = rs_get_field( 'hero_title_line2', get_the_ID(), 'into strategic advantage.' );
$hero_subtitle  = rs_get_field( 'hero_subtitle', get_the_ID(), 'Translating complex environmental, economic, and security challenges into compelling, bipartisan strategic narratives and attainable calls-to-action.' );
$hero_cta_label = rs_get_field( 'hero_cta_primary_label', get_the_ID(), 'Book Strategy Session' );
$hero_cta_url   = rs_get_field( 'hero_cta_primary_url', get_the_ID(), home_url( '/contact/' ) );
$hero_reel_lbl  = rs_get_field( 'hero_cta_reel_label', get_the_ID(), 'Watch Showreel' );

$default_stats = array(
    array( 'number' => '30+', 'label' => 'Years Experience' ),
    array( 'number' => '10+', 'label' => 'Award Films' ),
    array( 'number' => 'Bipartisan', 'label' => 'Congressional Impact' ),
    array( 'number' => '10,000+', 'label' => 'Leaders Trained' ),
);
$trust_stats = rs_get_stats( get_the_ID(), $default_stats );
?>

  <main id="main-content">
    <!-- HERO SECTION -->
    <section class="hero-section" id="hero">
      <div class="hero-video-wrap">
        <video id="heroVideo" autoplay muted loop playsinline webkit-playsinline preload="metadata" poster="<?php echo rs_asset('hero/hp-bg.webp'); ?>" class="hero-video">
          <source src="<?php echo rs_asset('hero/RS-website-banner-4.mp4'); ?>" type="video/mp4">
        </video>
        <div class="hero-spotlight-orb"></div>
        <div class="hero-overlay"></div>
      </div>

      <div class="container hero-container">
        <div class="hero-content">
          <div class="pill-badge-hero">
            <span class="live-pulse"></span>
            <span class="badge-text"><?php echo esc_html( $hero_badge ); ?></span>
          </div>

          <h1 class="hero-title">
            <span class="hero-title-line"><?php echo esc_html( $hero_line1 ); ?></span>
            <span class="hero-title-line text-gradient"><?php echo esc_html( $hero_line2 ); ?></span>
          </h1>

          <p class="hero-subtitle">
            <?php echo esc_html( $hero_subtitle ); ?>
          </p>

          <div class="hero-ctas">
            <a href="<?php echo esc_url( $hero_cta_url ); ?>" class="btn btn-primary btn-lg glow-btn">
              <span><?php echo esc_html( $hero_cta_label ); ?></span>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            
            <button class="btn btn-glass btn-lg play-reel-btn" id="openReelBtn">
              <span class="play-icon-circle">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
              </span>
              <span><?php echo esc_html( $hero_reel_lbl ); ?></span>
            </button>
          </div>

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
      </div>
    </section>

    <!-- CLIENT LOGOS INFINITE CAROUSEL -->
    <?php get_template_part( 'template-parts/client-logos' ); ?>

    <!-- SERVICES CONNECTED NODE NETWORK SECTION -->
    <section class="section section-light section-services-hub" id="services">
      <div class="container">
        
        <div class="services-hub-header text-center">
          <span class="section-tag"><?php echo esc_html( rs_get_field( 'services_hub_tag', get_the_ID(), 'STRATEGIC COMMUNICATIONS SUITE' ) ); ?></span>
          <h2 class="services-hub-title"><?php echo esc_html( rs_get_field( 'services_hub_title', get_the_ID(), 'A Range of Services to Meet Your Communications Needs' ) ); ?></h2>
          <p class="services-hub-subtitle">
            <?php echo esc_html( rs_get_field( 'services_hub_subtitle', get_the_ID(), 'Connecting seasoned executive counsel, custom simulations, and impact storytelling to convert narrative risk into enduring advantage.' ) ); ?>
          </p>
        </div>

        <div class="services-interactive-network" id="servicesNetwork">
          <!-- Dynamic SVG Connector Canvas -->
          <svg class="services-network-canvas" id="networkCanvas" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
              <linearGradient id="lineGradLeft" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#558686" stop-opacity="0.35" />
                <stop offset="100%" stop-color="#558686" stop-opacity="0.9" />
              </linearGradient>
              <linearGradient id="lineGradRight" x1="100%" y1="0%" x2="0%" y2="0%">
                <stop offset="0%" stop-color="#558686" stop-opacity="0.35" />
                <stop offset="100%" stop-color="#558686" stop-opacity="0.9" />
              </linearGradient>
              <filter id="glowTeal" x="-30%" y="-30%" width="160%" height="160%">
                <feGaussianBlur stdDeviation="3.5" result="blur" />
                <feComposite in="SourceGraphic" in2="blur" operator="over" />
              </filter>
            </defs>
            <g class="network-base-lines" id="networkBaseLines"></g>
            <g class="network-pulse-lines" id="networkPulseLines"></g>
          </svg>

          <?php
          // Fetch services
          $services_query = new WP_Query( array(
              'post_type'      => 'service',
              'posts_per_page' => 8,
              'orderby'        => 'menu_order',
              'order'          => 'ASC',
          ) );

          $left_services = array();
          $right_services = array();

          if ( $services_query->have_posts() ) {
              $counter = 0;
              while ( $services_query->have_posts() ) {
                  $services_query->the_post();
                  $s_data = array(
                      'id'      => rs_get_field( 'anchor_id', get_the_ID(), get_post_field( 'post_name', get_the_ID() ) ),
                      'title'   => get_the_title(),
                      'tagline' => rs_get_field( 'tagline', get_the_ID(), '' ),
                      'index'   => $counter,
                  );
                  if ( $counter < 4 ) {
                      $left_services[] = $s_data;
                  } else {
                      $right_services[] = $s_data;
                  }
                  $counter++;
              }
              wp_reset_postdata();
          }

          // Fallback if not yet populated
          if ( empty( $left_services ) ) {
              $left_services = array(
                  array( 'id' => 'fractional-cco', 'title' => 'Fractional Communications Officer', 'tagline' => 'Seasoned C-suite vision, judgment, and crisis counsel.', 'index' => 0 ),
                  array( 'id' => 'audit', 'title' => 'Communications Audit', 'tagline' => 'On-site diagnostic identifying messaging friction at the root.', 'index' => 1 ),
                  array( 'id' => 'simulations', 'title' => 'Simulations and Role-Playing Training', 'tagline' => 'Safe scenario testing for boardrooms and hearings.', 'index' => 2 ),
                  array( 'id' => 'media-training', 'title' => 'Media Training', 'tagline' => 'Spokesperson interview readiness and soundbite craft.', 'index' => 3 ),
              );
              $right_services = array(
                  array( 'id' => 'coaching', 'title' => 'Executive Coaching', 'tagline' => '1-on-1 speechwriting and commanding delivery.', 'index' => 4 ),
                  array( 'id' => 'content-roadmap', 'title' => 'Content Roadmap', 'tagline' => 'In-house storytelling systems built to sustain.', 'index' => 5 ),
                  array( 'id' => 'podcast', 'title' => 'Podcast Production', 'tagline' => 'End-to-end series building weekly thought leadership.', 'index' => 6 ),
                  array( 'id' => 'filmmaking', 'title' => 'Impact Filmmaking', 'tagline' => 'Human documentaries built to convene lawmakers.', 'index' => 7 ),
              );
          }
          ?>

          <!-- Left Column: 4 Services -->
          <div class="services-cards-col left-col">
            <?php foreach ( $left_services as $s ) : ?>
              <a href="<?php echo esc_url( home_url( '/services/#' . $s['id'] ) ); ?>" class="hub-service-card" data-service="<?php echo esc_attr( $s['id'] ); ?>" data-index="<?php echo esc_attr( $s['index'] ); ?>">
                <div class="card-icon-box">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div class="card-text-box">
                  <h4 class="card-title"><?php echo esc_html( $s['title'] ); ?></h4>
                  <p class="card-tagline"><?php echo esc_html( $s['tagline'] ); ?></p>
                </div>
                <div class="card-terminal-node right-node" aria-hidden="true">
                  <span class="node-ring"></span>
                  <span class="node-core"></span>
                </div>
              </a>
            <?php endforeach; ?>
          </div>

          <!-- Center Hub with Clean Dark Circular Logo Icon -->
          <div class="services-hub-center" id="hubCenterAnchor">
            <div class="hub-core-circle" id="hubCoreCircle">
              <svg class="hub-center-logo" width="68" height="68" viewBox="0 0 683 683" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Roger Sorkin Logo">
                <path d="M272.407 28.4456C266.306 34.1348 261.425 41.043 257.358 47.9512H255.731C248.817 62.5804 234.174 72.7396 217.498 72.7396C204.483 72.7396 193.095 67.0504 185.367 58.1104C180.893 47.5448 174.385 38.1984 165.844 29.6647C128.018 -8.53369 66.6019 -8.53369 28.3694 29.6647C-9.45645 67.4568 -9.45645 128.818 28.3694 166.61C66.6019 204.809 128.018 204.809 165.844 166.61C176.826 155.638 184.553 143.041 189.027 129.224C196.348 122.723 206.11 118.253 217.092 118.253C232.954 118.253 247.19 127.599 254.104 141.009H254.511C258.985 149.543 265.086 158.076 272.407 165.391C279.321 172.299 286.642 177.582 294.37 182.052V183.271C307.792 190.179 317.147 204.402 317.147 220.25C317.147 235.286 309.013 248.29 297.624 255.604C288.676 260.074 280.135 266.17 272.814 273.484C234.988 311.276 234.988 373.044 272.814 410.836C310.639 448.628 372.056 448.628 410.288 410.836C420.05 400.677 427.371 388.892 432.251 376.701C439.979 368.168 450.961 362.885 463.163 362.885C476.585 362.885 488.38 368.98 495.701 378.733C500.582 389.705 507.496 400.271 516.444 409.211C523.359 416.119 531.087 421.402 538.815 425.872V426.278C552.237 433.186 561.591 447.409 561.591 463.257C561.591 479.512 552.237 493.329 538.815 500.643V501.049C531.087 505.52 523.766 510.802 517.258 517.304C479.025 555.503 479.025 616.864 517.258 654.656C555.084 692.448 616.5 692.448 654.326 654.656C692.558 616.864 692.558 555.503 654.326 517.304C645.378 508.364 634.803 501.456 623.414 496.986C613.653 489.265 607.145 477.074 607.145 463.664C607.145 447.816 616.093 433.999 629.108 427.091C630.193 426.549 631.142 426.007 631.955 425.465C639.683 421.402 647.411 415.713 653.919 409.211C691.745 371.419 691.745 310.057 653.919 271.859C645.784 264.138 636.836 257.636 627.075 253.166C615.686 245.852 607.958 232.848 607.958 218.219C607.958 206.434 612.839 196.275 620.16 188.554C632.362 183.678 644.157 176.769 653.919 166.61C691.745 128.818 691.745 67.4568 653.919 29.6647C616.093 -8.53369 554.27 -8.53369 516.444 29.6647C508.717 36.9793 503.022 45.513 498.142 54.8594C490.82 65.425 478.212 72.7396 463.976 72.7396C446.894 72.7396 432.251 62.5804 425.744 47.9512H424.93C420.863 41.043 415.982 34.1348 409.881 28.4456C390.765 9.34642 365.955 0 341.144 0C316.334 0 291.523 9.34642 272.407 28.4456ZM410.288 273.484C400.12 263.732 388.731 256.417 376.53 251.541C367.988 244.226 362.701 232.848 362.701 220.657C362.701 203.589 372.869 188.96 387.511 182.458V182.052C395.646 177.582 402.967 172.299 409.881 165.391C418.829 156.451 425.744 145.885 430.625 134.914C438.352 124.754 450.148 118.253 463.57 118.253C475.771 118.253 486.346 123.535 494.074 131.256C498.548 144.26 506.276 156.451 516.444 166.61C526.206 176.769 538.001 184.084 550.203 188.554C557.524 196.275 561.998 206.434 561.998 217.812C561.998 233.661 553.05 247.883 539.628 254.792C531.493 259.262 523.359 264.951 516.444 271.859C507.903 280.393 501.395 290.552 496.515 300.711C488.787 310.87 476.992 316.966 463.57 316.966C447.3 316.966 433.472 308.026 426.557 294.616H426.151C422.083 287.301 416.796 279.986 410.288 273.484Z" fill="url(#hubCenterLogoGrad)"/>
                <defs>
                  <linearGradient id="hubCenterLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#FFFFFF"/>
                    <stop offset="100%" stop-color="#A2D2D2"/>
                  </linearGradient>
                </defs>
              </svg>
            </div>
          </div>

          <!-- Right Column: 4 Services -->
          <div class="services-cards-col right-col">
            <?php foreach ( $right_services as $s ) : ?>
              <a href="<?php echo esc_url( home_url( '/services/#' . $s['id'] ) ); ?>" class="hub-service-card" data-service="<?php echo esc_attr( $s['id'] ); ?>" data-index="<?php echo esc_attr( $s['index'] ); ?>">
                <div class="card-icon-box">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/></svg>
                </div>
                <div class="card-text-box">
                  <h4 class="card-title"><?php echo esc_html( $s['title'] ); ?></h4>
                  <p class="card-tagline"><?php echo esc_html( $s['tagline'] ); ?></p>
                </div>
                <div class="card-terminal-node left-node" aria-hidden="true">
                  <span class="node-ring"></span>
                  <span class="node-core"></span>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="services-hub-footer text-center">
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary btn-lg glow-btn">
            <span>Discuss Your Communications Strategy</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>
    </section>

    <!-- SELECTED CASE STUDIES & PROJECTS PORTFOLIO SLIDER -->
    <section class="section section-dark section-projects" id="projects">
      <div class="container">
        <div class="slider-header-row">
          <div>
            <span class="section-tag"><?php echo esc_html( rs_get_field( 'projects_section_tag', get_the_ID(), 'SELECTED CASE STUDIES' ) ); ?></span>
            <h2 class="section-title-light"><?php echo esc_html( rs_get_field( 'projects_section_title', get_the_ID(), 'Strategic Narratives in Action' ) ); ?></h2>
            <p class="section-subtitle-light">
              <?php echo esc_html( rs_get_field( 'projects_section_subtitle', get_the_ID(), 'From reframing national security and agriculture to guiding executive leadership transitions, explore case studies that accomplished what facts alone could not.' ) ); ?>
            </p>
          </div>

          <div class="slider-nav-controls" style="display: flex; align-items: center; gap: 14px;">
            <a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="btn btn-outline-light btn-sm" style="padding: 8px 18px; font-size: 0.85rem;">View All Projects &rarr;</a>
            <button class="slider-arrow" id="prevProjectBtn" aria-label="Previous Slide">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </button>
            <button class="slider-arrow" id="nextProjectBtn" aria-label="Next Slide">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
          </div>
        </div>

        <div class="project-slider-wrapper" id="projectSliderWrapper">
          <div class="project-slider-track" id="projectSliderTrack">
            <?php
            $projects_slider = new WP_Query( array(
                'post_type'      => 'project',
                'posts_per_page' => 11,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ) );

            if ( $projects_slider->have_posts() ) :
                while ( $projects_slider->have_posts() ) : $projects_slider->the_post();
                    $slug        = get_post_field( 'post_name', get_the_ID() );
                    $poster_path = rs_get_field( 'poster_path', get_the_ID(), '' );
                    $poster_img  = rs_get_field( 'poster_image', get_the_ID(), '' );
                    $default_art = rs_get_project_fallback_poster( $slug );
                    $img_src     = $poster_img ? rs_image_url( $poster_img ) : rs_asset( $poster_path ? $poster_path : $default_art );
                    $hover_tag   = rs_get_field( 'hover_tag', get_the_ID(), 'Case Study' );
                    $card_accent = rs_get_field( 'card_accent', get_the_ID(), 'Strategic Impact' );
                    $card_cta    = rs_get_field( 'card_cta_label', get_the_ID(), 'Case Study Details →' );
            ?>
              <div class="project-slide-card" data-project="<?php echo esc_attr( $slug ); ?>">
                <div class="poster-mat-frame">
                  <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php the_title_attribute(); ?>" class="poster-uncropped" width="497" height="720" decoding="async" loading="lazy" />
                  <div class="poster-hover-layer">
                    <div class="hover-details">
                      <span class="tag-pill"><?php echo esc_html( $hover_tag ); ?></span>
                      <h3 class="hover-heading"><?php the_title(); ?></h3>
                      <p class="hover-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
                      <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-light case-study-btn"><?php echo esc_html( $card_cta ); ?></a>
                    </div>
                  </div>
                </div>
                <div class="slide-footer-info">
                  <span class="tag-accent"><?php echo esc_html( $card_accent ); ?></span>
                  <h4 class="slide-title"><?php the_title(); ?></h4>
                </div>
              </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
          </div>
        </div>
      </div>
    </section>

    <!-- CLEAN ELEGANT ABOUT ROGER SORKIN SECTION -->
    <?php
    $hp_ab_tag    = rs_get_field( 'hp_about_tag', get_the_ID(), 'ABOUT ROGER SORKIN' );
    $hp_ab_title  = rs_get_field( 'hp_about_title', get_the_ID(), '30 Years of Finding Common Ground Through Storytelling' );
    $hp_ab_lead   = rs_get_field( 'hp_about_lead', get_the_ID(), 'Spanning three decades across documentary filmmaking, investigative journalism, and non-partisan advocacy, Roger Sorkin transforms complex national challenges into unified human narratives.' );
    $hp_ab_body   = rs_get_field( 'hp_about_body', get_the_ID(), 'My background in anthropology and journalism taught me how to read room dynamics, cultivate authentic constituent voices, and uncover the shared values that bypass partisan skepticism. From producing daily public affairs broadcasts to screening original documentaries before Congressional committees, I help leaders build trust where traditional public relations fail.' );
    $hp_ab_f1_t   = rs_get_field( 'hp_about_feat1_title', get_the_ID(), 'Journalistic Rigor & Research' );
    $hp_ab_f1_d   = rs_get_field( 'hp_about_feat1_text', get_the_ID(), 'In-depth investigation yielding constituent narratives that command authority.' );
    $hp_ab_f2_t   = rs_get_field( 'hp_about_feat2_title', get_the_ID(), 'Bipartisan Coalition Building' );
    $hp_ab_f2_d   = rs_get_field( 'hp_about_feat2_text', get_the_ID(), 'Uniting business leaders, military veterans, lawmakers, and advocates.' );
    $hp_ab_cr1    = rs_get_field( 'hp_about_cred1_text', get_the_ID(), 'M.A. Communication (Stanford)' );
    $hp_ab_cr2    = rs_get_field( 'hp_about_cred2_text', get_the_ID(), 'Founder, American Resilience Project' );
    $hp_ab_cta1_l = rs_get_field( 'hp_about_cta1_label', get_the_ID(), 'Schedule Strategy Call →' );
    $hp_ab_cta1_u = rs_get_field( 'hp_about_cta1_url', get_the_ID(), '/contact/' );
    $hp_ab_cta2_l = rs_get_field( 'hp_about_cta2_label', get_the_ID(), 'Read Full Bio & Story →' );
    $hp_ab_cta2_u = rs_get_field( 'hp_about_cta2_url', get_the_ID(), '/about/' );
    $hp_ab_photo  = rs_get_field( 'hp_about_photo', get_the_ID() );
    $hp_ab_p_url  = $hp_ab_photo ? rs_image_url( $hp_ab_photo ) : rs_asset( 'profile/roger-sorkin-high-res-profile.webp' );
    ?>
    <section class="section section-light section-about" id="about">
      <div class="container">
        <div class="about-editorial-grid">
          
          <div class="about-image-column">
            <div class="portrait-pattern-backdrop"></div>
            <div class="portrait-card-frame-gradient">
              <img src="<?php echo rs_asset( 'logo icon.svg' ); ?>" alt="" class="portrait-logo-watermark" aria-hidden="true" />
              <img src="<?php echo esc_url( $hp_ab_p_url ); ?>" alt="Roger Sorkin Strategic Communications Specialist" class="portrait-img" width="720" height="883" decoding="async" />
            </div>
          </div>

          <div class="about-content-column">
            <span class="section-tag"><?php echo esc_html( $hp_ab_tag ); ?></span>
            <h2 class="section-title-dark"><?php echo esc_html( $hp_ab_title ); ?></h2>
            
            <p class="lead-text-dark">
              <?php echo esc_html( $hp_ab_lead ); ?>
            </p>

            <p class="body-text-dark">
              <?php echo esc_html( $hp_ab_body ); ?>
            </p>

            <div class="about-features-list">
              <div class="about-feature-item">
                <div class="feature-icon">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div>
                  <h4><?php echo esc_html( $hp_ab_f1_t ); ?></h4>
                  <p><?php echo esc_html( $hp_ab_f1_d ); ?></p>
                </div>
              </div>

              <div class="about-feature-item">
                <div class="feature-icon">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                  <h4><?php echo esc_html( $hp_ab_f2_t ); ?></h4>
                  <p><?php echo esc_html( $hp_ab_f2_d ); ?></p>
                </div>
              </div>
            </div>

            <div class="about-credentials-row">
              <?php if ( $hp_ab_cr1 ) : ?>
                <div class="credential-badge">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                  <span><?php echo esc_html( $hp_ab_cr1 ); ?></span>
                </div>
              <?php endif; ?>
              <?php if ( $hp_ab_cr2 ) : ?>
                <div class="credential-badge">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                  <span><?php echo esc_html( $hp_ab_cr2 ); ?></span>
                </div>
              <?php endif; ?>
            </div>

            <div class="about-action-row">
              <a href="<?php echo esc_url( home_url( $hp_ab_cta1_u ) ); ?>" class="btn btn-dark"><?php echo esc_html( $hp_ab_cta1_l ); ?></a>
              <a href="<?php echo esc_url( home_url( $hp_ab_cta2_u ) ); ?>" class="btn btn-outline-dark"><?php echo esc_html( $hp_ab_cta2_l ); ?></a>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- TESTIMONIALS SLIDER -->
    <?php get_template_part( 'template-parts/testimonials-slider' ); ?>

    <!-- CONTACT SECTION -->
    <?php get_template_part( 'template-parts/contact-section', null, array( 'style' => 'dark' ) ); ?>
  </main>

<?php
get_footer();
