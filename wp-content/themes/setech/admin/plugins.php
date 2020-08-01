<?php
require_once( get_template_directory() . '/admin/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'setech_register_required_plugins' );

// Check plugin's version
function rb_check_plugin_version ( $plugin ){

	$opt_res = get_option('rb_plugin_ver', true);

	if (!empty($opt_res['data']) ){
		$rb_chk_ver = array();
		wp_parse_str( $opt_res['data'], $rb_chk_ver );
	}

	if(!empty($rb_chk_ver[$plugin])){
		return $rb_chk_ver[$plugin];
	} else {
		switch ($plugin) {
			case 'revslider':
				$rb_chk_ret = "6.1.2";
				break;
			case 'js_composer':
				$rb_chk_ret = "6.0.5";
				break;			
			default:
				break;
		}
		return $rb_chk_ret;
	}
}
// \Check plugin's version

function setech_register_required_plugins() {
	global $rb_theme_funcs;
	$plugins = array(
		array(
			'name'					=> esc_html__('RB Essentials','setech'), // The plugin name
			'slug'					=> 'rb-essentials', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/rb-essentials.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),		
		array(
			'name'					=> esc_html__('RB Mega Menu','setech'), // The plugin name
			'slug'					=> 'rb-megamenu', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/rb-megamenu.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),			
		array(
			'name'					=> esc_html__('RB Demo Importer','setech'), // The plugin name
			'slug'					=> 'rb-demo-importer', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/rb-demo-importer.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__('RB Flaticons','setech'), // The plugin name
			'slug'					=> 'rb-flaticons', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/rb-flaticons.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__('RB SVG Icons','setech'), // The plugin name
			'slug'					=> 'rb-svg-icons', // The plugin slug (typically the folder name)
			'source'				=> get_template_directory() . '/plugins/rb-svg-icons.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),	
		array(
			'name'					=> esc_html__('Revolution Slider','setech'), // The plugin name
			'slug'					=> 'revslider', // The plugin slug (typically the folder name)
			'source'				=> 'http://up.rainbow-themes.net/plugins/revslider.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> rb_check_plugin_version('revslider'),
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://up.rainbow-themes.net/plugins/', // If set, overrides default API URL and points to an external URL
		),		
		array(
			'name'					=> esc_html__( 'WPBakery Visual Composer', 'setech' ), // The plugin name
			'slug'					=> 'js_composer', // The plugin slug (typically the folder name)
			'source'				=> 'http://up.rainbow-themes.net/plugins/js_composer.zip', // The plugin source
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> rb_check_plugin_version('js_composer'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'			=> 'http://up.rainbow-themes.net/plugins/', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'					=> esc_html__('WPForms Lite','setech'), // The plugin name
			'slug'					=> 'wpforms-lite', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'					=> esc_html__('WP Google Maps','setech'), // The plugin name
			'slug'					=> 'wp-google-maps', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
	);

	/**
		* Array of configuration settings. Amend each line as needed.
		* If you want the default strings to be available under your own theme domain,
		* leave the strings uncommented.
		* Some of the strings are added into a sprintf, so see the comments at the
		* end of each line for what each argument will be.
		*/
	$config = array(
		'domain'				=> 'setech',						// Text domain - likely want to be the same as your theme.
		'default_path' 			=> '',								// Default absolute path to pre-packaged plugins
		'menu'					=> 'install-required-plugins', 		// Menu slug
		'has_notices'			=> true,							// Show admin notices or not
		'is_automatic'			=> false,							// Automatically activate plugins after installation or not
		'message' 				=> '',								// Message to output right before the plugins table
		'strings'				=> array(
			'page_title'						=> esc_html__( 'Install Required Plugins', 'setech' ),
			'menu_title'						=> esc_html__( 'Install Plugins', 'setech' ),
			'installing'						=> esc_html__( 'Installing Plugin: %s', 'setech' ), // %1$s = plugin name
			'oops'								=> esc_html__( 'Something went wrong with the plugin API.', 'setech' ),
			'notice_can_install_required'		=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'setech' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'	=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'setech' ), // %1$s = plugin name(s)
			'notice_cannot_install'				=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'setech' ), // %1$s = plugin name(s)
			'notice_can_activate_required'		=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'setech' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'	=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'setech' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 			=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'setech' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 				=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'setech' ), // %1$s = plugin name(s)
			'notice_cannot_update' 				=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'setech' ), // %1$s = plugin name(s)
			'install_link' 						=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'setech' ),
			'activate_link' 					=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'setech' ),
			'return'							=> esc_html__( 'Return to Required Plugins Installer', 'setech' ),
			'plugin_activated'					=> esc_html__( 'Plugin activated successfully.', 'setech' ),
			'complete' 							=> esc_html__( 'All plugins installed and activated successfully. %s', 'setech' ), // %1$s = dashboard link
			'nag_type'							=> 'updated',// Determines admin notice type - can only be 'updated' or 'error'
		),
	);

	tgmpa( $plugins, $config );

}
?>
