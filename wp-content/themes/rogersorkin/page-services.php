<?php
/**
 * Template Name: Services Page
 */

get_header();

$pid          = get_the_ID();
$badge        = rs_get_field( 'hero_badge_text', $pid, 'STRATEGIC COMMUNICATIONS & DOCUMENTARY FILM' );
$title_line1  = rs_get_field( 'hero_title_line1', $pid, 'Turning narrative risk' );
$title_line2  = rs_get_field( 'hero_title_line2', $pid, 'into strategic advantage.' );
$subtitle     = rs_get_field( 'hero_subtitle', $pid, 'Connecting seasoned executive counsel, custom simulations, and impact storytelling to convert narrative risk into enduring advantage.' );

$default_stats = array(
    array( 'number' => '30+', 'label' => 'Years Experience' ),
    array( 'number' => '10+', 'label' => 'Award Films' ),
    array( 'number' => 'Bipartisan', 'label' => 'Congressional Impact' ),
    array( 'number' => '10,000+', 'label' => 'Leaders Trained' ),
);
$trust_stats = rs_get_stats( $pid, $default_stats );

$services_query = new WP_Query( array(
    'post_type'      => 'service',
    'posts_per_page' => 12,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>

  <main id="main-content">
    <!-- PAGE HERO BANNER -->
    <section class="page-hero-section">
      <div class="page-hero-orb" aria-hidden="true"></div>
      <div class="container page-hero-container">
        
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="breadcrumb-link">Home</a>
          <span class="breadcrumb-sep">/</span>
          <span class="breadcrumb-current" aria-current="page">Services</span>
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

    <!-- STICKY SERVICES SUBNAV PILLS -->
    <div class="services-nav-bar" id="servicesNavBar">
      <div class="container services-nav-container">
        <nav class="services-subnav" aria-label="Services Navigation">
          <a href="#fractional-cco" class="service-nav-pill active">Fractional CCO</a>
          <a href="#audit" class="service-nav-pill">Audit</a>
          <a href="#simulations" class="service-nav-pill">Simulations</a>
          <a href="#media-training" class="service-nav-pill">Media Training</a>
          <a href="#coaching" class="service-nav-pill">Coaching</a>
          <a href="#content-roadmap" class="service-nav-pill">Content Roadmap</a>
          <a href="#podcast" class="service-nav-pill">Podcast</a>
          <a href="#filmmaking" class="service-nav-pill">Filmmaking</a>
          <a href="#engagement-models" class="service-nav-pill">Engagement Models</a>
        </nav>
      </div>
    </div>

    <!-- DYNAMIC SERVICES LOOP -->
    <?php
    if ( $services_query->have_posts() ) :
        $index = 0;
        while ( $services_query->have_posts() ) : $services_query->the_post();
            $index++;
            $is_odd    = ( $index % 2 === 0 ); // Alternating layout
            $slug      = get_post_field( 'post_name', get_the_ID() );
            $anchor    = rs_get_field( 'anchor_id', get_the_ID(), $slug );
            $cap_tag   = rs_get_field( 'capability_tag', get_the_ID(), sprintf( 'CAPABILITY 0%d', $index ) );
            $line1     = rs_get_field( 'title_line1', get_the_ID(), get_the_title() );
            $line2     = rs_get_field( 'title_line2', get_the_ID(), '' );
            $lead      = rs_get_field( 'lead_text', get_the_ID(), '' );
            $body      = rs_get_field( 'body_text', get_the_ID(), '' );
            $deliv_t   = rs_get_field( 'deliverables_title', get_the_ID(), 'Core Capabilities & Deliverables' );
            $photo_p   = rs_get_field( 'photo_path', get_the_ID(), '' );
            $photo_img = rs_get_field( 'photo', get_the_ID(), '' );
            if ( ! $photo_img ) {
                $photo_img = rs_get_field( 'service_photo', get_the_ID(), '' );
            }
            $fallback  = rs_get_service_fallback_image( $slug );
            $img_url   = $photo_img ? rs_image_url( $photo_img ) : rs_asset( $photo_p ? $photo_p : $fallback );

            $bg_style = $is_odd ? 'section-light' : '';
            $custom_bg = ! $is_odd ? 'background: #ffffff; border-bottom: 1px solid var(--color-border-light);' : 'border-bottom: 1px solid var(--color-border-light);';
    ?>
      <section class="service-section <?php echo esc_attr( $bg_style ); ?>" id="<?php echo esc_attr( $anchor ); ?>" style="<?php echo esc_attr( $custom_bg ); ?>">
        <div class="container">
          <div class="chapter-grid <?php echo $is_odd ? 'reverse-layout' : ''; ?>">
            
            <?php if ( ! $is_odd ) : ?>
              <!-- Photo Left -->
              <div class="chapter-photo-col">
                <div class="photo-frame-offset">
                  <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" width="640" height="411" loading="lazy" decoding="async" style="aspect-ratio: 16/10; object-fit: cover; object-position: center;" />
                </div>
              </div>
            <?php endif; ?>

            <!-- Content Column -->
            <div class="chapter-content-col">
              <span class="section-tag"><?php echo esc_html( $cap_tag ); ?></span>
              <h2 class="section-title-dark chapter-heading-two-lines">
                <span class="heading-line"><?php echo esc_html( $line1 ); ?></span>
                <?php if ( $line2 ) : ?><span class="heading-line"><?php echo esc_html( $line2 ); ?></span><?php endif; ?>
              </h2>
              
              <?php if ( $lead ) : ?>
                <p class="lead-text-dark"><?php echo esc_html( $lead ); ?></p>
              <?php endif; ?>

              <?php if ( $body ) : ?>
                <p class="story-p"><?php echo esc_html( $body ); ?></p>
              <?php endif; ?>

              <div class="service-deliverables-box">
                <div class="deliverables-title">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                  <span><?php echo esc_html( $deliv_t ); ?></span>
                </div>
                <ul class="deliverables-list">
                  <?php
                  $deliv_items = rs_get_deliverables( get_the_ID() );
                  if ( ! empty( $deliv_items ) ) {
                      foreach ( $deliv_items as $item ) {
                          echo '<li class="deliverable-item">';
                          echo '<span class="deliverable-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span>';
                          echo '<span>' . esc_html( $item ) . '</span>';
                          echo '</li>';
                      }
                  }
                  ?>
                </ul>
              </div>

              <div class="service-action-row">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-dark">Engage Service &rarr;</a>
                <a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="btn btn-outline-dark">View Case Studies</a>
              </div>
            </div>

            <?php if ( $is_odd ) : ?>
              <!-- Photo Right -->
              <div class="chapter-photo-col">
                <div class="photo-frame-offset">
                  <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" width="640" height="411" loading="lazy" decoding="async" style="aspect-ratio: 16/10; object-fit: cover; object-position: center;" />
                </div>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </section>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <!-- ====================================================================
         HOW WE WORK: 3 ENGAGEMENT MODELS (1:1 Original HTML & Dynamic ACF)
         ==================================================================== -->
    <?php
    $m_tag       = rs_get_field( 'models_tag', $pid, 'COLLABORATION ARCHITECTURE' );
    $m_title     = rs_get_field( 'models_title', $pid, 'How Organizations Engage Roger Sorkin' );
    $m_sub       = rs_get_field( 'models_subtitle', $pid, "Three flexible, high-impact engagement models structured to fit your organization's timeline, governance requirements, and strategic stakes." );

    // Model 1
    $m1_badge    = rs_get_field( 'model_1_badge', $pid, 'MODEL 01 • ONGOING' );
    $m1_title    = rs_get_field( 'model_1_title', $pid, 'Advisory Retainer' );
    $m1_desc     = rs_get_field( 'model_1_desc', $pid, 'Ongoing fractional C-suite leadership and trusted counsel embedded directly alongside your executive team.' );
    $m1_feats    = rs_get_field( 'model_1_features', $pid, "Fractional Communications Officer role\nWeekly senior strategy & review calls\nCrisis preparedness & response standby\nDirect CEO & board advisory access" );
    $m1_btn_lbl  = rs_get_field( 'model_1_btn_label', $pid, 'Inquire About Retainer' );
    $m1_btn_url  = rs_get_field( 'model_1_btn_url', $pid, '/contact/' );

    // Model 2
    $m2_badge    = rs_get_field( 'model_2_badge', $pid, 'MODEL 02 • DIAGNOSTIC' );
    $m2_title    = rs_get_field( 'model_2_title', $pid, 'Focused Intensives' );
    $m2_desc     = rs_get_field( 'model_2_desc', $pid, 'Concentrated, time-boxed engagements that diagnose narrative friction or prepare teams for critical public events.' );
    $m2_feats    = rs_get_field( 'model_2_features', $pid, "Comprehensive Communications Audit\nCustom role-playing simulations (1-3 days)\nExecutive coaching prior to major hearings\nDetailed actionable findings report" );
    $m2_btn_lbl  = rs_get_field( 'model_2_btn_label', $pid, 'Schedule an Intensive' );
    $m2_btn_url  = rs_get_field( 'model_2_btn_url', $pid, '/contact/' );

    // Model 3
    $m3_badge    = rs_get_field( 'model_3_badge', $pid, 'MODEL 03 • PRODUCTION' );
    $m3_title    = rs_get_field( 'model_3_title', $pid, 'Creative Systems' );
    $m3_desc     = rs_get_field( 'model_3_desc', $pid, 'Full-cycle content infrastructure that convenes key decision-makers and establishes in-house production capability.' );
    $m3_feats    = rs_get_field( 'model_3_features', $pid, "Documentary film production & distribution\nContent Roadmap systems for in-house teams\nEnd-to-end podcast series production\nScreening tour convening policymakers" );
    $m3_btn_lbl  = rs_get_field( 'model_3_btn_label', $pid, 'Commission Creative' );
    $m3_btn_url  = rs_get_field( 'model_3_btn_url', $pid, '/contact/' );

    if ( ! function_exists( 'rs_render_model_features' ) ) {
        function rs_render_model_features( $features_text ) {
            $lines = preg_split( '/\r\n|\r|\n/', $features_text );
            foreach ( $lines as $line ) {
                $t = trim( $line );
                if ( ! empty( $t ) ) {
                    echo '<li class="engagement-feature-item">';
                    echo '<span class="engagement-feature-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span>';
                    echo '<span>' . esc_html( ltrim( $t, "-*• \t" ) ) . '</span>';
                    echo '</li>';
                }
            }
        }
    }
    ?>
    <section class="section-engagement-models section-light" id="engagement-models" style="background-color: #f8fafc;">
      <div class="container">
        <div class="text-center" style="max-width: 780px; margin: 0 auto;">
          <span class="section-tag"><?php echo esc_html( $m_tag ); ?></span>
          <h2 class="section-title-dark" style="margin-bottom: 16px; color: var(--color-navy);"><?php echo esc_html( $m_title ); ?></h2>
          <p class="story-p" style="font-size: 1.1rem; color: #475569;">
            <?php echo esc_html( $m_sub ); ?>
          </p>
        </div>

        <div class="engagement-cards-grid">
          
          <!-- Model 1: Advisory Retainer -->
          <div class="engagement-card">
            <div>
              <span class="engagement-tier-badge"><?php echo esc_html( $m1_badge ); ?></span>
              <h3 class="engagement-card-title"><?php echo esc_html( $m1_title ); ?></h3>
              <p class="engagement-card-desc">
                <?php echo esc_html( $m1_desc ); ?>
              </p>
              <ul class="engagement-card-features">
                <?php rs_render_model_features( $m1_feats ); ?>
              </ul>
            </div>
            <a href="<?php echo esc_url( home_url( $m1_btn_url ) ); ?>" class="btn btn-dark btn-block text-center" style="width: 100%;"><?php echo esc_html( $m1_btn_lbl ); ?></a>
          </div>

          <!-- Model 2: Focused Intensives (Highlighted with Teal Border) -->
          <div class="engagement-card" style="border-color: var(--color-teal); box-shadow: 0 16px 36px -12px rgba(85, 134, 134, 0.2);">
            <div>
              <span class="engagement-tier-badge" style="background: var(--color-teal); color: #ffffff;"><?php echo esc_html( $m2_badge ); ?></span>
              <h3 class="engagement-card-title"><?php echo esc_html( $m2_title ); ?></h3>
              <p class="engagement-card-desc">
                <?php echo esc_html( $m2_desc ); ?>
              </p>
              <ul class="engagement-card-features">
                <?php rs_render_model_features( $m2_feats ); ?>
              </ul>
            </div>
            <a href="<?php echo esc_url( home_url( $m2_btn_url ) ); ?>" class="btn btn-primary btn-block text-center" style="width: 100%;"><?php echo esc_html( $m2_btn_lbl ); ?></a>
          </div>

          <!-- Model 3: Creative Systems & Production -->
          <div class="engagement-card">
            <div>
              <span class="engagement-tier-badge"><?php echo esc_html( $m3_badge ); ?></span>
              <h3 class="engagement-card-title"><?php echo esc_html( $m3_title ); ?></h3>
              <p class="engagement-card-desc">
                <?php echo esc_html( $m3_desc ); ?>
              </p>
              <ul class="engagement-card-features">
                <?php rs_render_model_features( $m3_feats ); ?>
              </ul>
            </div>
            <a href="<?php echo esc_url( home_url( $m3_btn_url ) ); ?>" class="btn btn-dark btn-block text-center" style="width: 100%;"><?php echo esc_html( $m3_btn_lbl ); ?></a>
          </div>

        </div>
      </div>
    </section>

    <!-- CLIENT LOGOS -->
    <?php get_template_part( 'template-parts/client-logos' ); ?>

    <!-- CONTACT SECTION -->
    <?php get_template_part( 'template-parts/contact-section', null, array( 'style' => 'dark' ) ); ?>

  </main>

<?php
get_footer();
