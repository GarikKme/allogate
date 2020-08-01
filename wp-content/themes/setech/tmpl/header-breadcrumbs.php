<?php defined( 'ABSPATH' ) or die(); 

if( class_exists('WooCommerce') && is_woocommerce() ){
	echo '<div class="rb-woocommerce-ext container">';
		woocommerce_breadcrumb();
		echo '<div class="woocommerce-notices-wrapper">';
			wc_print_notices();
		echo '</div>';
	echo '</div>';
} else {
	ob_start();
		setech__dimox_breadcrumbs();
	$breadcrumbs = ob_get_clean();

	if( !empty($breadcrumbs) ){
		echo '<div class="breadcrumbs">';
			echo '<div class="container">';
				echo sprintf('%s', $breadcrumbs);
			echo '</div>';
		echo '</div>';
	}
}

?>