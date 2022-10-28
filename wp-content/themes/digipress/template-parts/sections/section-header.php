<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="custom-header" rel="home">
		<img src="<?php esc_url(header_image()); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'title' )); ?>">
	</a>	
<?php endif;  ?>
<!-- Header Area -->
    <header class="main-header <?php echo esc_attr(seokart_sticky_menu()); ?>">
		<?php if ( function_exists( 'burger_companion_activated' ) ) { ?>
			<button class="top-header-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".top-header"><i class="fa fa-ellipsis-v"></i></button>
		<?php } ?>	
       <div class="container"> 
			<div class="top-header-wrap">
            	<button class="top-header-toggler top-header-close" type="button" data-bs-toggle="collapse" data-bs-target=".top-header"><i class="fa fa-ellipsis-v"></i></button>
            	<div class="top-header collapse">
	                <div class="header-widget">
						<div class="logo d-lg-block d-none">
							<?php
							if(has_custom_logo())
								{	
									the_custom_logo();
								}
								else { 
								?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<h4 class="site-title">
										<?php 
											echo esc_html(bloginfo('name'));
										?>
									</h4>
								</a>	
							<?php 						
								}
							?>
							<?php
								$digipress_site_desc = get_bloginfo( 'description');
								if ($digipress_site_desc) : ?>
									<p class="site-description"><?php echo esc_html($digipress_site_desc); ?></p>
							<?php endif; ?>
						</div>
	                    <?php do_action('seokart_above_header'); ?>
	               </div>
	           </div>
            </div>
           <!-- Header -->
            <nav class="navbar navbar-expand-lg navbaroffcanvase"> 
				<div class="logo d-lg-none">
					<?php
					if(has_custom_logo())
						{	
							the_custom_logo();
						}
						else { 
						?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<h4 class="site-title">
								<?php 
									echo esc_html(bloginfo('name'));
								?>
							</h4>
						</a>	
					<?php 						
						}
					?>
					<?php
						$digipress_site_desc = get_bloginfo( 'description');
						if ($digipress_site_desc) : ?>
							<p class="site-description"><?php echo esc_html($digipress_site_desc); ?></p>
					<?php endif; ?>
				</div>
                <div class="navbar-menubar">
                    <!-- Small Divice Menu-->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-menu"  aria-label="<?php  esc_attr_e('Toggle navigation','digipress'); ?>"> 
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse navbar-menu">
	                    <button class="navbar-toggler navbar-toggler-close" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-menu"  aria-label="<?php  esc_attr_e('Toggle navigation','digipress'); ?>"> 
	                        <i class="fa fa-times"></i>
	                    </button> 
						<?php 
							wp_nav_menu( 
								array(  
									'theme_location' => 'primary_menu',
									'container'  => '',
									'container_id'    => '',
									'menu_class' => 'navbar-nav main-nav',
									'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
									'walker' => new WP_Bootstrap_Navwalker()
									 ) 
								);
						?>
                    </div>
					
                    <div class="navbar-nav-left nav-listing navbar-menu">
                        <ul class="navbar-nav navbar-nav-left">
							<?php  
								$digipress_hs_nav_search 	= get_theme_mod('hs_nav_search','1');
								if($digipress_hs_nav_search=='1'):
							?>
								<li class="dropdown cs-menu search-menu"> 
									<a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="collapse" data-bs-target="#Search">
										<svg width="16" height="15"><path d="m15.661 14.566-.094.094c-.55.549-1.415.402-2.034-.217l-3.104-3.101c-.143-.142-.313-.042-.313-.042a5.983 5.983 0 0 1-7.358-.917 6.095 6.095 0 0 1 0-8.615 6.11 6.11 0 0 1 8.622 0 5.97 5.97 0 0 1 .918 7.352s-.101.169.035.305l3.111 3.108c.619.619.766 1.484.217 2.033ZM10.255 2.893a4.515 4.515 0 0 0-6.371 0 4.503 4.503 0 0 0 0 6.366 4.515 4.515 0 0 0 6.371 0 4.505 4.505 0 0 0 0-6.366ZM8.963 5.855a2.369 2.369 0 0 0-1.274-1.11 2.41 2.41 0 0 0-1.701-.026.877.877 0 0 1-.863-.165.778.778 0 0 1-.19-.239c-.085-.163.286-.711.401-.937.904-.325 1.921-.308 2.87.054.961.367 1.734 1.041 2.176 1.897a.65.65 0 0 1-.365.929.875.875 0 0 1-1.054-.403ZM5.371 3.313c-.006.014-.025.046-.035.065-.012.005-.024.006-.035.01-.19.069.139-.25.07-.075Z"/></svg>
									</a>
									<ul class="sub-menu collapse" id="Search">
										<li>
											<div class="searchinput-form">
												<form method="get" class="input-group" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php  esc_attr_e('Site Search','digipress'); ?>">
													<!--span class="screen-reader-text">Search for:</span-->
													<input type="text" class="form-control" placeholder="<?php  esc_attr_e('Search','digipress'); ?>" name="s">
													<button type="submit" class="input-group-text search-submit">
														<svg width="16" height="15"><path d="m15.661 14.566-.094.094c-.55.549-1.415.402-2.034-.217l-3.104-3.101c-.143-.142-.313-.042-.313-.042a5.983 5.983 0 0 1-7.358-.917 6.095 6.095 0 0 1 0-8.615 6.11 6.11 0 0 1 8.622 0 5.97 5.97 0 0 1 .918 7.352s-.101.169.035.305l3.111 3.108c.619.619.766 1.484.217 2.033ZM10.255 2.893a4.515 4.515 0 0 0-6.371 0 4.503 4.503 0 0 0 0 6.366 4.515 4.515 0 0 0 6.371 0 4.505 4.505 0 0 0 0-6.366ZM8.963 5.855a2.369 2.369 0 0 0-1.274-1.11 2.41 2.41 0 0 0-1.701-.026.877.877 0 0 1-.863-.165.778.778 0 0 1-.19-.239c-.085-.163.286-.711.401-.937.904-.325 1.921-.308 2.87.054.961.367 1.734 1.041 2.176 1.897a.65.65 0 0 1-.365.929.875.875 0 0 1-1.054-.403ZM5.371 3.313c-.006.014-.025.046-.035.065-.012.005-.024.006-.035.01-.19.069.139-.25.07-.075Z"/></svg>
													</button>
												</form>
												<button type="button" class="header-search-close" data-bs-toggle="collapse" data-bs-target="#Search"><i class="fa fa-times"></i></button>
											</div>
										</li>  
									</ul>
								</li>  
							<?php endif; 
								$digipress_hide_show_cart 			= get_theme_mod('hide_show_cart','1');
									if($digipress_hide_show_cart=='1'):
									if ( class_exists( 'WooCommerce' ) ) { ?>
									<li class="dropdown cs-menu woocommerce"> 
										<a class="nav-link cart-icon-wrap header-cart" href="javascript:void(0);" role="button" data-bs-toggle="collapse" data-bs-target="#Cart">
											<svg width="20" height="21"><path d="M19.167 6.769 20 10.76c0 .435-.35.787-.781.787h-.514l-.721 6.544a.784.784 0 0 1-.863.695.786.786 0 0 1-.689-.871l.798-7.243a.784.784 0 0 1 .777-.7h.431V8.397H1.563v1.575h16.653c.432 0 .781.354.781.788a.783.783 0 0 1-.781.787H2.882l.771 6.489a1.568 1.568 0 0 0 1.552 1.388h9.653c.796 0 1.464-.602 1.553-1.4a.783.783 0 0 1 .863-.694.785.785 0 0 1 .689.87 3.131 3.131 0 0 1-3.105 2.799H5.205a3.136 3.136 0 0 1-3.103-2.776l-.794-6.676H.781A.784.784 0 0 1 0 10.76V7.609c0-.435.35-.787.781-.787h2.771L9.347.317a.778.778 0 0 1 1.092-.169.792.792 0 0 1 .167 1.102L5.491 6.822h9.047L9.422 1.25A.793.793 0 0 1 9.59.148a.778.778 0 0 1 1.092.169l5.795 6.505h2.742c.431 0-.052-.488-.052-.053ZM9.219 13.91v3.151c0 .435.349.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.783.783 0 0 0-.781.787Zm3.125 0v3.151c0 .435.349.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.783.783 0 0 0-.781.787Zm-6.25 0v3.151c0 .435.35.787.781.787a.784.784 0 0 0 .781-.787V13.91a.784.784 0 0 0-.781-.787.784.784 0 0 0-.781.787Z"/></svg>
											<?php 
												if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
													$count = WC()->cart->cart_contents_count;
													$cart_url = wc_get_cart_url();
													
													if ( $count > 0 ) {
													?>
														 <span><?php echo esc_html( $count ); ?></span>
													<?php 
													}
													else {
														?>
														<span><?php esc_html_e('0','digipress'); ?></span>
														<?php 
													}
												}
											?>
										</a>
										<ul class="sub-menu collapse" id="Cart">
											<li class="shopping-cart"> 
											<?php get_template_part('woocommerce/cart/mini','cart'); ?>
												
											</li>  
										</ul>
									</li>  
								<?php } endif;
								$digipress_hs_nav_toggle 	= get_theme_mod('hs_nav_toggle','1');
								$digipress_hdr_toggle_ttl 	= get_theme_mod('seokart_hdr_toggle_ttl');
								$digipress_hdr_toggle_content = get_theme_mod('seokart_hdr_toggle_content');
								if($digipress_hs_nav_toggle=='1'):
							?>
                            <li class="toggle-button">
                                <a data-bs-toggle="offcanvas" href="#aboutDocker" role="button" aria-controls="aboutDocker" class="toggle-icon">
                                    <svg width="25" height="25"><path d="M21.635 11.922h-5.193a3.369 3.369 0 0 1-3.365-3.366V3.364a3.37 3.37 0 0 1 3.365-3.365h5.193A3.37 3.37 0 0 1 25 3.364v5.192a3.369 3.369 0 0 1-3.365 3.366Zm1.442-8.558c0-.795-.647-1.442-1.442-1.442h-5.193c-.795 0-1.442.647-1.442 1.442v5.192c0 .796.647 1.443 1.442 1.443h5.193c.795 0 1.442-.647 1.442-1.443V3.364ZM8.558 24.999H3.365A3.37 3.37 0 0 1 0 21.634v-5.193a3.369 3.369 0 0 1 3.365-3.365h5.193a3.369 3.369 0 0 1 3.365 3.365v5.193a3.37 3.37 0 0 1-3.365 3.365ZM10 16.441c0-.796-.647-1.442-1.442-1.442H3.365c-.795 0-1.442.646-1.442 1.442v5.193c0 .795.647 1.442 1.442 1.442h5.193c.795 0 1.442-.647 1.442-1.442v-5.193Zm-1.442-4.519H3.365A3.369 3.369 0 0 1 0 8.556V3.364A3.37 3.37 0 0 1 3.365-.001h5.193a3.37 3.37 0 0 1 3.365 3.365v5.192a3.369 3.369 0 0 1-3.365 3.366ZM10 3.364c0-.795-.647-1.442-1.442-1.442H3.365c-.795 0-1.442.647-1.442 1.442v5.192c0 .796.647 1.443 1.442 1.443h5.193c.795 0 1.442-.647 1.442-1.443V3.364Zm9.038 9.712A5.968 5.968 0 0 1 25 19.037a5.969 5.969 0 0 1-5.962 5.962 5.968 5.968 0 0 1-5.961-5.962 5.968 5.968 0 0 1 5.961-5.961Zm0 10a4.043 4.043 0 0 0 4.039-4.039 4.044 4.044 0 0 0-4.039-4.038A4.043 4.043 0 0 0 15 19.037a4.043 4.043 0 0 0 4.038 4.039Z"/></svg>
                                </a>
                                <div class="aboutDocker offcanvas offcanvas-end" tabindex="-1" id="aboutDocker" aria-labelledby="<?php esc_attr_e('aboutDockerLabel','digipress'); ?>">
                                    <div class="offcanvas-header">
                                        <h5 class="offcanvas-title" id="aboutDockerLabel"><?php echo wp_kses_post($digipress_hdr_toggle_ttl); ?></h5>
                                        <button type="button" class="btn-closed text-reset" data-bs-dismiss="offcanvas" aria-label="<?php  esc_attr_e('Close','digipress'); ?>"><i class="fa fa-times"></i></button>
                                    </div>
									<?php if(!empty($digipress_hdr_toggle_content)): ?>
										<div class="offcanvas-body">
											<div>
												<?php echo wp_kses_post($digipress_hdr_toggle_content); ?>
											</div>
										</div>
									<?php endif; ?>	
                                </div>
                            </li>
							<?php endif; ?>	
                        </ul>
                    </div>
                </div>
            </nav>  
       </div> 
    </header>