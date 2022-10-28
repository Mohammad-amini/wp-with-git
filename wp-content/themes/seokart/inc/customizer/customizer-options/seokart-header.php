<?php
function seokart_header_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Header Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'header_section', 
		array(
			'priority'      => 2,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Header', 'seokart'),
		) 
	);
	
	/*=========================================
	Seokart Site Identity
	=========================================*/
	$wp_customize->add_section(
        'title_tagline',
        array(
        	'priority'      => 1,
            'title' 		=> __('Site Identity','seokart'),
			'panel'  		=> 'header_section',
		)
    );
	
	
	/*=========================================
	Header Navigation
	=========================================*/	
	$wp_customize->add_section(
        'hdr_navigation',
        array(
        	'priority'      => 3,
            'title' 		=> __('Header Navigation','seokart'),
			'panel'  		=> 'header_section',
		)
    );

    // Cart
	$wp_customize->add_setting(
		'hdr_nav_cart'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'seokart_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'hdr_nav_cart',
		array(
			'type' => 'hidden',
			'label' => __('Cart','seokart'),
			'section' => 'hdr_navigation',
			'priority' => 2,
		)
	);

	// hide/show
	$wp_customize->add_setting( 
		'hide_show_cart' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'seokart_sanitize_checkbox',
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_cart', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'seokart' ),
			'section'     => 'hdr_navigation',
			'type'        => 'checkbox',
			'priority' => 2,
		) 
	);
	
	// Header Search
	$wp_customize->add_setting(
		'hdr_nav_search_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'seokart_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'hdr_nav_search_head',
		array(
			'type' => 'hidden',
			'label' => __('Search','seokart'),
			'section' => 'hdr_navigation',
			'priority'  => 3,
		)
	);	
	
	// hide/show
	$wp_customize->add_setting( 
		'hs_nav_search' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'seokart_sanitize_checkbox',
		) 
	);
	
	$wp_customize->add_control(
	'hs_nav_search', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'seokart' ),
			'section'     => 'hdr_navigation',
			'type'        => 'checkbox',
			'priority' => 3,
		) 
	);
	
	
	// Header Toggle
	$wp_customize->add_setting(
		'hdr_nav_toggle_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'seokart_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'hdr_nav_toggle_head',
		array(
			'type' => 'hidden',
			'label' => __('Toggle','seokart'),
			'section' => 'hdr_navigation',
			'priority'  => 6,
		)
	);	
	
	// hide/show
	$wp_customize->add_setting( 
		'hs_nav_toggle' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'seokart_sanitize_checkbox',
		) 
	);
	
	$wp_customize->add_control(
	'hs_nav_toggle', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'seokart' ),
			'section'     => 'hdr_navigation',
			'type'        => 'checkbox',
			'priority' => 7,
		) 
	);
	
	// Title // 
	$wp_customize->add_setting(
    	'seokart_hdr_toggle_ttl',
    	array(
			'sanitize_callback' => 'seokart_sanitize_html',
			'transport'         => $selective_refresh,
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control( 
		'seokart_hdr_toggle_ttl',
		array(
		    'label'   		=> __('Title','seokart'),
		    'section' 		=> 'hdr_navigation',
			'type'		 =>	'text',
			'priority' => 8,
		)  
	);	
	
	
	// content // 
	$wp_customize->add_setting(
    	'seokart_hdr_toggle_content',
    	array(
			'sanitize_callback' => 'seokart_sanitize_html',
			'transport'         => $selective_refresh,
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control( 
		'seokart_hdr_toggle_content',
		array(
		    'label'   		=> __('Content','seokart'),
		    'section' 		=> 'hdr_navigation',
			'type'		 =>	'textarea',
			'priority' => 8,
		)  
	);	
	
	
	/*=========================================
	Sticky Header
	=========================================*/	
	$wp_customize->add_section(
        'sticky_header_set',
        array(
        	'priority'      => 4,
            'title' 		=> __('Sticky Header','seokart'),
			'panel'  		=> 'header_section',
		)
    );
	
	// Heading
	$wp_customize->add_setting(
		'sticky_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'seokart_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'sticky_head',
		array(
			'type' => 'hidden',
			'label' => __('Sticky Header','seokart'),
			'section' => 'sticky_header_set',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_sticky' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'seokart_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_sticky', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'seokart' ),
			'section'     => 'sticky_header_set',
			'type'        => 'checkbox'
		) 
	);	
}
add_action( 'customize_register', 'seokart_header_settings' );