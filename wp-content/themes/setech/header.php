<?php
defined( 'ABSPATH' ) or die();

$site_classes[] = sprintf( 'desktop-menu-%s', get_theme_mod( 'menu_mode' ) );

$is_default_sb = (is_home() || is_front_page() || (class_exists('WooCommerce') && is_shop())) || !SETECH__ACTIVE;

$custom_sidebar = rb_get_metabox('page_sidebar');
$custom_sidebar_pos = rb_get_metabox('sidebar_pos');

$sidebar = $is_default_sb ? setech__get_sidebar( get_queried_object_id() ) : setech__get_sidebar( get_queried_object_id(), $custom_sidebar, $custom_sidebar_pos );
$tb_sidebar = get_theme_mod('icon_custom_sb') ? setech__get_sidebar( get_queried_object_id(), get_theme_mod('custom_sidebar'), 'right', get_theme_mod('custom_sidebar'), true ) : '';
?>

<!DOCTYPE html>
<html <?php language_attributes() ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />

		<?php wp_head() ?>
	</head>
	<body <?php body_class() ?> data-boxed="<?php echo get_theme_mod('boxed_layout') ? 'true' : 'false'; ?>" data-default="<?php echo !SETECH__ACTIVE ? 'true' : 'false'; ?>" itemscope="itemscope" itemtype="http://schema.org/WebPage">
		<?php do_action( 'theme/above_site_wrapper' ) ?>
		
		<?php get_template_part( 'tmpl/header-search' ) ?>

		<div class="rb-blank-preloader"></div>
		<div class="body-overlay"></div>

		<?php 
			if( get_theme_mod('icon_custom_sb') && !empty($tb_sidebar) ){
				echo "<div class='custom_sidebars_wrapper'>";
					echo sprintf('%s', $tb_sidebar);
				echo "</div>";
			}
		?>

		<div id="site" class="site wrap <?php echo esc_attr( join( ' ', $site_classes ) ) ?>">
			<?php echo !empty($sidebar) && !is_attachment() ? '<div class="sidebar_trigger"><i></i></div>' : '' ?>
		
			<?php
				// Sticky
				if( has_action('rb_custom_sticky') && !empty( get_post_meta(get_the_id(), 'rbhf_mb_post', true)['sticky'] ) ){
					do_action('rb_custom_sticky');
				} else {
					if( function_exists('rb_hf_init') ){
						switch( rb_get_post_type() ){
							case 'woo_single' :
								rb_print_template( 'woo_single_custom_sticky_header', 'sticky' );
								break;
							case 'woo_archive' :
								rb_print_template( 'woo_custom_sticky_header', 'sticky' );
								break;
							case 'staff_single' :
								rb_print_template( 'rb_staff_single_custom_sticky_header', 'sticky' );
								break;
							case 'staff_archive' :
								rb_print_template( 'rb_staff_custom_sticky_header', 'sticky' );
								break;
							case 'portfolio_single' :
								rb_print_template( 'rb_portfolio_single_custom_sticky_header', 'sticky' );
								break;
							case 'portfolio_archive' :
								rb_print_template( 'rb_portfolio_custom_sticky_header', 'sticky' );
								break;
							case 'case_study_single' :
								rb_print_template( 'rb_case_study_single_custom_sticky_header', 'sticky' );
								break;
							case 'case_study_archive' :
								rb_print_template( 'rb_case_study_custom_sticky_header', 'sticky' );
								break;
							case 'blog_single' :
								rb_print_template( 'blog_single_custom_sticky_header', 'sticky' );
								break;
							case 'blog_archive' :
								rb_print_template( 'blog_custom_sticky_header', 'sticky' );
								break;
							default :
								if( get_theme_mod('custom_sticky') != 'default' ){
									rb_print_template( 'custom_sticky', 'sticky' );
								} else {
									get_template_part( 'tmpl/sticky' );
								}
								break;
						}
					} else {
						get_template_part( 'tmpl/sticky' );
					}
				}
				get_template_part( 'tmpl/sticky-mobile' );

				// Header
				if( has_action('rb_custom_header') && !empty( get_post_meta(get_the_id(), 'rbhf_mb_post', true)['header'] ) ){
					do_action('rb_custom_header');
				} else {
					if( function_exists('rb_hf_init') ){
						switch( rb_get_post_type() ){
							case 'woo_single' :
								rb_print_template( 'woo_single_custom_header', 'header' );
								break;
							case 'woo_archive' :
								rb_print_template( 'woo_custom_header', 'header' );
								break;
							case 'staff_single' :
								rb_print_template( 'rb_staff_single_custom_header', 'header' );
								break;
							case 'staff_archive' :
								rb_print_template( 'rb_staff_custom_header', 'header' );
								break;
							case 'portfolio_single' :
								rb_print_template( 'rb_portfolio_single_custom_header', 'header' );
								break;
							case 'portfolio_archive' :
								rb_print_template( 'rb_portfolio_custom_header', 'header' );
								break;
							case 'case_study_single' :
								rb_print_template( 'rb_case_study_single_custom_header', 'header' );
								break;
							case 'case_study_archive' :
								rb_print_template( 'rb_case_study_custom_header', 'header' );
								break;
							case 'blog_single' :
								rb_print_template( 'blog_single_custom_header', 'header' );
								break;
							case 'blog_archive' :
								rb_print_template( 'blog_custom_header', 'header' );
								break;
							default :
								if( get_theme_mod('custom_header') != 'default' ){
									rb_print_template( 'custom_header', 'header' );
								} else {
									get_template_part( 'tmpl/header' );
								}
								break;
						}
					} else {
						get_template_part( 'tmpl/header' );
					}
				}
				// Mobile Header
				get_template_part( 'tmpl/header-mobile' );
			?>

			<?php if( !empty( rb_get_metabox('slider_shortcode') ) ) : ?>
				<div class="rb_rev_slider container">
					<?php echo do_shortcode( rb_get_metabox('slider_shortcode') ) ?>
				</div>
			<?php endif;?>

			<div id="site-content" class="site-content">
				<!-- The main content -->
				<?php
					if( class_exists('WooCommerce') && (is_shop() || is_product()) ){
						echo '<div id="main-content" class="main-content container" itemprop="mainContentOfPage">';
					} else {
						echo '<main id="main-content" class="main-content container" itemprop="mainContentOfPage">';
					}
				?>

					<?php
						$temp_check = !empty($sidebar) && !is_attachment();

						$sidebar_classes = $temp_check ? ' has_sb' : '';
						$sidebar_classes .= $temp_check && get_theme_mod('sticky_sidebars') ? ' sticky_sb' : '';
					?>
					<div class="<?php echo sprintf('main-content-inner%s', $sidebar_classes); ?>">
							
						<?php 
							echo !empty($sidebar) && !is_attachment() ? $sidebar : '';
						?>

						<div class="main-content-inner-wrap post-type_<?php echo get_post_type() ?>">