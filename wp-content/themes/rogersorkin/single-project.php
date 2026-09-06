<?php
/**
 * The template for displaying a Single Project / Case Study
 */

get_header();

while ( have_posts() ) : the_post();
    $pid          = get_the_ID();
    $cat_pill     = rs_get_field( 'category_pill', $pid, 'STRATEGIC CASE STUDY' );
    $subtitle     = rs_get_field( 'hero_subtitle', $pid, get_the_excerpt() );
    $poster_img   = rs_get_field( 'poster_image', $pid, '' );
    $poster_path  = rs_get_field( 'poster_path', $pid, '' );
    if ( $poster_img ) {
        $poster_url = rs_image_url( $poster_img );
    } elseif ( $poster_path ) {
        $poster_url = rs_asset( $poster_path );
    } else {
        $poster_url = rs_asset( rs_get_project_fallback_poster( get_post_field( 'post_name', $pid ) ) );
    }

    // Snapshot facts
    $entity       = rs_get_field( 'snapshot_entity', $pid, rs_get_field( 'entity', $pid, 'American Resilience Project' ) );
    $director     = rs_get_field( 'snapshot_director', $pid, rs_get_field( 'director', $pid, 'Roger Sorkin' ) );
    $format       = rs_get_field( 'snapshot_format', $pid, rs_get_field( 'format', $pid, '' ) );
    $release      = rs_get_field( 'snapshot_release', $pid, rs_get_field( 'release', $pid, '' ) );
    $messengers   = rs_get_field( 'snapshot_messengers', $pid, rs_get_field( 'messengers', $pid, '' ) );
    $link_url     = rs_get_field( 'snapshot_link_url', $pid, rs_get_field( 'link_url', $pid, '' ) );
    $link_label   = rs_get_field( 'snapshot_link_label', $pid, rs_get_field( 'link_label', $pid, 'Watch the Full Film &rarr;' ) );

    // Content cards
    $purpose_h    = rs_get_field( 'purpose_heading', $pid, 'The Strategic Purpose & Core Thesis' );
    $purpose_c    = rs_get_field( 'purpose_content', $pid, get_the_content() );
    $impact_h     = rs_get_field( 'impact_heading', $pid, 'Documented Thought Leadership & Measurable Impact' );
    $impact_intro = rs_get_field( 'impact_intro', $pid, '' );
    $quote_text   = rs_get_field( 'quote_text', $pid, '' );
    $quote_cite   = rs_get_field( 'quote_cite', $pid, '' );
    $video_url    = rs_get_field( 'video_url', $pid, '' );
    $video_title  = rs_get_field( 'video_title', $pid, 'Watch ' . get_the_title() );
    $video_desc   = rs_get_field( 'video_desc', $pid, '' );
