<?php
/**
 * The template part for displaying grid post
 *
 * @package RVSpotDrop
 * @subpackage rvspotdrop
 * @since rvspotdrop 1.0
 */
?>

<div class="col-lg-4 col-md-6">
	<article id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
	    <div class="post-main-box">
	      	<div class="box-image">
	          	<?php 
		            if(has_post_thumbnail()) { 
		              the_post_thumbnail(); 
		            }
	          	?>
	        </div>
	        <h2 class="section-title"><a href="<?php the_permalink(); ?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
	        <div class="new-text">
	        	<p>
			        <?php $excerpt = get_the_excerpt(); echo esc_html( rvspotdrop_string_limit_words( $excerpt, esc_attr(get_theme_mod('rvspotdrop_excerpt_number','30')))); ?> <?php echo esc_html( get_theme_mod('rvspotdrop_excerpt_suffix','') ); ?>
	        	</p>
	        </div>
	        <?php if( get_theme_mod('rvspotdrop_button_text','READ MORE') != ''){ ?>
	          <div class="more-btn">
	            <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('rvspotdrop_button_text',__('READ MORE','rvspotdrop')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('rvspotdrop_button_text',__('READ MORE','rvspotdrop')));?></span></a>
	          </div>
	        <?php } ?>
	    </div>
	    <div class="clearfix"></div>
  	</article>
</div>