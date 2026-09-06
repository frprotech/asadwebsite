<?php
/**
 * Template Name: Projects Page
 * Also used for archive-project.php
 */

get_header();

$pid = is_page() ? get_the_ID() : ( get_page_by_path( 'projects' ) ? get_page_by_path( 'projects' )->ID : 9 );

$badge        = rs_get_field( 'hero_badge_text', $pid, 'DOCUMENTARY FILMS & EXECUTIVE SIMULATIONS' );
$title_line1  = rs_get_field( 'hero_title_line1', $pid, 'Strategic Narratives in Action:' );
$title_line2  = rs_get_field( 'hero_title_line2', $pid, 'Films, Campaigns & Case Studies' );
$subtitle     = rs_get_field( 'hero_subtitle', $pid, 'Explore how Roger Sorkin uses ethnographic storytelling, trusted messengers, and cinematic production to reframe contentious issues, unite polarized audiences, and accelerate policy solutions.' );

$default_stats = array(
    array( 'number' => '11+', 'label' => 'Specialized Projects' ),
    array( 'number' => '30+', 'label' => 'Years Track Record' ),
    array( 'number' => 'Bipartisan', 'label' => 'Legislative Impact' ),
    array( 'number' => 'Global', 'label' => 'NATO & Defense Screenings' ),
);
$trust_stats = rs_get_stats( $pid, $default_stats );

// Creative Approach / Systemic Methodology fields
$meth_tag     = rs_get_field( 'methodology_tag', $pid, 'SYSTEMIC METHODOLOGY' );
$meth_title   = rs_get_field( 'methodology_title', $pid, 'My Creative Approach' );
$meth_story1  = rs_get_field( 'methodology_story1', $pid, "When I heard a combat veteran describe losing his friend to a fuel convoy attack in Iraq, I recognized a powerful untold story: how our military's dependence on fossil fuels was costing lives and undermining national security." );
$meth_story2  = rs_get_field( 'methodology_story2', $pid, 'This insight became The Burden, a groundbreaking documentary that bridged unlikely allies: environmental advocates, defense conservatives, and military commanders: through a shared solution with different motivations. One policy wonk called it "a white paper disguised as a film": perhaps the greatest compliment possible for my approach.' );

$s1_badge     = rs_get_field( 'step_1_num', $pid, 'STEP 01' );
$s1_title     = rs_get_field( 'step_1_title', $pid, 'Identify Communication Gaps' );
$s1_text      = rs_get_field( 'step_1_text', $pid, 'Pinpoint precisely where public discourse and policy negotiations have stalled due to polarization or narrative fatigue.' );

$s2_badge     = rs_get_field( 'step_2_num', $pid, 'STEP 02' );
$s2_title     = rs_get_field( 'step_2_title', $pid, 'Deploy Trusted Messengers' );
$s2_text      = rs_get_field( 'step_2_text', $pid, 'Center authentic voices: veterans, farmers, engineers, and executives: who command respect from skeptical audiences.' );

$s3_badge     = rs_get_field( 'step_3_num', $pid, 'STEP 03' );
$s3_title     = rs_get_field( 'step_3_title', $pid, 'Provide Clear Calls to Action' );
$s3_text      = rs_get_field( 'step_3_text', $pid, 'Deliver attainable pathways that convert emotional resonance into durable legislative and institutional change.' );

$dir_photo_r  = rs_get_field( 'directing_photo', $pid );
$dir_photo_u  = $dir_photo_r ? rs_image_url( $dir_photo_r ) : rs_asset( 'about/roger-directing.webp' );
$dir_badge    = rs_get_field( 'directing_badge', $pid, 'ON LOCATION • DOCUMENTARY DIRECTING' );
$dir_quote    = rs_get_field( 'directing_quote_text', $pid, '"Each project is designed with specific outcomes in mind: a signal cutting through the noise to create measurable change."' );
$dir_author   = rs_get_field( 'directing_quote_author', $pid, 'Roger Sorkin • Founder & Director' );

