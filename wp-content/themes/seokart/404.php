<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Seokart
 */

get_header();
?>
<section class="error-area">
	<div class="container">
		<div class="error-item text-center">	
		
			<div class="image"><img src="<?php echo esc_url(get_template_directory_uri() .'/assets/images/404-Page-2.png'); ?>" alt=""></div>
				
			<h2><?php esc_html_e('Page Not Found','seokart'); ?></h2>    
			
			<p><?php esc_html_e('The page you were looking for could not be found.','seokart'); ?></p>  
			
			<a class="theme-button back-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Go to Home','seokart'); ?></a>	
			
		</div>
	</div>
</section>	
<?php get_footer(); ?>