?>

  <main id="main-content">
    <!-- PAGE HERO BANNER -->
    <section class="page-hero-section case-study-hero">
      <div class="page-hero-orb" aria-hidden="true"></div>
      <div class="container page-hero-container">
        
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="breadcrumb-link">Home</a>
          <span class="breadcrumb-sep">/</span>
          <a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="breadcrumb-link">Projects</a>
          <span class="breadcrumb-sep">/</span>
          <span class="breadcrumb-current" aria-current="page"><?php the_title(); ?></span>
        </nav>

        <div class="pill-badge-hero">
          <span class="live-pulse"></span>
          <span class="badge-text"><?php echo esc_html( $cat_pill ); ?></span>
        </div>

        <h1 class="page-hero-title">
          <?php the_title(); ?>
        </h1>

        <?php if ( $subtitle ) : ?>
          <p class="page-hero-subtitle">
            <?php echo esc_html( $subtitle ); ?>
          </p>
        <?php endif; ?>

        <!-- Stats Bar -->
        <div class="trust-bar">
          <?php
          $proj_stats = rs_get_stats( $pid, array(
              array( 'number' => 'Strategic Impact', 'label' => 'Documentary Production' ),
              array( 'number' => 'Bipartisan', 'label' => 'Coalition Alignment' ),
              array( 'number' => 'National Scope', 'label' => 'Policy Advancements' ),
          ) );
          foreach ( $proj_stats as $idx => $st ) {
              if ( $idx > 0 ) echo '<div class="trust-divider"></div>';
              echo '<div class="trust-item">';
              echo '<span class="trust-number">' . esc_html( $st['number'] ) . '</span>';
              echo '<span class="trust-label">' . esc_html( $st['label'] ) . '</span>';
              echo '</div>';
          }
          ?>
        </div>
      </div>
    </section>

    <!-- CASE STUDY SHOWCASE -->
    <section class="case-study-showcase-section">
      <div class="container">
        <div class="case-study-grid-split">
          
          <!-- Left Column: Uncropped Poster in Dark Mat Frame & Snapshot -->
          <aside class="case-poster-column">
            <div class="case-poster-mat">
              <img src="<?php echo esc_url( $poster_url ); ?>" alt="<?php the_title_attribute(); ?>" class="case-poster-img" width="540" height="720" decoding="async" loading="eager" />
            </div>

            <div class="case-quick-facts-box" style="width: 100%;">
              <h3 class="quick-facts-title">Strategic Snapshot</h3>
              <ul class="quick-facts-list">
                <?php if ( $entity ) : ?>
                  <li><span class="qf-label">Entity:</span> <span class="qf-val"><?php echo esc_html( $entity ); ?></span></li>
                <?php endif; ?>
                <?php if ( $director ) : ?>
                  <li><span class="qf-label">Director / Lead:</span> <span class="qf-val"><?php echo esc_html( $director ); ?></span></li>
                <?php endif; ?>
                <?php if ( $format ) : ?>
                  <li><span class="qf-label">Format:</span> <span class="qf-val"><?php echo esc_html( $format ); ?></span></li>
                <?php endif; ?>
                <?php if ( $release ) : ?>
                  <li><span class="qf-label">Release / Year:</span> <span class="qf-val"><?php echo esc_html( $release ); ?></span></li>
                <?php endif; ?>
                <?php if ( $messengers ) : ?>
                  <li><span class="qf-label">Messengers:</span> <span class="qf-val"><?php echo esc_html( $messengers ); ?></span></li>
                <?php endif; ?>
              </ul>

              <?php if ( $link_url ) : ?>
                <div style="width: 100%;">
                  <a href="<?php echo esc_url( $link_url ); ?>" target="_blank" rel="noopener" class="btn btn-primary btn-block glow-btn" style="width: 100%; text-align: center; margin-top: 14px;">
                    <?php echo esc_html( $link_label ); ?>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </aside>

          <!-- Right Column: Concise Editorial Narrative -->
          <div class="case-content-column">
            
            <!-- Strategic Purpose Card -->
            <?php if ( $purpose_c || $purpose_h ) : ?>
              <div class="case-brief-card">
                <span class="section-tag">STRATEGIC PURPOSE</span>
                <?php if ( $purpose_h ) : ?>
                  <h2 class="case-card-heading"><?php echo esc_html( $purpose_h ); ?></h2>
                <?php endif; ?>
                <div class="case-card-text">
                  <?php echo wp_kses_post( $purpose_c ); ?>
                </div>
              </div>
            <?php endif; ?>

            <!-- Documented Impact Card -->
            <?php
            $bullets = rs_get_bullets( $pid );
            if ( $impact_h || ! empty( $bullets ) ) :
            ?>
              <div class="case-brief-card">
                <span class="section-tag">DOCUMENTED IMPACT</span>
                <?php if ( $impact_h ) : ?>
                  <h2 class="case-card-heading"><?php echo esc_html( $impact_h ); ?></h2>
                <?php endif; ?>
                <?php if ( $impact_intro ) : ?>
                  <p class="case-card-text"><?php echo esc_html( $impact_intro ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $bullets ) ) : ?>
                  <ul class="case-bullets-list">
                    <?php foreach ( $bullets as $b ) : ?>
                      <li>
                        <span class="bullet-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span>
                        <span><strong><?php echo esc_html( $b['lead'] ); ?></strong> <?php echo esc_html( $b['text'] ); ?></span>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <!-- Awards & Recognition Card -->
            <?php
            $awards = rs_get_awards( $pid );
            if ( ! empty( $awards ) ) :
            ?>
              <div class="case-brief-card">
                <span class="section-tag">AWARDS &amp; RECOGNITION</span>
                <div class="awards-badge-grid">
                  <?php foreach ( $awards as $a ) : ?>
                    <div class="award-item">
                      <span class="award-title"><?php echo esc_html( $a['title'] ); ?></span>
                      <span class="award-event"><?php echo esc_html( $a['event'] ); ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>

            <!-- Callout Quote Banner -->
            <?php if ( $quote_text ) : ?>
              <div class="case-quote-banner" style="margin: 8px 0 0 0;">
                <p>&ldquo;<?php echo esc_html( $quote_text ); ?>&rdquo;</p>
                <?php if ( $quote_cite ) : ?>
                  <cite><?php echo esc_html( $quote_cite ); ?></cite>
                <?php endif; ?>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </section>

    <!-- OFFICIAL TRAILER / VIDEO SECTION -->
    <?php if ( $video_url ) : ?>
      <section class="section section-dark section-case-video">
        <div class="page-hero-orb" aria-hidden="true"></div>
        <div class="container" style="position: relative; z-index: 2; max-width: 960px;">
          <div class="text-center" style="margin-bottom: 28px;">
            <span class="section-tag" style="color: var(--color-teal-light);">OFFICIAL VIDEO</span>
            <h2 class="section-title-light"><?php echo esc_html( $video_title ); ?></h2>
            <?php if ( $video_desc ) : ?>
              <p class="story-p" style="color: var(--color-text-muted-light);">
                <?php echo esc_html( $video_desc ); ?>
              </p>
            <?php endif; ?>
          </div>

          <div class="case-video-container">
            <iframe 
              src="<?php echo esc_url( $video_url ); ?>" 
              title="<?php the_title_attribute(); ?> Video" 
              frameborder="0"
              allow="autoplay; fullscreen; picture-in-picture" 
              allowfullscreen>
            </iframe>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <!-- CASE STUDY PAGINATION & NAVIGATION -->
    <section class="case-pagination-bar">
      <div class="container">
        <div class="case-pagination-grid">
          <?php
          $prev_post = get_previous_post();
          $next_post = get_next_post();
          ?>
          <?php if ( $prev_post ) : ?>
            <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="case-nav-link">
              <span style="font-size: 1.3rem;">&larr;</span>
              <div>
                <span class="case-nav-dir">Previous Project</span>
                <div class="case-nav-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></div>
              </div>
            </a>
          <?php else: ?>
            <div></div>
          <?php endif; ?>

          <?php if ( $next_post ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="case-nav-link" style="text-align: right;">
              <div>
                <span class="case-nav-dir">Next Project</span>
                <div class="case-nav-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?> &rarr;</div>
              </div>
            </a>
          <?php else: ?>
            <div></div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- CONTACT SECTION -->
    <?php get_template_part( 'template-parts/contact-section', null, array( 'style' => 'dark' ) ); ?>
  </main>

<?php
endwhile;
get_footer();
