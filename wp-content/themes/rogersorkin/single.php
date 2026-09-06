<?php
/**
 * The template for displaying all single posts
 */

get_header();

while ( have_posts() ) : the_post();
    $feat_path = get_post_meta( get_the_ID(), 'featured_image_path', true );
    $img_src   = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : ( $feat_path ? rs_asset( $feat_path ) : rs_asset( 'blog/speaking-truth-to-the-mob.png' ) );
?>

  <main id="main-content">
    <!-- PAGE HERO BANNER -->
    <section class="page-hero-section">
      <div class="page-hero-orb" aria-hidden="true"></div>
      <div class="container page-hero-container">
        
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="breadcrumb-link">Home</a>
          <span class="breadcrumb-sep">/</span>
          <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="breadcrumb-link">Blog</a>
          <span class="breadcrumb-sep">/</span>
          <span class="breadcrumb-current" aria-current="page"><?php the_title(); ?></span>
        </nav>

        <h1 class="page-hero-title">
          <?php the_title(); ?>
        </h1>

        <div class="page-hero-byline">
          <span class="byline-author">Roger Sorkin</span>
          <span class="byline-sep">|</span>
          <span class="byline-date"><?php echo get_the_date( 'F j, Y' ); ?></span>
        </div>

      </div>
    </section>

    <!-- ARTICLE CONTENT SECTION -->
    <article class="single-post-section">
      <div class="single-post-container">

        <!-- Featured Image -->
        <?php if ( $img_src ) : ?>
          <div class="single-post-hero-wrap">
            <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php the_title_attribute(); ?>" width="1568" height="882" loading="eager" />
          </div>
        <?php endif; ?>

        <!-- Article Prose -->
        <div class="single-post-content">
          <?php the_content(); ?>
        </div>

        <!-- About the Author Box -->
        <div class="about-author-improved">
          <div class="author-profile-col">
            <div class="author-avatar-wrap">
              <img src="<?php echo rs_asset( 'profile/roger-sorkin-author-navy.png' ); ?>" alt="Roger Sorkin" width="130" height="130" loading="lazy" />
            </div>
          </div>
          <div class="author-bio-col">
            <div class="author-meta-header">
              <span class="author-tag">ABOUT THE AUTHOR</span>
              <h2 class="author-name">Roger Sorkin</h2>
              <p class="author-title-sub">Filmmaker &amp; Narrative Strategist &bull; Executive Director, ARP</p>
            </div>
            <p class="author-bio-text">
              I'm a strategic communications expert and award-winning documentary filmmaker with over 30 years of experience helping organizations develop narratives that connect with diverse audiences and drive meaningful action. I work across climate, defense, energy, infrastructure, food security, and beyond, drawing on the storytelling techniques I've honed through producing content for a wide range of corporate, academic, NGO and government clients.
            </p>
            <div class="author-cta-box-row">
              <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-primary glow-btn author-work-btn">
                Work With Roger &rarr;
              </a>
              <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="author-more-link">
                View Full Background &rarr;
              </a>
            </div>
          </div>
        </div>

      </div>
    </article>

    <!-- POST NAVIGATION -->
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
                <span class="case-nav-dir">Previous Article</span>
                <div class="case-nav-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></div>
              </div>
            </a>
          <?php else: ?>
            <div></div>
          <?php endif; ?>

          <?php if ( $next_post ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="case-nav-link" style="text-align: right;">
              <div>
                <span class="case-nav-dir">Next Article</span>
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
