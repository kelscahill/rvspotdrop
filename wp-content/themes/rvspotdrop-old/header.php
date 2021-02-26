<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content-vw">
 *
 * @package RVSpotDrop
 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>
	  	<meta charset="<?php bloginfo( 'charset' ); ?>">
	  	<meta name="viewport" content="width=device-width">
	  	<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
	<?php if ( function_exists( 'wp_body_open' ) )
		{
	    	wp_body_open();
	  	}else{
	    	do_action('wp_body_open');
	  	}
	?>

	<header role="banner">
		<a class="screen-reader-text skip-link" href="#maincontent" ><?php esc_html_e( 'Skip to content', 'rvspotdrop' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Skip to content', 'rvspotdrop' ); ?></span></a>
		<div class="home-page-header">
			<?php get_template_part('template-parts/header/middle-header'); ?>
		</div>
	</header>

<?php 
if ( is_front_page() ) {   
// echo do_shortcode('[metaslider id="876"]');
?>
	<div style="display: block; width: 100%; position: relative;" class="caption_view">

<div class="caption-wrap" style="background-image: url(https://rvspotdrop.com/wp-content/uploads/2020/09/mikell-darling-x6yBJhwphTw-unsplash-1-scaled-1920x500.jpg);background-position: center;
    background-attachment: scroll;
    background-size: cover;">
<div style="background: #00000099;">
<div class="caption container">

<span>No Spot? No Problem!</span><br><br>
We find last minute &amp; unsold<br>
sites at the most popular<br>
RV campgrounds &amp; resorts<br>
<a href="#join_link" class="banner-btn-p">Join Now</a>
</div>
</div>
</div>
</div>	
<?php } ?>



	<?php if(get_theme_mod('rvspotdrop_loader_enable',true)==1){ ?>
	  	<div id="preloader">
		    <div id="status">
		      <?php $rvspotdrop_theme_lay = get_theme_mod( 'rvspotdrop_loader_icon','Two Way');
		        if($rvspotdrop_theme_lay == 'Two Way'){ ?>
		        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/two-way.gif" alt="" role="img"/>
		      <?php }else if($rvspotdrop_theme_lay == 'Dots'){ ?>
		        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/dots.gif" alt="" role="img"/>
		      <?php }else if($rvspotdrop_theme_lay == 'Rotate'){ ?>
		        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/rotate.gif" alt="" role="img"/>          
		      <?php } ?>
		    </div>
	  	</div>
	<?php } ?>