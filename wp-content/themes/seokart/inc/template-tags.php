<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Seokart
 */

if ( ! function_exists( 'seokart_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function seokart_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'seokart' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'seokart' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}
endif;


if ( ! function_exists( 'seokart_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function seokart_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'seokart' ) );
		if ( $categories_list && seokart_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'seokart' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'seokart' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'seokart' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'seokart' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'seokart' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function seokart_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'seokart_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'seokart_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so seokart_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so seokart_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in seokart_categorized_blog.
 */
function seokart_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'seokart_categories' );
}
add_action( 'edit_category', 'seokart_category_transient_flusher' );
add_action( 'save_post',     'seokart_category_transient_flusher' );


/**
 * Function that returns if the menu is sticky
 */
if (!function_exists('seokart_sticky_menu')):
    function seokart_sticky_menu()
    {
        $is_sticky = get_theme_mod('hide_show_sticky','1');

        if ($is_sticky == '1'):
            return 'is-sticky-on';
        else:
            return 'not-sticky';
        endif;
    }
endif;


/**
 * Register Google fonts for seokart.
 */
function seokart_google_font() {
	
    $get_fonts_url = '';
		
    $font_families = array();
 
	$font_families = array('Work Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700');
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $get_fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return $get_fonts_url;
}

function seokart_scripts_styles() {
    wp_enqueue_style( 'seokart-fonts', seokart_google_font(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'seokart_scripts_styles' );


/**
 * Register Breadcrumb for Multiple Variation
 */
function seokart_breadcrumbs_style() {
	get_template_part('./template-parts/sections/section','breadcrumb');	
}


/**
 * This Function Check whether Sidebar active or Not
 */
if(!function_exists( 'seokart_post_layout' )) :
function seokart_post_layout(){
	if(is_active_sidebar('seokart-sidebar-primary'))
		{ echo 'col-lg-8'; } 
	else 
		{ echo 'col-lg-12'; }  
} endif;



/**
 *	SeoKart Dynamic Styles
 */
 
if( ! function_exists( 'seokart_theme_dynamic_style' ) ):
    function seokart_theme_dynamic_style() {

		$output_css = '';	
				
		/**
		 *  Breadcrumb Style
		 */
		
		$breadcrumb_bg_img			= get_theme_mod('breadcrumb_bg_img'); 
		
		if($breadcrumb_bg_img != '') { 
			$output_css .=".breadcrumb-section:after  {
					content: '';
					background-color:#081C75;
					opacity: 0.75;
					position: absolute;
					top: 0;
					right: 0;
					bottom: 0;
					left: 0;
					width: 100%;
					height: 100%;
					z-index: -2;
				}\n";
		}else{
			$output_css .=".slider-area::after  {
					content: '';
					position: absolute;
					left: 0;
					right: 0;
					bottom: 0;
					background: url(". esc_url(get_template_directory_uri())."/assets/images/water-shap.png) repeat-x;
					width: 100%;
					height: 87px;
					animation: moveleftbounce 3s linear infinite
				}.breadcrumb-section {
					background: #081C75 url(". esc_url(get_template_directory_uri())."/assets/images/slider-button-shap.png)no-repeat left bottom;
				}\n";
		}		

		 /**
		 *  Clip Art
		 */
		 $hs_clipart		= get_theme_mod('hs_clipart','1');	
		 if($hs_clipart!='1'):
			$output_css .=".animation-shap,.shape-1,shape-2,.shape-3 {
					display:none;
				}\n";
		 endif;
		 
		  /**
		 *  Footer
		 */
		 $footer_bg_img			= get_theme_mod('footer_bg_img',esc_url(get_template_directory_uri() .'/assets/images/footer-bg.png'));		
		 if($footer_bg_img!=''):
			$output_css .=".footer-area {
					    background: url(". esc_url($footer_bg_img) .") no-repeat bottom;
						background-size: 100% 100%;
				}\n";
		 else: 
			 $output_css .=".footer-area {
							background: #081c75;
							background-size: 100% 100%;
					}\n";
		 endif;
		 
		 
        wp_add_inline_style( 'seokart-style', $output_css );
    }
endif;
add_action( 'wp_enqueue_scripts', 'seokart_theme_dynamic_style' );