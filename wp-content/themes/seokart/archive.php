<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Seokart
 */

get_header();
?>
<section class="blog-area inarea-blog-2-column-area three">
	<div class="container">
		<div class="row">
			<div class="<?php esc_attr(seokart_post_layout()); ?>">
				<div class="row">
					<?php if( have_posts() ): ?>
					
						<?php while( have_posts() ) : the_post(); ?>
							<div class="col-lg-12">
								<?php get_template_part('template-parts/content/content','page'); ?>
							</div>
						<?php endwhile; ?>
						
					<?php else: ?>
					
						<?php get_template_part('template-parts/content/content','none'); ?>
						
					<?php endif; ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<div class="animation-shap">
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shap-1.png" alt="" class="shap-1">
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shap-2.png" alt="" class="shap-2"> 
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shap-3.png" alt="" class="shap-3">
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shap-1.png" alt="" class="shap-4">
	</div>
</section>	
<?php get_footer(); ?>
