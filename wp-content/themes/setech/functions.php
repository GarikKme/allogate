<?php
defined( 'ABSPATH' ) or exit;

// Theme constants
define( 'SETECH__PATH', trailingslashit( get_template_directory() ) );
define( 'SETECH__URI', trailingslashit( get_template_directory_uri() ) );
define( 'SETECH__PLUGINS_DIR', ABSPATH . 'wp-content/plugins/' );
define( 'SETECH__ACTIVE', class_exists('RB_Essentials') );
define( 'SETECH__VERSION', '1.0.0' );
define( 'SETECH__ID', 'setech' );


// Action to load the theme translation
add_action( 'after_setup_theme', 'setech__translation_import', 5 );

/**
 * Load the translation files into the theme textdomain
 *
 * @return  void
 */
function setech__translation_import() {
	load_theme_textdomain( 'setech', get_template_directory() . '/languages' );
}

/**
 * We must check PHP version to ensure the theme can
 * be worked fine
 */
if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
	// Register action to checking theme requirements
	add_action( 'after_switch_theme', 'setech__requirement_check', 10, 2 );

	// Action to sending a notice while hosting does
	// not meet the minimum requires
	add_action( 'admin_notices', 'setech__requirement_notice' );

	/**
	 * Check the theme requirements
	 *
	 * @param   string  $name   Theme's name
	 * @param   object  $theme  The theme object
	 *
	 * @return  void
	 */
	function setech__requirement_check( $name, $theme ) {
		// Switch back to previous theme
		switch_theme( $theme->stylesheet );
	}

	/**
	 * Show the warning message when hosting environment doesn't
	 * meet the theme minimum requires.
	 *
	 * @return  void
	 */
	function setech__requirement_notice() {
		printf( '<div class="error"><p>%s</p></div>',
			esc_html__( 'Sorry! Your server does not meet the minimum requirements, please upgrade PHP version to 5.6 or higher', 'setech' ) );
	}

	return;
}


// The base classes
require_once SETECH__PATH . 'inc/functions-helpers.php';
require_once SETECH__PATH . 'inc/functions-template.php';

require_once SETECH__PATH . 'assets/fonts/default_fonts.php';
require_once SETECH__PATH . 'inc/functions-helpers-styles.php';
require_once SETECH__PATH . 'inc/functions-custom-icons.php';
require_once SETECH__PATH . 'inc/functions-blog.php';

//  Welcome page
require_once SETECH__PATH . 'admin/rb-welcome-page.php';

// Theme customize setup
require_once SETECH__PATH . 'admin/customize/functions-customize.php';

// Theme setup
require_once SETECH__PATH . 'inc/functions-setup.php';

if( is_admin() ) {
	require_once SETECH__PATH . 'admin/plugins.php';
	require_once SETECH__PATH . 'admin/functions-setup.php';
}

// Woocommerce
if( class_exists('WooCommerce') ){
	require_once SETECH__PATH . 'woocommerce/wooinit.php';
}

// WPBakery Page Builder
if( class_exists('Vc_Manager') ){
	$vc_man = Vc_Manager::getInstance();
	$vc_man->disableUpdater(true);
	if (!isset($_COOKIE['vchideactivationmsg_vc11'])) {
		setcookie('vchideactivationmsg_vc11', WPB_VC_VERSION);
	}
	require_once( get_template_directory() . '/vc/rb_vc_config.php' );
}

