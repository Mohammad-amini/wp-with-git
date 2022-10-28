</div>
<footer class="footer-area">  
   <div class="container"> 
		<?php do_action('seokart_footer_above'); 
		 if ( is_active_sidebar( 'seokart-footer-widget-area' ) ) { ?>	
			<div class="row footer-row"> 
				<?php  dynamic_sidebar( 'seokart-footer-widget-area' ); ?>
			</div>  
		<?php } ?>
	</div>
	
	<?php 
		$footer_copyright = get_theme_mod('footer_copyright','Copyright &copy; [current_year] [site_title] | Powered by [theme_author]');
	?>
	<div class="copy-right"> 
		<div class="container"> 
			<?php 
			if ( ! empty( $footer_copyright ) ): ?>
			<?php 	
				$seokart_copyright_allowed_tags = array(
					'[current_year]' => date_i18n('Y'),
					'[site_title]'   => get_bloginfo('name'),
					'[theme_author]' => sprintf(__('<a href="#">SeoKart</a>', 'seokart')),
				);
			?>                          
			<p class="copyright-text">
				<?php
					echo apply_filters('seokart_footer_copyright', wp_kses_post(seokart_str_replace_assoc($seokart_copyright_allowed_tags, $footer_copyright)));
				?>
			</p>
			<?php endif; ?>
		</div>
	</div>
</footer>
<!-- End Footer Area  -->

<button class="scroll-top">
	<i class="fa fa-angle-up"></i>
</button>

</div>		
<?php wp_footer(); ?>
</body>
</html>