$projects_query = new WP_Query( array(
    'post_type'      => 'project',
    'posts_per_page' => -1,
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
          <span class="breadcrumb-current" aria-current="page">Projects &amp; Case Studies</span>
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

        <!-- Stats Bar: 4 Credibility Anchors -->
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

    <!-- CLIENT LOGOS TICKER -->
    <?php get_template_part( 'template-parts/client-logos' ); ?>

    <!-- SYSTEMIC METHODOLOGY: 2-COLUMN BALANCED VISUAL LAYOUT -->
    <section class="section-creative-approach" id="methodology">
      <div class="container">
        <div class="approach-layout-split">
          
          <!-- Narrative & Process Column -->
          <div class="approach-text-col">
            <span class="section-tag"><?php echo esc_html( $meth_tag ); ?></span>
            <h2 class="section-title-dark" style="margin-bottom: 20px;"><?php echo esc_html( $meth_title ); ?></h2>
            
            <p class="story-p">
              <?php echo esc_html( $meth_story1 ); ?>
            </p>
            
            <p class="story-p">
              <?php echo esc_html( $meth_story2 ); ?>
            </p>

            <div class="approach-steps-list">
              <div class="approach-step-row">
                <span class="approach-step-badge"><?php echo esc_html( $s1_badge ); ?></span>
                <div class="approach-step-text">
                  <h4><?php echo esc_html( $s1_title ); ?></h4>
                  <p><?php echo esc_html( $s1_text ); ?></p>
                </div>
              </div>

              <div class="approach-step-row">
                <span class="approach-step-badge"><?php echo esc_html( $s2_badge ); ?></span>
                <div class="approach-step-text">
                  <h4><?php echo esc_html( $s2_title ); ?></h4>
                  <div class="approach-step-desc"><?php echo esc_html( $s2_text ); ?></div>
                </div>
              </div>

              <div class="approach-step-row">
                <span class="approach-step-badge"><?php echo esc_html( $s3_badge ); ?></span>
                <div class="approach-step-text">
                  <h4><?php echo esc_html( $s3_title ); ?></h4>
                  <p><?php echo esc_html( $s3_text ); ?></p>
                </div>
              </div>
            </div>

          </div>

          <!-- Visual Photo Column: Roger Directing in the Field -->
          <div class="approach-photo-col">
            <div class="approach-photo-frame">
              <img src="<?php echo esc_url( $dir_photo_u ); ?>" alt="Roger Sorkin directing on location with camera and crew" class="approach-photo-img" width="1400" height="933" decoding="async" loading="lazy" />
              <div class="approach-photo-badge">
                <span class="live-pulse"></span>
                <span><?php echo esc_html( $dir_badge ); ?></span>
              </div>
            </div>
            
            <div class="approach-quote-callout">
              <p class="quote-text">
                <?php echo esc_html( $dir_quote ); ?>
              </p>
              <span class="quote-author"><?php echo esc_html( $dir_author ); ?></span>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ALL 11 PROJECTS SHOWCASE (HOMEPAGE CARD PATTERN WITH UNCREPPED MAT FRAME) -->
    <section class="section-projects-showcase" id="portfolio">
      <div class="container">
        
        <div class="text-center" style="max-width: 820px; margin: 0 auto 52px auto;">
          <span class="section-tag">PORTFOLIO DIRECTORY</span>
          <h2 class="section-title-dark">All Projects &amp; Strategic Case Studies</h2>
          <p class="story-p" style="font-size: 1.08rem;">
            Explore documentary films, scenario simulations, and national communications campaigns engineered for measurable policy and behavioral impact.
          </p>
        </div>

        <!-- Projects Portfolio Grid (3 Columns Desktop, 2 Columns Tablet, 1 Column Mobile) -->
        <div class="projects-portfolio-grid" id="projectsGrid">
          <?php
          if ( $projects_query->have_posts() ) :
              while ( $projects_query->have_posts() ) : $projects_query->the_post();
                  $slug        = get_post_field( 'post_name', get_the_ID() );
                  $poster_path = rs_get_field( 'poster_path', get_the_ID(), '' );
                  $poster_img  = rs_get_field( 'poster_image', get_the_ID(), '' );
                  $default_art = rs_get_project_fallback_poster( $slug );
                  $img_src     = $poster_img ? rs_image_url( $poster_img ) : rs_asset( $poster_path ? $poster_path : $default_art );
                  $hover_tag   = rs_get_field( 'hover_tag', get_the_ID(), 'Case Study' );
                  $card_accent = rs_get_field( 'card_accent', get_the_ID(), 'Strategic Impact' );
                  $card_cta    = rs_get_field( 'card_cta_label', get_the_ID(), 'Case Study Details →' );
          ?>
            <article class="project-portfolio-card" data-project="<?php echo esc_attr( $slug ); ?>">
              <div class="poster-mat-frame">
                <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php the_title_attribute(); ?>" class="poster-uncropped" width="497" height="720" loading="lazy" />
                <div class="poster-hover-layer">
                  <div class="hover-details">
                    <span class="tag-pill"><?php echo esc_html( $hover_tag ); ?></span>
                    <h3 class="hover-heading"><?php the_title(); ?></h3>
                    <p class="hover-text"><?php echo esc_html( get_the_excerpt() ); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-light case-study-btn"><?php echo esc_html( $card_cta ); ?></a>
                  </div>
                </div>
              </div>
              <div class="portfolio-card-footer">
                <span class="tag-accent"><?php echo esc_html( $card_accent ); ?></span>
                <h3 class="portfolio-card-title"><?php the_title(); ?></h3>
                <a href="<?php the_permalink(); ?>" class="btn-card-action"><?php echo esc_html( $card_cta ); ?></a>
              </div>
            </article>
          <?php
              endwhile;
              wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </section>

    <!-- CONTACT SECTION -->
    <?php get_template_part( 'template-parts/contact-section', null, array( 'style' => 'dark' ) ); ?>
  </main>

<?php
get_footer();
