<?php
/*
Plugin Name: RB Essentials
Description: Internal use for rbthemes themes only.
Version:     1.0.1
Author:      Rainbow-Themes
Author URI:  http://rainbow-themes.net
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: rb-essentials
*/
if( !defined('ABSPATH') ){
	exit;
}

require_once( 'metaboxes/metaboxes_exec.php' );
require_once( 'rb_headers.php' );
require_once( 'rb_staff.php' );
require_once( 'rb_portfolio.php' );
require_once( 'rb_case_study.php' );

if ( !class_exists( "RB_Essentials" ) ){
	class RB_Essentials {

		public function __construct(){
			add_action( 'wp_head', array( $this, 'rb_ajaxurl' ) );
		}

		public function rb_ajaxurl() {
		    echo '<script type="text/javascript">
		           var rb_ajaxurl = "' . admin_url('admin-ajax.php') . '";
		         </script>';
		}

		public function rb_register_widgets( $widgets ){
			foreach( $widgets as $w ){
				$php = SETECH__PLUGINS_DIR . 'rb-essentials/widgets/' . strtolower($w) . '.php';

				if( file_exists($php) ){
					require_once $php;
					register_widget($w);
				}
			}
		}

		public function rb_get_file_contents( $file ){
			return file_get_contents($file);
		}
		
	}
}

$essentials = new RB_Essentials();

?>