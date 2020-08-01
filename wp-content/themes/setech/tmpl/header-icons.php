<?php defined( 'ABSPATH' ) or die(); ?>

<?php if( get_theme_mod('icon_custom_sb') ) : ?>
<!-- Call Sidebar Icon -->
<a href="#" class="custom_sidebar_trigger" data-sidebar="<?php echo get_theme_mod('custom_sidebar') ?>">
	<i class='rbicon-more'></i>
	<span class="hidden_title"></span>
</a>
<?php endif; ?>

<?php if( class_exists('WooCommerce') && get_theme_mod('woo_cart') ) :
	$rb_woocommerce = new Setech_WooExt();
?>

	<!-- Mini Cart Icon -->
	<?php echo sprintf('%s', $rb_woocommerce->rb_woocommerce_get_mini_cart()) ?>

<?php endif;

if( class_exists('SitePress') ){
	do_action('wpml_add_language_selector');
}