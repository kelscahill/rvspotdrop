<?php

/*---------------------------First highlight color-------------------*/

	$rvspotdrop_first_color = get_theme_mod('rvspotdrop_first_color');

	$rvspotdrop_custom_css= "";

	if($rvspotdrop_first_color != false){
		$rvspotdrop_custom_css .='.read-btn a, .more-btn a,input[type="submit"],#sidebar h3,.search-box i,.scrollup i,#footer a.custom_read_more, #sidebar a.custom_read_more,#sidebar .custom-social-icons i, #footer .custom-social-icons i,.pagination span, .pagination a,#footer-2,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.widget_product_search button,#comments input[type="submit"],#comments a.comment-reply-link,#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon,nav.woocommerce-MyAccount-navigation ul li,.toggle-nav i, .woocommerce nav.woocommerce-pagination ul li a{';
			$rvspotdrop_custom_css .='background: '.esc_html($rvspotdrop_first_color).';';
		$rvspotdrop_custom_css .='}';
	}
	if($rvspotdrop_first_color != false){
		$rvspotdrop_custom_css .='a,.main-navigation a:hover,.main-navigation ul.sub-menu a:hover,.main-navigation .current_page_item > a, .main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a,#slider .inner_carousel h1,.heading-text p,#sidebar ul li a:hover,#footer li a:hover{';
			$rvspotdrop_custom_css .='color: '.esc_html($rvspotdrop_first_color).';';
		$rvspotdrop_custom_css .='}';
	}	
	if($rvspotdrop_first_color != false){
		$rvspotdrop_custom_css .='.main-navigation ul ul{';
			$rvspotdrop_custom_css .='border-color: '.esc_html($rvspotdrop_first_color).';';
		$rvspotdrop_custom_css .='}';
	}
	
	/*---------------------------second highlight color-------------------*/

	$rvspotdrop_second_color = get_theme_mod('rvspotdrop_second_color');

	if($rvspotdrop_second_color != false){
		$rvspotdrop_custom_css .='.read-btn a:hover, .more-btn a:hover,input[type="submit"]:hover,#sidebar a.custom_read_more:hover, #footer a.custom_read_more:hover,#sidebar .custom-social-icons i:hover, #footer .custom-social-icons i:hover,.pagination .current,.pagination a:hover,#sidebar .tagcloud a:hover,#footer .tagcloud a:hover,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current{';
			$rvspotdrop_custom_css .='background: '.esc_html($rvspotdrop_second_color).';';
		$rvspotdrop_custom_css .='}';
	}

	/*---------------------------Width Layout -------------------*/

	$rvspotdrop_theme_lay = get_theme_mod( 'rvspotdrop_width_option','Full Width');
    if($rvspotdrop_theme_lay == 'Boxed'){
		$rvspotdrop_custom_css .='body{';
			$rvspotdrop_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$rvspotdrop_custom_css .='}';
		$rvspotdrop_custom_css .='#slider{';
			$rvspotdrop_custom_css .='right: 1%;';
		$rvspotdrop_custom_css .='}';
	}else if($rvspotdrop_theme_lay == 'Wide Width'){
		$rvspotdrop_custom_css .='body{';
			$rvspotdrop_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$rvspotdrop_custom_css .='}';
	}else if($rvspotdrop_theme_lay == 'Full Width'){
		$rvspotdrop_custom_css .='body{';
			$rvspotdrop_custom_css .='max-width: 100%;';
		$rvspotdrop_custom_css .='}';
	}

	/*---------------------------Slider Content Layout -------------------*/

	$rvspotdrop_theme_lay = get_theme_mod( 'rvspotdrop_slider_content_option','Left');
    if($rvspotdrop_theme_lay == 'Left'){
		$rvspotdrop_custom_css .='#slider .carousel-caption{';
			$rvspotdrop_custom_css .='text-align:left;';
		$rvspotdrop_custom_css .='}';
	}else if($rvspotdrop_theme_lay == 'Center'){
		$rvspotdrop_custom_css .='#slider .carousel-caption{';
			$rvspotdrop_custom_css .='text-align:center;';
		$rvspotdrop_custom_css .='}';
	}else if($rvspotdrop_theme_lay == 'Right'){
		$rvspotdrop_custom_css .='#slider .carousel-caption{';
			$rvspotdrop_custom_css .='text-align:right;';
		$rvspotdrop_custom_css .='}';
	}

	/*---------------------------Blog Layout -------------------*/

	$rvspotdrop_theme_lay = get_theme_mod( 'rvspotdrop_blog_layout_option','Default');
    if($rvspotdrop_theme_lay == 'Default'){
		$rvspotdrop_custom_css .='.post-main-box{';
			$rvspotdrop_custom_css .='';
		$rvspotdrop_custom_css .='}';
	}else if($rvspotdrop_theme_lay == 'Center'){
		$rvspotdrop_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p{';
			$rvspotdrop_custom_css .='text-align:center;';
		$rvspotdrop_custom_css .='}';
		$rvspotdrop_custom_css .='.post-info{';
			$rvspotdrop_custom_css .='margin-top:10px;';
		$rvspotdrop_custom_css .='}';
	}else if($rvspotdrop_theme_lay == 'Left'){
		$rvspotdrop_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, #our-services p{';
			$rvspotdrop_custom_css .='text-align:Left;';
		$rvspotdrop_custom_css .='}';
		$rvspotdrop_custom_css .='.post-main-box h2{';
			$rvspotdrop_custom_css .='margin-top:10px;';
		$rvspotdrop_custom_css .='}';
	}

	/*----------------Responsive Media -----------------------*/

	$rvspotdrop_resp_stickyheader = get_theme_mod( 'rvspotdrop_stickyheader_hide_show',false);
	if($rvspotdrop_resp_stickyheader == true && get_theme_mod( 'rvspotdrop_sticky_header') == false){
		$rvspotdrop_custom_css .='.header-fixed{';
			$rvspotdrop_custom_css .='display:none;';
			$rvspotdrop_custom_css .='} ';
	}
	if($rvspotdrop_resp_stickyheader == true){
		$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
			$rvspotdrop_custom_css .='.header-fixed{';
				$rvspotdrop_custom_css .='display:block;';
			$rvspotdrop_custom_css .='} }';
	}else if($rvspotdrop_resp_stickyheader == false){
		$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
			$rvspotdrop_custom_css .='.header-fixed{';
				$rvspotdrop_custom_css .='display:none;';
			$rvspotdrop_custom_css .='} }';
	}

	$rvspotdrop_resp_slider = get_theme_mod( 'rvspotdrop_resp_slider_hide_show',false);
    if($rvspotdrop_resp_slider == true){
    	$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
		$rvspotdrop_custom_css .='#slider{';
			$rvspotdrop_custom_css .='display:block;';
		$rvspotdrop_custom_css .='} }';
	}else if($rvspotdrop_resp_slider == false){
		$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
		$rvspotdrop_custom_css .='#slider{';
			$rvspotdrop_custom_css .='display:none;';
		$rvspotdrop_custom_css .='} }';
	}

	$rvspotdrop_resp_metabox = get_theme_mod( 'rvspotdrop_metabox_hide_show',true);
    if($rvspotdrop_resp_metabox == true){
    	$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
		$rvspotdrop_custom_css .='.post-info{';
			$rvspotdrop_custom_css .='display:block;';
		$rvspotdrop_custom_css .='} }';
	}else if($rvspotdrop_resp_metabox == false){
		$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
		$rvspotdrop_custom_css .='.post-info{';
			$rvspotdrop_custom_css .='display:none;';
		$rvspotdrop_custom_css .='} }';
	}

	$rvspotdrop_resp_sidebar = get_theme_mod( 'rvspotdrop_sidebar_hide_show',true);
    if($rvspotdrop_resp_sidebar == true){
    	$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
		$rvspotdrop_custom_css .='#sidebar{';
			$rvspotdrop_custom_css .='display:block;';
		$rvspotdrop_custom_css .='} }';
	}else if($rvspotdrop_resp_sidebar == false){
		$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
		$rvspotdrop_custom_css .='#sidebar{';
			$rvspotdrop_custom_css .='display:none;';
		$rvspotdrop_custom_css .='} }';
	}

	$rvspotdrop_resp_scroll_top = get_theme_mod( 'rvspotdrop_resp_scroll_top_hide_show',false);
    if($rvspotdrop_resp_scroll_top == true){
    	$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
		$rvspotdrop_custom_css .='.scrollup i{';
			$rvspotdrop_custom_css .='display:block;';
		$rvspotdrop_custom_css .='} }';
	}else if($rvspotdrop_resp_scroll_top == false){
		$rvspotdrop_custom_css .='@media screen and (max-width:575px) {';
		$rvspotdrop_custom_css .='.scrollup i{';
			$rvspotdrop_custom_css .='display:none !important;';
		$rvspotdrop_custom_css .='} }';
	}

	/*-------------- Sticky Header Padding ----------------*/

	$rvspotdrop_sticky_header_padding = get_theme_mod('rvspotdrop_sticky_header_padding');
	if($rvspotdrop_sticky_header_padding != false){
		$rvspotdrop_custom_css .='.header-fixed, .page-template-custom-home-page .header-fixed{';
			$rvspotdrop_custom_css .='padding: '.esc_html($rvspotdrop_sticky_header_padding).';';
		$rvspotdrop_custom_css .='}';
	}

	/*---------------- Button Settings ------------------*/

	$rvspotdrop_button_padding_top_bottom = get_theme_mod('rvspotdrop_button_padding_top_bottom');
	$rvspotdrop_button_padding_left_right = get_theme_mod('rvspotdrop_button_padding_left_right');
	if($rvspotdrop_button_padding_top_bottom != false || $rvspotdrop_button_padding_left_right != false){
		$rvspotdrop_custom_css .='.post-main-box .more-btn a{';
			$rvspotdrop_custom_css .='padding-top: '.esc_html($rvspotdrop_button_padding_top_bottom).'; padding-bottom: '.esc_html($rvspotdrop_button_padding_top_bottom).';padding-left: '.esc_html($rvspotdrop_button_padding_left_right).';padding-right: '.esc_html($rvspotdrop_button_padding_left_right).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_button_border_radius = get_theme_mod('rvspotdrop_button_border_radius');
	if($rvspotdrop_button_border_radius != false){
		$rvspotdrop_custom_css .='.post-main-box .more-btn a{';
			$rvspotdrop_custom_css .='border-radius: '.esc_html($rvspotdrop_button_border_radius).'px;';
		$rvspotdrop_custom_css .='}';
	}

	/*-------------- Copyright Alignment ----------------*/

	$rvspotdrop_copyright_alingment = get_theme_mod('rvspotdrop_copyright_alingment');
	if($rvspotdrop_copyright_alingment != false){
		$rvspotdrop_custom_css .='.copyright p{';
			$rvspotdrop_custom_css .='text-align: '.esc_html($rvspotdrop_copyright_alingment).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_copyright_padding_top_bottom = get_theme_mod('rvspotdrop_copyright_padding_top_bottom');
	if($rvspotdrop_copyright_padding_top_bottom != false){
		$rvspotdrop_custom_css .='#footer-2{';
			$rvspotdrop_custom_css .='padding-top: '.esc_html($rvspotdrop_copyright_padding_top_bottom).'; padding-bottom: '.esc_html($rvspotdrop_copyright_padding_top_bottom).';';
		$rvspotdrop_custom_css .='}';
	}

	/*----------------Sroll to top Settings ------------------*/

	$rvspotdrop_scroll_to_top_font_size = get_theme_mod('rvspotdrop_scroll_to_top_font_size');
	if($rvspotdrop_scroll_to_top_font_size != false){
		$rvspotdrop_custom_css .='.scrollup i{';
			$rvspotdrop_custom_css .='font-size: '.esc_html($rvspotdrop_scroll_to_top_font_size).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_scroll_to_top_padding = get_theme_mod('rvspotdrop_scroll_to_top_padding');
	$rvspotdrop_scroll_to_top_padding = get_theme_mod('rvspotdrop_scroll_to_top_padding');
	if($rvspotdrop_scroll_to_top_padding != false){
		$rvspotdrop_custom_css .='.scrollup i{';
			$rvspotdrop_custom_css .='padding-top: '.esc_html($rvspotdrop_scroll_to_top_padding).';padding-bottom: '.esc_html($rvspotdrop_scroll_to_top_padding).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_scroll_to_top_width = get_theme_mod('rvspotdrop_scroll_to_top_width');
	if($rvspotdrop_scroll_to_top_width != false){
		$rvspotdrop_custom_css .='.scrollup i{';
			$rvspotdrop_custom_css .='width: '.esc_html($rvspotdrop_scroll_to_top_width).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_scroll_to_top_height = get_theme_mod('rvspotdrop_scroll_to_top_height');
	if($rvspotdrop_scroll_to_top_height != false){
		$rvspotdrop_custom_css .='.scrollup i{';
			$rvspotdrop_custom_css .='height: '.esc_html($rvspotdrop_scroll_to_top_height).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_scroll_to_top_border_radius = get_theme_mod('rvspotdrop_scroll_to_top_border_radius');
	if($rvspotdrop_scroll_to_top_border_radius != false){
		$rvspotdrop_custom_css .='.scrollup i{';
			$rvspotdrop_custom_css .='border-radius: '.esc_html($rvspotdrop_scroll_to_top_border_radius).'px;';
		$rvspotdrop_custom_css .='}';
	}

	/*----------------Social Icons Settings ------------------*/

	$rvspotdrop_social_icon_font_size = get_theme_mod('rvspotdrop_social_icon_font_size');
	if($rvspotdrop_social_icon_font_size != false){
		$rvspotdrop_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$rvspotdrop_custom_css .='font-size: '.esc_html($rvspotdrop_social_icon_font_size).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_social_icon_padding = get_theme_mod('rvspotdrop_social_icon_padding');
	if($rvspotdrop_social_icon_padding != false){
		$rvspotdrop_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$rvspotdrop_custom_css .='padding: '.esc_html($rvspotdrop_social_icon_padding).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_social_icon_width = get_theme_mod('rvspotdrop_social_icon_width');
	if($rvspotdrop_social_icon_width != false){
		$rvspotdrop_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$rvspotdrop_custom_css .='width: '.esc_html($rvspotdrop_social_icon_width).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_social_icon_height = get_theme_mod('rvspotdrop_social_icon_height');
	if($rvspotdrop_social_icon_height != false){
		$rvspotdrop_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$rvspotdrop_custom_css .='height: '.esc_html($rvspotdrop_social_icon_height).';';
		$rvspotdrop_custom_css .='}';
	}

	$rvspotdrop_social_icon_border_radius = get_theme_mod('rvspotdrop_social_icon_border_radius');
	if($rvspotdrop_social_icon_border_radius != false){
		$rvspotdrop_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$rvspotdrop_custom_css .='border-radius: '.esc_html($rvspotdrop_social_icon_border_radius).'px;';
		$rvspotdrop_custom_css .='}';
	}