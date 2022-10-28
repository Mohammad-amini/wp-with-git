<?php 
	$seokart_hs_breadcrumb					= get_theme_mod('hs_breadcrumb','1');
	$seokart_breadcrumb_bg_img				= get_theme_mod('breadcrumb_bg_img'); 
	$seokart_breadcrumb_back_attach			= get_theme_mod('breadcrumb_back_attach','scroll');
	
if($seokart_hs_breadcrumb == '1') {	
?>	
	<!-- Slider Area -->   
	<?php if(!empty($seokart_breadcrumb_bg_img)): ?>
    <section class="slider-area breadcrumb-section" style="background: url(<?php echo esc_url($seokart_breadcrumb_bg_img); ?>) center center <?php echo esc_attr($seokart_breadcrumb_back_attach); ?>;">
	<?php else: ?>
	 <section class="slider-area breadcrumb-section">
	 <?php endif; ?>
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/slider-shap-1.png" alt="" class="shape-1">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/ball-shap.png" alt="" class="shape-2">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/slider-shap-3.png" alt="" class="shape-3">
        <div class="container">
            <div class="about-banner-text text-center">   
					<h1><?php seokart_breadcrumb_title(); ?></h1>
					<ol class="breadcrumb-list">
						<?php seokart_breadcrumbs(); ?>
					</ol>
            </div>
        </div> 
    </section>
    <!-- End Slider Area -->
<?php }else{  ?>
	<section style="padding: 40px 0 30px;"></section>
<?php } ?>	