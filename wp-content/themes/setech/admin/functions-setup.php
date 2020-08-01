<?php
defined( 'ABSPATH' ) or die();

// Register theme's assets
add_action( 'admin_init', 'setech__setup_admin_assets' );

// Register script for custom widget`s
add_action('admin_enqueue_scripts', 'setech__widgets_script');

// Register script for custom metaboxes
add_action('admin_enqueue_scripts', 'setech__metaboxes_script');

/**
 * Register scripts and styles for the theme
 *
 * @return  void
 */
function setech__setup_admin_assets($a) {
	// Font Awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/fonts/fa/font-awesome.min.css', array(), '5.12.1', 'all' );

	// Flaticon
	$rbfi = get_option('rbfi');
	if( !empty($rbfi) && isset($rbfi['css']) ){
		wp_enqueue_style( 'rbfi-css', $rbfi['css'], array(), SETECH__VERSION, 'all' );
	} else {
		wp_enqueue_style( 'admin-flaticon', get_template_directory_uri() . '/assets/fonts/flaticons/style.css', array(), SETECH__VERSION, 'all' );
	};

	// Admin`s gutenberg styles
	wp_enqueue_style( 'admin-gutenberg', get_template_directory_uri() . '/admin/css/gutenberg.css', array(), SETECH__VERSION, 'all' );

	// Admin`s custom styles 
	wp_enqueue_style( 'admin-meta', get_template_directory_uri() . '/admin/css/metaboxes.css', array(), SETECH__VERSION, 'all' );

	// Admin`s visual composer styles
	wp_enqueue_style( 'admin-vc', get_template_directory_uri() . '/admin/css/vc.css', array(), SETECH__VERSION, 'all' );
}

/**
 * Register scripts for custom widgets
 *
 * @return  void
 */
function setech__widgets_script() {
    wp_enqueue_media();
    wp_enqueue_script( 'widgets-script', get_template_directory_uri() . '/admin/js/widgets.js', false, SETECH__VERSION, true );
	wp_enqueue_style( 'widgets-css', get_template_directory_uri() . '/admin/css/widgets.css', array(), SETECH__VERSION, 'all' );
}

/**
 * Register scripts for custom widgets
 *
 * @return  void
 */
function setech__metaboxes_script() {
	if ( !did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
    wp_enqueue_script( 'metaboxes-script', get_template_directory_uri() . '/admin/js/metaboxes.js', false, SETECH__VERSION, true );
}