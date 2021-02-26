<?php
/**
 * The template part for header
 *
 * @package RVSpotDrop 
 * @subpackage rvspotdrop
 * @since rvspotdrop 1.0
 */
?>

<div id="header" class="menubar">	
  <div class="toggle-nav mobile-menu">
    <button role="tab" onclick="rvspotdrop_menu_open_nav()" class="responsivetoggle"><i class="<?php echo esc_attr(get_theme_mod('rvspotdrop_res_menu_open_icon','fas fa-bars')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','rvspotdrop'); ?></span></button>
  </div>
  <div id="mySidenav" class="nav sidenav">
    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'rvspotdrop' ); ?>">
      <?php 
        if(has_nav_menu('primary')){
          wp_nav_menu( array( 
            'theme_location' => 'primary',
            'container_class' => 'main-menu clearfix' ,
            'menu_class' => 'clearfix',
            'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
            'fallback_cb' => 'wp_page_menu',
          ) ); 
        } else {
          wp_nav_menu( array( 
            'container_class' => 'main-menu clearfix' ,
            'menu_class' => 'clearfix',
            'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
            'fallback_cb' => 'wp_page_menu',
          ) ); 
        }
      ?>
      <a href="javascript:void(0)" class="closebtn mobile-menu" onclick="rvspotdrop_menu_close_nav()"><i class="<?php echo esc_attr(get_theme_mod('rvspotdrop_res_menu_close_icon','fas fa-times')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','rvspotdrop'); ?></span></a>
    </nav>
  </div>
</div>