<?php  
	$seokart_hs_blog 			= get_theme_mod('hs_blog','1');
	$seokart_blog_title 		= get_theme_mod('blog_title');
	$seokart_blog_subtitle		= get_theme_mod('blog_subtitle'); 
	$seokart_blog_description	= get_theme_mod('blog_description');
	$seokart_blog_num			= get_theme_mod('blog_display_num','3');
	if($seokart_hs_blog=='1'):
?>
<section id="blog-section" class="blog-area home-blog">
	<div class="container">
		<?php if(!empty($seokart_blog_title) || !empty($seokart_blog_subtitle) || !empty($seokart_blog_description)): ?>
			<div class="title">
				<?php if(!empty($seokart_blog_title)): ?>
					<h6><?php echo wp_kses_post($seokart_blog_title); ?></h6>
				<?php endif; ?>
				
				<?php if(!empty($seokart_blog_subtitle)): ?>
					<h2><?php echo wp_kses_post($seokart_blog_subtitle); ?></h2>
					<span class="shap"></span>
				<?php endif; ?>
				
				<?php if(!empty($seokart_blog_description)): ?>
					<p><?php echo wp_kses_post($seokart_blog_description); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?> 
		<div class="row">
			<?php 	
				$seokart_blogs_args = array( 'post_type' => 'post', 'posts_per_page' => $seokart_blog_num,'post__not_in'=>get_option("sticky_posts")) ; 	
				$seokart_blog_wp_query = new WP_Query($seokart_blogs_args);
				if($seokart_blog_wp_query)
				{	
				while($seokart_blog_wp_query->have_posts()):$seokart_blog_wp_query->the_post(); ?>
				<div class="col-lg-4 col-md-6">
					<?php get_template_part('/template-parts/content/content','page'); ?>
				</div>
			<?php 
				endwhile; 
				}
				wp_reset_postdata();
			?>
		</div>
	</div>
	<div class="animation-shap">
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shap-1.png" alt="" class="shap-1">
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shap-2.png" alt="" class="shap-2"> 
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shap-3.png" alt="" class="shap-3">
		<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shap-1.png" alt="" class="shap-4">
	</div>
</section>
<?php endif; ?>