<?php
/**
 * Template Part: Testimonials Slider Component
 */

$testimonials_query = new WP_Query( array(
    'post_type'      => 'testimonial',
    'posts_per_page' => 10,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
?>
<section class="section section-light section-testimonials" id="testimonials">
  <div class="container">
    <div class="slider-header-row">
      <div>
        <span class="section-tag">TESTIMONIALS & ENDORSEMENTS</span>
        <h2 class="section-title-dark">Trusted by Leaders Across Sectors</h2>
      </div>
      <div class="slider-nav-controls">
        <button class="slider-arrow dark-arrow" id="prevTestimonialBtn" aria-label="Previous Testimonial">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </button>
        <button class="slider-arrow dark-arrow" id="nextTestimonialBtn" aria-label="Next Testimonial">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>

    <div class="testimonial-slider-wrapper" id="testimonialSliderWrap">
      <div class="testimonial-track" id="testimonialTrack">
        <?php
        if ( $testimonials_query->have_posts() ) :
            while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();
                $author_title = rs_get_field( 'author_title', get_the_ID(), '' );
        ?>
          <div class="testimonial-card">
            <div class="quote-icon-wrap">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="quote-svg-icon"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h3c0 4-2 6-4 7.5L3 21z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h3c0 4-2 6-4 7.5L15 21z"/></svg>
            </div>
            <p class="quote-text"><?php echo esc_html( get_the_content() ); ?></p>
            <div class="author-info-box">
              <h4 class="author-name"><?php the_title(); ?></h4>
              <?php if ( $author_title ) : ?>
                <span class="author-title"><?php echo esc_html( $author_title ); ?></span>
              <?php endif; ?>
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
