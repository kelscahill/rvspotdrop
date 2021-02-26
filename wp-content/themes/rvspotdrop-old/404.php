<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package RVSpotDrop
 */

get_header(); ?>

<div class="container">
	<main id="maincontent" role="main">
		<div class="page-content">
	    	<h1><?php echo esc_html(get_theme_mod('rvspotdrop_404_page_title',__('404 Not Found','rvspotdrop')));?></h1>
			<p class="text-404"><?php echo esc_html(get_theme_mod('rvspotdrop_404_page_content',__('Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.','rvspotdrop')));?></p>
			<?php if( get_theme_mod('rvspotdrop_404_page_button_text','GO BACK') != ''){ ?>
				<div class="more-btn">
				    <a href="<?php echo esc_url(home_url()); ?>"><?php echo esc_html(get_theme_mod('rvspotdrop_404_page_button_text',__('GO BACK','rvspotdrop')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('rvspotdrop_404_page_button_text',__('GO BACK','rvspotdrop')));?></span></a>
				</div>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
	</main>
</div>

<?php get_footer(); ?>