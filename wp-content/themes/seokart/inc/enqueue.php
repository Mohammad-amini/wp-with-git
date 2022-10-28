<?php
 /**
 * Enqueue scripts and styles.
 */
function seokart_scripts() {
	
	// Styles	
	wp_enqueue_style('bootstrap-min',get_template_directory_uri().'/assets/css/bootstrap.min.css');
	
	wp_enqueue_style('owl-carousel-min',get_template_directory_uri().'/assets/css/owl.carousel.min.css');
	
	wp_enqueue_style('font-awesome',get_template_directory_uri().'/assets/css/fonts/font-awesome/css/font-awesome.min.css');
	
	wp_enqueue_style('animate',get_template_directory_uri().'/assets/css/animate.css');
	
	wp_enqueue_style('seokart-editor-style',get_template_directory_uri().'/assets/css/editor-style.css');

	wp_enqueue_style('seokart-main', get_template_directory_uri() . '/assets/css/main.css');

	wp_enqueue_style('seokart-woo', get_template_directory_uri() . '/assets/css/woo.css');
	
	wp_enqueue_style( 'seokart-style', get_stylesheet_uri() );
	
	// Scripts
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), false, true);

	wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), false, true);
	
	wp_enqueue_script('wow-min', get_template_directory_uri() . '/assets/js/wow.min.js', array('jquery'), false, false, true);

	wp_enqueue_script('seokart-custom-js', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), false, true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'seokart_scripts' );

//Admin Enqueue for Admin
function seokart_admin_enqueue_scripts(){
	wp_enqueue_style('seokart-admin-style', get_template_directory_uri() . '/inc/customizer/assets/css/admin.css');
	wp_enqueue_script( 'seokart-admin-script', get_template_directory_uri() . '/inc/customizer/assets/js/seokart-admin-script.js', array( 'jquery' ), '', true );
    wp_localize_script( 'seokart-admin-script', 'seokart_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
add_action( 'admin_enqueue_scripts', 'seokart_admin_enqueue_scripts' );