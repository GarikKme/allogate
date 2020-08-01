<?php 
	defined( 'ABSPATH' ) or die();
?>

<!-- #site-footer -->
<div id="site-footer" class="site-footer<?php echo get_theme_mod("sticky_footer") ? " sticky_footer" : "" ?>">
	<div class="container">
		<div class="footer-copyright">
			<a class="footer-logo" href="<?php echo esc_url(home_url( '/' )) ?>">
				<?php setech_logo('footer_logotype', 'footer_logo_dimensions', 'h3') ?>
			</a>
			<p class="copyright-info"><?php echo get_theme_mod('copyright_text'); ?></p>
			<?php if( class_exists('SitePress') ) do_action( 'wpml_footer_language_selector'); ?>
		</div>
	</div>
</div>
<!-- /#site-footer -->