<?php
defined( 'ABSPATH' ) or die();
?>	

						</div>
						<!-- /.main-content-inner-wrap -->
					</div>
					<!-- /.main-content-inner -->
				<?php 
					if( class_exists('WooCommerce') && (is_shop() || is_product()) ){
						echo '</div>';
					} else {
						echo '</main>';
					}
				?>
				<!-- /.main-content -->		
			</div>
			<!-- /.site-content -->

			<?php
				if( has_action('rb_custom_footer') && !empty( get_post_meta(get_the_id(), 'rbhf_mb_post', true)['footer'] ) ){
					do_action('rb_custom_footer');
				} else {
					if( function_exists('rb_hf_init') ){
						switch( rb_get_post_type() ){
							case 'woo_single' :
								rb_print_template( 'woo_single_custom_footer', 'footer' );
								break;
							case 'woo_archive' :
								rb_print_template( 'woo_custom_footer', 'footer' );
								break;
							case 'staff_single' :
								rb_print_template( 'rb_staff_single_custom_footer', 'footer' );
								break;
							case 'staff_archive' :
								rb_print_template( 'rb_staff_custom_footer', 'footer' );
								break;
							case 'portfolio_single' :
								rb_print_template( 'rb_portfolio_single_custom_footer', 'footer' );
								break;
							case 'portfolio_archive' :
								rb_print_template( 'rb_portfolio_custom_footer', 'footer' );
								break;
							case 'case_study_single' :
								rb_print_template( 'rb_case_study_single_custom_footer', 'footer' );
								break;
							case 'case_study_archive' :
								rb_print_template( 'rb_case_study_custom_footer', 'footer' );
								break;
							case 'blog_single' :
								rb_print_template( 'blog_single_custom_footer', 'footer' );
								break;
							case 'blog_archive' :
								rb_print_template( 'blog_custom_footer', 'footer' );
								break;
							default :
								if( get_theme_mod('custom_footer') != 'default' ){
									rb_print_template( 'custom_footer', 'footer' );
								} else {
									get_template_part( 'tmpl/footer' );
								}
								break;
						}
					} else {
						get_template_part( 'tmpl/footer' );
					}
				}
			?>

			<div class="ajax_preloader body_loader">
				<div class="dots-wrapper">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>

			<div class="button-up"></div>
		</div>
		<!-- /.site-wrapper -->

		<div id="frame">
			<span class="frame_top"></span>
			<span class="frame_right"></span>
			<span class="frame_bottom"></span>
			<span class="frame_left"></span>
		</div>
		
		<?php wp_footer() ?>
	</body>
</html>