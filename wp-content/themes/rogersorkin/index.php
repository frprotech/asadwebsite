<?php
/**
 * The main template file
 */

get_header();
?>

  <main id="main-content" style="padding: 140px 0 80px 0;">
    <div class="container">
      <?php if ( have_posts() ) : ?>
        <header class="page-header" style="margin-bottom: 40px;">
          <h1 class="page-title"><?php single_post_title(); ?></h1>
        </header>

        <div class="content-area">
          <?php
          while ( have_posts() ) : the_post();
              the_content();
          endwhile;
          ?>
        </div>
      <?php else : ?>
        <p>No content found.</p>
      <?php endif; ?>
    </div>
  </main>

<?php
get_footer();
