<?php 
defined( 'ABSPATH' ) or die(); ?>

<!-- #site-sticky-mobile -->
<div id="site-sticky-mobile" class="site-sticky sticky-mobile <?php echo get_theme_mod('sticky_shadow') ? 'shadow' : '' ?>">
	<div class="container">
		<a class="site_logotype" href="<?php echo esc_url(home_url( '/' )) ?>">
			<?php setech_logo('mobile_top_bar_logotype', 'mobile_top_bar_logo_dimensions', 'h3') ?>
		</a>
		<div class="header_icons">
			<?php if( class_exists('WooCommerce') && get_theme_mod('mobile_show_minicart') ) :
				$rb_woocommerce = new Setech_WooExt();

				echo sprintf('%s', $rb_woocommerce->rb_woocommerce_get_mini_cart());
			endif; ?>
			<div class="menu-trigger">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
</div>
<!-- \#site-sticky-mobile -->