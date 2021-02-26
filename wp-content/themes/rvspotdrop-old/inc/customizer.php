<?php
/**
 * RVSpotDrop Theme Customizer
 *
 * @package RVSpotDrop
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function rvspotdrop_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'rvspotdrop_custom_controls' );

function rvspotdrop_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . 'inc/customize-homepage/class-customize-homepage.php' );

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'rvspotdrop_customize_partial_blogname', 
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'rvspotdrop_customize_partial_blogdescription', 
	));

	//add home page setting pannel
	$rvspotdrop_parent_panel = new rvspotdrop_WP_Customize_Panel( $wp_customize, 'rvspotdrop_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => 'VW Settings',
		'priority' => 10,
	));

	// Layout
	$wp_customize->add_section( 'rvspotdrop_left_right', array(
    	'title'      => __( 'General Settings', 'rvspotdrop' ),
		'panel' => 'rvspotdrop_panel_id'
	) );

	$wp_customize->add_setting('rvspotdrop_width_option',array(
        'default' => __('Full Width','rvspotdrop'),
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control(new rvspotdrop_Image_Radio_Control($wp_customize, 'rvspotdrop_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','rvspotdrop'),
        'description' => __('Here you can change the width layout of Website.','rvspotdrop'),
        'section' => 'rvspotdrop_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('rvspotdrop_theme_options',array(
        'default' => __('Right Sidebar','rvspotdrop'),
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control('rvspotdrop_theme_options',array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','rvspotdrop'),
        'description' => __('Here you can change the sidebar layout for posts. ','rvspotdrop'),
        'section' => 'rvspotdrop_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','rvspotdrop'),
            'Right Sidebar' => __('Right Sidebar','rvspotdrop'),
            'One Column' => __('One Column','rvspotdrop'),
            'Three Columns' => __('Three Columns','rvspotdrop'),
            'Four Columns' => __('Four Columns','rvspotdrop'),
            'Grid Layout' => __('Grid Layout','rvspotdrop')
        ),
	) );

	$wp_customize->add_setting('rvspotdrop_page_layout',array(
        'default' => __('One Column','rvspotdrop'),
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control('rvspotdrop_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','rvspotdrop'),
        'description' => __('Here you can change the sidebar layout for pages. ','rvspotdrop'),
        'section' => 'rvspotdrop_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','rvspotdrop'),
            'Right Sidebar' => __('Right Sidebar','rvspotdrop'),
            'One Column' => __('One Column','rvspotdrop')
        ),
	) );

    //Sticky Header
	$wp_customize->add_setting( 'rvspotdrop_sticky_header',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ) );
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_sticky_header',array(
        'label' => esc_html__( 'Sticky Header','rvspotdrop' ),
        'section' => 'rvspotdrop_left_right'
    )));

    $wp_customize->add_setting('rvspotdrop_sticky_header_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_sticky_header_padding',array(
		'label'	=> __('Sticky Header Padding','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_left_right',
		'type'=> 'text'
	));

    //Pre-Loader
	$wp_customize->add_setting( 'rvspotdrop_loader_enable',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ) );
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','rvspotdrop' ),
        'section' => 'rvspotdrop_left_right'
    )));

	$wp_customize->add_setting('rvspotdrop_loader_icon',array(
        'default' => __('Two Way','rvspotdrop'),
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control('rvspotdrop_loader_icon',array(
        'type' => 'select',
        'label' => __('Pre-Loader Type','rvspotdrop'),
        'section' => 'rvspotdrop_left_right',
        'choices' => array(
            'Two Way' => __('Two Way','rvspotdrop'),
            'Dots' => __('Dots','rvspotdrop'),
            'Rotate' => __('Rotate','rvspotdrop')
        ),
	) );
    
	//Slider
	$wp_customize->add_section( 'rvspotdrop_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'rvspotdrop' ),
		'panel' => 'rvspotdrop_panel_id'
	) );

	$wp_customize->add_setting( 'rvspotdrop_slider_arrows',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ));  
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_slider_arrows',array(
      	'label' => esc_html__( 'Show / Hide Slider','rvspotdrop' ),
      	'section' => 'rvspotdrop_slidersettings'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('rvspotdrop_slider_arrows',array(
		'selector'        => '#slider .carousel-caption h1',
		'render_callback' => 'rvspotdrop_customize_partial_rvspotdrop_slider_arrows',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'rvspotdrop_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'rvspotdrop_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'rvspotdrop_slider_page' . $count, array(
			'label'    => __( 'Select Slider Page', 'rvspotdrop' ),
			'description' => __('Slider image size (350 x 350)','rvspotdrop'),
			'section'  => 'rvspotdrop_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('rvspotdrop_slider_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( 'MORE ABOUT US', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_slidersettings',
		'type'=> 'text'
	));

	//content layout
	$wp_customize->add_setting('rvspotdrop_slider_content_option',array(
        'default' => __('Left','rvspotdrop'),
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control(new rvspotdrop_Image_Radio_Control($wp_customize, 'rvspotdrop_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','rvspotdrop'),
        'section' => 'rvspotdrop_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/slider-content3.png',
    ))));

    //Slider excerpt
	$wp_customize->add_setting( 'rvspotdrop_slider_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'rvspotdrop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'rvspotdrop_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','rvspotdrop' ),
		'section'     => 'rvspotdrop_slidersettings',
		'type'        => 'range',
		'settings'    => 'rvspotdrop_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'rvspotdrop_slider_speed', array(
		'default'  => 3000,
		'sanitize_callback'	=> 'rvspotdrop_sanitize_float'
	) );
	$wp_customize->add_control( 'rvspotdrop_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','rvspotdrop'),
		'section' => 'rvspotdrop_slidersettings',
		'type'  => 'number',
	) );
 
	//Services
	$wp_customize->add_section('rvspotdrop_services',array(
		'title'	=> __('Services Section','rvspotdrop'),
		'panel' => 'rvspotdrop_panel_id',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'rvspotdrop_section_title', array( 
		'selector' => '.heading-text h2', 
		'render_callback' => 'rvspotdrop_customize_partial_rvspotdrop_section_title',
	));

	$wp_customize->add_setting('rvspotdrop_section_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('rvspotdrop_section_text',array(
		'label'	=> __('Section Text','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( 'Services', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_services',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('rvspotdrop_section_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('rvspotdrop_section_title',array(
		'label'	=> __('Section Title','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( 'Services We Provide', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_services',
		'type'=> 'text'
	));	

	$categories = get_categories();
		$cat_posts = array();
			$i = 0;
			$cat_posts[]='Select';	
		foreach($categories as $category){
			if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_posts[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('rvspotdrop_services_category',array(
		'default'	=> 'select',
		'sanitize_callback' => 'rvspotdrop_sanitize_choices',
	));
	$wp_customize->add_control('rvspotdrop_services_category',array(
		'type'    => 'select',
		'choices' => $cat_posts,
		'label' => __('Select Category to display Latest Post','rvspotdrop'),		
		'section' => 'rvspotdrop_services',
	));

	//Services excerpt
	$wp_customize->add_setting( 'rvspotdrop_services_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'rvspotdrop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'rvspotdrop_services_excerpt_number', array(
		'label'       => esc_html__( 'Services Excerpt length','rvspotdrop' ),
		'section'     => 'rvspotdrop_services',
		'type'        => 'range',
		'settings'    => 'rvspotdrop_services_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Blog Post
	$wp_customize->add_panel( $rvspotdrop_parent_panel );

	$BlogPostParentPanel = new rvspotdrop_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'rvspotdrop' ),
		'panel' => 'rvspotdrop_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'rvspotdrop_post_settings', array(
		'title' => __( 'Post Settings', 'rvspotdrop' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('rvspotdrop_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'rvspotdrop_customize_partial_rvspotdrop_toggle_postdate', 
	));

	$wp_customize->add_setting( 'rvspotdrop_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ) );
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','rvspotdrop' ),
        'section' => 'rvspotdrop_post_settings'
    )));

    $wp_customize->add_setting( 'rvspotdrop_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ) );
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_toggle_author',array(
		'label' => esc_html__( 'Author','rvspotdrop' ),
		'section' => 'rvspotdrop_post_settings'
    )));

    $wp_customize->add_setting( 'rvspotdrop_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ) );
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_toggle_comments',array(
		'label' => esc_html__( 'Comments','rvspotdrop' ),
		'section' => 'rvspotdrop_post_settings'
    )));

    $wp_customize->add_setting( 'rvspotdrop_toggle_tags',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'rvspotdrop_switch_sanitization'
	));
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_toggle_tags', array(
		'label' => esc_html__( 'Tags','rvspotdrop' ),
		'section' => 'rvspotdrop_post_settings'
    )));

    $wp_customize->add_setting( 'rvspotdrop_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'rvspotdrop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'rvspotdrop_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','rvspotdrop' ),
		'section'     => 'rvspotdrop_post_settings',
		'type'        => 'range',
		'settings'    => 'rvspotdrop_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Blog layout
    $wp_customize->add_setting('rvspotdrop_blog_layout_option',array(
        'default' => __('Default','rvspotdrop'),
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
    ));
    $wp_customize->add_control(new rvspotdrop_Image_Radio_Control($wp_customize, 'rvspotdrop_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Layouts','rvspotdrop'),
        'section' => 'rvspotdrop_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
    ))));

    $wp_customize->add_setting('rvspotdrop_excerpt_settings',array(
        'default' => __('Excerpt','rvspotdrop'),
        'transport' => 'refresh',
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control('rvspotdrop_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','rvspotdrop'),
        'section' => 'rvspotdrop_post_settings',
        'choices' => array(
        	'Content' => __('Content','rvspotdrop'),
            'Excerpt' => __('Excerpt','rvspotdrop'),
            'No Content' => __('No Content','rvspotdrop')
        ),
	) );

	$wp_customize->add_setting('rvspotdrop_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_post_settings',
		'type'=> 'text'
	));

    // Button Settings
	$wp_customize->add_section( 'rvspotdrop_button_settings', array(
		'title' => __( 'Button Settings', 'rvspotdrop' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting('rvspotdrop_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_button_padding_top_bottom',array(
		'label'	=> __('Padding Top Bottom','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_button_padding_left_right',array(
		'label'	=> __('Padding Left Right','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'rvspotdrop_button_border_radius', array(
		'default'              => 50,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'rvspotdrop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'rvspotdrop_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','rvspotdrop' ),
		'section'     => 'rvspotdrop_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('rvspotdrop_button_text', array( 
		'selector' => '.post-main-box .more-btn a', 
		'render_callback' => 'rvspotdrop_customize_partial_rvspotdrop_button_text', 
	));

    $wp_customize->add_setting('rvspotdrop_button_text',array(
		'default'=> 'READ MORE',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_button_text',array(
		'label'	=> __('Add Button Text','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_button_settings',
		'type'=> 'text'
	));

	// Related Post Settings
	$wp_customize->add_section( 'rvspotdrop_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'rvspotdrop' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('rvspotdrop_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'rvspotdrop_customize_partial_rvspotdrop_related_post_title', 
	));

    $wp_customize->add_setting( 'rvspotdrop_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ) );
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_related_post',array(
		'label' => esc_html__( 'Related Post','rvspotdrop' ),
		'section' => 'rvspotdrop_related_posts_settings'
    )));

    $wp_customize->add_setting('rvspotdrop_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_related_post_title',array(
		'label'	=> __('Add Related Post Title','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('rvspotdrop_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'rvspotdrop_sanitize_float'
	));
	$wp_customize->add_control('rvspotdrop_related_posts_count',array(
		'label'	=> __('Add Related Post Count','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_related_posts_settings',
		'type'=> 'number'
	));

    //404 Page Setting
	$wp_customize->add_section('rvspotdrop_404_page',array(
		'title'	=> __('404 Page Settings','rvspotdrop'),
		'panel' => 'rvspotdrop_panel_id',
	));	

	$wp_customize->add_setting('rvspotdrop_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('rvspotdrop_404_page_title',array(
		'label'	=> __('Add Title','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('rvspotdrop_404_page_content',array(
		'label'	=> __('Add Text','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_404_page_button_text',array(
		'label'	=> __('Add Button Text','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( 'GO BACK', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_404_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('rvspotdrop_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','rvspotdrop'),
		'panel' => 'rvspotdrop_panel_id',
	));	

	$wp_customize->add_setting('rvspotdrop_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_social_icon_padding',array(
		'label'	=> __('Icon Padding','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_social_icon_width',array(
		'label'	=> __('Icon Width','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_social_icon_height',array(
		'label'	=> __('Icon Height','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'rvspotdrop_social_icon_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'rvspotdrop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'rvspotdrop_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','rvspotdrop' ),
		'section'     => 'rvspotdrop_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('rvspotdrop_responsive_media',array(
		'title'	=> __('Responsive Media','rvspotdrop'),
		'panel' => 'rvspotdrop_panel_id',
	));

    $wp_customize->add_setting( 'rvspotdrop_stickyheader_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ));  
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_stickyheader_hide_show',array(
      'label' => esc_html__( 'Sticky Header','rvspotdrop' ),
      'section' => 'rvspotdrop_responsive_media'
    )));

    $wp_customize->add_setting( 'rvspotdrop_resp_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ));  
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','rvspotdrop' ),
      'section' => 'rvspotdrop_responsive_media'
    )));

	$wp_customize->add_setting( 'rvspotdrop_metabox_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ));  
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_metabox_hide_show',array(
      'label' => esc_html__( 'Show / Hide Metabox','rvspotdrop' ),
      'section' => 'rvspotdrop_responsive_media'
    )));

    $wp_customize->add_setting( 'rvspotdrop_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ));  
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','rvspotdrop' ),
      'section' => 'rvspotdrop_responsive_media'
    )));

    $wp_customize->add_setting( 'rvspotdrop_resp_scroll_top_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ));  
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','rvspotdrop' ),
      'section' => 'rvspotdrop_responsive_media'
    )));

    $wp_customize->add_setting('rvspotdrop_res_menu_open_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new rvspotdrop_Fontawesome_Icon_Chooser(
        $wp_customize,'rvspotdrop_res_menu_open_icon',array(
		'label'	=> __('Add Open Menu Icon','rvspotdrop'),
		'transport' => 'refresh',
		'section'	=> 'rvspotdrop_responsive_media',
		'setting'	=> 'rvspotdrop_res_menu_open_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('rvspotdrop_res_menu_close_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new rvspotdrop_Fontawesome_Icon_Chooser(
        $wp_customize,'rvspotdrop_res_menu_close_icon',array(
		'label'	=> __('Add Close Menu Icon','rvspotdrop'),
		'transport' => 'refresh',
		'section'	=> 'rvspotdrop_responsive_media',
		'setting'	=> 'rvspotdrop_res_menu_close_icon',
		'type'		=> 'icon'
	)));

	//Content Creation
	$wp_customize->add_section( 'rvspotdrop_content_section' , array(
    	'title' => __( 'Customize Home Page Settings', 'rvspotdrop' ),
		'priority' => null,
		'panel' => 'rvspotdrop_panel_id'
	) );

	$wp_customize->add_setting('rvspotdrop_content_creation_main_control', array(
		'sanitize_callback' => 'esc_html',
	) );

	$homepage= get_option( 'page_on_front' );

	$wp_customize->add_control(	new rvspotdrop_Content_Creation( $wp_customize, 'rvspotdrop_content_creation_main_control', array(
		'options' => array(
			esc_html__( 'First select static page in homepage setting for front page.Below given edit button is to customize Home Page. Just click on the edit option, add whatever elements you want to include in the homepage, save the changes and you are good to go.','rvspotdrop' ),
		),
		'section' => 'rvspotdrop_content_section',
		'button_url'  => admin_url( 'post.php?post='.$homepage.'&action=edit'),
		'button_text' => esc_html__( 'Edit', 'rvspotdrop' ),
	) ) );

	//Footer Text
	$wp_customize->add_section('rvspotdrop_footer',array(
		'title'	=> __('Footer Settings','rvspotdrop'),
		'panel' => 'rvspotdrop_panel_id',
	));	

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('rvspotdrop_footer_text', array( 
		'selector' => '.copyright p', 
		'render_callback' => 'rvspotdrop_customize_partial_rvspotdrop_footer_text', 
	));
	
	$wp_customize->add_setting('rvspotdrop_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('rvspotdrop_footer_text',array(
		'label'	=> __('Copyright Text','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( 'Copyright 2019, .....', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_copyright_alingment',array(
        'default' => __('center','rvspotdrop'),
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control(new rvspotdrop_Image_Radio_Control($wp_customize, 'rvspotdrop_copyright_alingment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','rvspotdrop'),
        'section' => 'rvspotdrop_footer',
        'settings' => 'rvspotdrop_copyright_alingment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

    $wp_customize->add_setting('rvspotdrop_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'rvspotdrop_footer_scroll',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ));  
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_footer_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll to Top','rvspotdrop' ),
      	'section' => 'rvspotdrop_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('rvspotdrop_scroll_to_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'rvspotdrop_customize_partial_rvspotdrop_scroll_to_top_icon', 
	));

    $wp_customize->add_setting('rvspotdrop_scroll_to_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new rvspotdrop_Fontawesome_Icon_Chooser(
        $wp_customize,'rvspotdrop_scroll_to_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','rvspotdrop'),
		'transport' => 'refresh',
		'section'	=> 'rvspotdrop_footer',
		'setting'	=> 'rvspotdrop_scroll_to_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('rvspotdrop_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_scroll_to_top_width',array(
		'label'	=> __('Icon Width','rvspotdrop'),
		'description'	=> __('Enter a value in pixels Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('rvspotdrop_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('rvspotdrop_scroll_to_top_height',array(
		'label'	=> __('Icon Height','rvspotdrop'),
		'description'	=> __('Enter a value in pixels. Example:20px','rvspotdrop'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'rvspotdrop' ),
        ),
		'section'=> 'rvspotdrop_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'rvspotdrop_scroll_to_top_border_radius', array(
		'default'              => 50,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'rvspotdrop_sanitize_number_range'
	) );
	$wp_customize->add_control( 'rvspotdrop_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','rvspotdrop' ),
		'section'     => 'rvspotdrop_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('rvspotdrop_scroll_top_alignment',array(
        'default' => __('Right','rvspotdrop'),
        'sanitize_callback' => 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control(new rvspotdrop_Image_Radio_Control($wp_customize, 'rvspotdrop_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','rvspotdrop'),
        'section' => 'rvspotdrop_footer',
        'settings' => 'rvspotdrop_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

    //Woocommerce settings
	$wp_customize->add_section('rvspotdrop_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'rvspotdrop'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'rvspotdrop_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ) );
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','rvspotdrop' ),
		'section' => 'rvspotdrop_woocommerce_section'
    )));

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'rvspotdrop_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'rvspotdrop_switch_sanitization'
    ) );
    $wp_customize->add_control( new rvspotdrop_Toggle_Switch_Custom_Control( $wp_customize, 'rvspotdrop_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Single Product Sidebar','rvspotdrop' ),
		'section' => 'rvspotdrop_woocommerce_section'
    )));

    //Products per page
    $wp_customize->add_setting('rvspotdrop_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'rvspotdrop_sanitize_float'
	));
	$wp_customize->add_control('rvspotdrop_products_per_page',array(
		'label'	=> __('Products Per Page','rvspotdrop'),
		'description' => __('Display on shop page','rvspotdrop'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'rvspotdrop_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('rvspotdrop_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'rvspotdrop_sanitize_choices'
	));
	$wp_customize->add_control('rvspotdrop_products_per_row',array(
		'label'	=> __('Products Per Row','rvspotdrop'),
		'description' => __('Display on shop page','rvspotdrop'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'rvspotdrop_woocommerce_section',
		'type'=> 'select',
	));

    // Has to be at the top
	$wp_customize->register_panel_type( 'rvspotdrop_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'rvspotdrop_WP_Customize_Section' );
}

add_action( 'customize_register', 'rvspotdrop_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class rvspotdrop_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'rvspotdrop_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class rvspotdrop_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'rvspotdrop_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function rvspotdrop_customize_controls_scripts() {
  wp_enqueue_script( 'rvspotdrop-customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'rvspotdrop_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class rvspotdrop_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'rvspotdrop_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new rvspotdrop_Customize_Section_Pro( $manager,'example_1', array(
			'priority'   => 1,
			'title'    => esc_html__( 'RVSpotDrop Pro', 'rvspotdrop' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'rvspotdrop' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/minimalist-wordpress-theme/'),
		) )	);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'rvspotdrop-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'rvspotdrop-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
rvspotdrop_Customize::get_instance();