<?php
/**
 * Template Name: Full Width
 */

get_header(); ?>
  
<div class="content-vw">
  <?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; // end of the loop. ?>
</div>

<?php get_footer(); ?>
