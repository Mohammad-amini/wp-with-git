<?php
function digipress_css() {
	$parent_style = 'seokart-parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'digipress-style', get_stylesheet_uri(), array( $parent_style ));

}
add_action( 'wp_enqueue_scripts', 'digipress_css',999);
 

/**
 * Import Options From Parent Theme
 *
 */
function digipress_parent_theme_options() {
	$seokart_mods = get_option( 'theme_mods_seokart' );
	if ( ! empty( $seokart_mods ) ) {
		foreach ( $seokart_mods as $seokart_mod_k => $seokart_mod_v ) {
			set_theme_mod( $seokart_mod_k, $seokart_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'digipress_parent_theme_options' );


require( get_stylesheet_directory() . '/inc/customizer/customizer-pro/class-customize.php');