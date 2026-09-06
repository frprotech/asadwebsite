<?php
/**
 * The template for displaying the Blog Archive (Posts Page)
 */

get_header();
?>

  <main id="main-content">
    <!-- PAGE HERO BANNER -->
    <section class="page-hero-section">
      <div class="page-hero-orb" aria-hidden="true"></div>
      <div class="container page-hero-container">
        
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="breadcrumb-link">Home</a>
          <span class="breadcrumb-sep">/</span>
          <span class="breadcrumb-current" aria-current="page">Blog</span>
        </nav>

        <div class="pill-badge-hero">
          <span class="live-pulse"></span>
          <span class="badge-text">STRATEGIC COMMUNICATIONS &amp; ANALYSIS</span>
        </div>

        <h1 class="page-hero-title">
          Blog &amp; Strategic Insights
        </h1>

        <p class="page-hero-subtitle">
          Field notes, narrative strategy, and perspectives on clean energy, policy, and bipartisan communications by Roger Sorkin.
        </p>

      </div>
    </section>

    <!-- BLOG ARCHIVE SECTION -->
    <section class="blog-white-section">
      <div class="blog-white-container">
        <div class="posts-container has-blogs">
          <?php
          if ( have_posts() ) :
              while ( have_posts() ) : the_post();
                  $feat_path = get_post_meta( get_the_ID(), 'featured_image_path', true );
                  $img_src   = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : ( $feat_path ? rs_asset( $feat_path ) : rs_asset( 'blog/speaking-truth-to-the-mob.png' ) );
          ?>
            <a href="<?php the_permalink(); ?>" class="indiv-post">
              <div class="img-container">
                <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php the_title_attribute(); ?>" width="600" height="375" loading="lazy" />
              </div>
              <div class="post-info">
                <div class="date">
                  <span class="day"><?php echo get_the_date( 'd' ); ?></span>
                  <span class="y-m-container">
                    <span class="year"><?php echo get_the_date( 'Y' ); ?></span>
                    <span class="month"><?php echo get_the_date( 'F' ); ?></span>
                  </span>
                </div>
                <h2 class="title"><?php the_title(); ?></h2>
                <p class="desc">
                  <?php echo esc_html( get_the_excerpt() ); ?>
                </p>
                <span class="button">Read More &rarr;</span>
              </div>
            </a>
          <?php
              endwhile;
          else :
              echo '<p class="text-center">No posts found.</p>';
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
