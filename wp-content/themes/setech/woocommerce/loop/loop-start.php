<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_carousel = false;
$carousel_data = '';

if( is_product() && get_theme_mod('related_products_carousel') && get_theme_mod('woo_related_count') > get_theme_mod('woo_related_cols') ){
	$is_carousel = true;
	$carousel_data .= ' data-columns="'.get_theme_mod('woo_related_cols').'"';
	$carousel_data .= ' data-tablet-portrait="3"';
	$carousel_data .= ' data-mobile="1"';
	$carousel_data .= ' data-slides-to-scroll="'.get_theme_mod('related_products_slides_to_scroll').'"';
	$carousel_data .= ' data-pagination="on"';
	$carousel_data .= ' data-navigation="off"';
	$carousel_data .= ' data-draggable="on"';
	if( get_theme_mod('related_products_autoplay_speed') && get_theme_mod('related_products_autoplay_speed') != '0' ){
		$carousel_data .= ' data-autoplay="on"';
		$carousel_data .= ' data-autoplay-speed="'.(get_theme_mod('related_products_autoplay_speed') * 1000).'"';
		$carousel_data .= ' data-pause-on-hover="on"';
	}
}

?>

<?php if( $is_carousel ) echo '<div class="rb_carousel_wrapper"'.$carousel_data.'>'; ?>
	<ul class="products columns-<?php echo is_product() || is_cart() ? esc_attr( get_theme_mod('woo_related_cols') ) : esc_attr( get_theme_mod('woo_archive_cols') ); ?><?php if( $is_carousel ) echo ' rb_carousel'; ?>">