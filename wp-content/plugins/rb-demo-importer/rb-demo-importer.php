<?php
/*
Plugin Name: RB Demo Importer
Plugin URI: http://rainbow-themes.net/
Description: Imports demo content for Rainbow-Themes items.
Text Domain: rb_demo_imp
Version: 1.0.1
*/

if (!defined('RB_IMP_PLUGIN_NAME'))
	define('RB_IMP_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('RB_IMP_PLUGIN_DIR'))
	define('RB_IMP_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . RB_IMP_PLUGIN_NAME);

if (!defined('RB_IMP_PLUGIN_URL'))
	define('RB_IMP_PLUGIN_URL', WP_PLUGIN_URL . '/' . RB_IMP_PLUGIN_NAME);


add_action( 'admin_init', 'register_importers' );

function register_importers() {
	register_importer( 'rb_demo_imp', esc_html__( 'RB Demo Importer', 'rb_demo_imp' ), esc_html__( 'Import RB-theme\'s demo content.', 'rb_demo_imp'), 'rb_importer' );
}

add_action( 'admin_enqueue_scripts', 'rb_imp_enqueue', 11);

function rb_imp_enqueue($h) {
	if ('admin.php' === $h) {
		if (isset($_GET['import']) && 'rb_demo_imp' === $_GET['import'] && isset($_GET['step']) && '1' === $_GET['step']) {
			wp_enqueue_script( 'rb-imp-js',  RB_IMP_PLUGIN_URL . '/imp.js' );
			wp_enqueue_style( 'rb-imp-css',  RB_IMP_PLUGIN_URL . '/imp.css' );
		}
	}
}

function rb_importer() {
	require_once dirname( __FILE__ ) . '/importer.php';
	// Dispatch
	$importer = new WP_RB_Demo_Import();
	$importer->dispatch();
}

add_action( 'wp_ajax_rb_imp_run', 'rb_imp_run' );

function rb_imp_run() {
	if ( wp_verify_nonce( $_REQUEST['nonce'], 'rb_imp_ajax') ) {
		$id = $_POST['id'];
		$options = isset($_POST['options']) ? $_POST['options'] : array();
		$upload_dir = wp_upload_dir();
		$xml_upload_dir = $upload_dir['basedir'] . '/rb_demo/';
		$demo_f = sprintf($xml_upload_dir. 'demo%02d.xml', $id);
		require_once dirname( __FILE__ ) . '/importer.php';
		$importer = new WP_RB_Demo_Import();
		if (file_exists($demo_f)) {
			$importer->id = $demo_f;
			$messages = '';
			ob_start();
			$importer->import( $importer->id, $options, $id );
			$messages = ob_get_clean();
			if (!is_string($messages)) {
				$messages = '';
			}
			echo json_encode(array('id' => $id, 'messages' => $messages));
		} else {
			$importer->finalize();
			delete_option('rbimp_temp');
		}
	}
	die();
}
?>