<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if(!defined('IMPORT_DEBUG')){
	if (defined('WP_DEBUG') && true === WP_DEBUG) {
		define('IMPORT_DEBUG', true);
	} else {
		define('IMPORT_DEBUG', false);
	}	
}

$theme = wp_get_theme();

if ($theme->get( 'Template' )) {
	define('RBIMP_THEME_SLUG', $theme->get( 'Template' ));
} else {
	define('RBIMP_THEME_SLUG', $theme->get( 'TextDomain' ));
}

define('RB_DEMO_URL', 'http://up.rainbow-themes.net');

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

// include WXR file parsers
require_once dirname( __FILE__ ) . '/parsers.php';

// get theme options
function rb_imp_get_option($name) {
	$ret = null;
	if (is_customize_preview()) {
	global $rbfw_settings;
		if (isset($rbfw_settings[$name])) {
			$ret = $rbfw_settings[$name];
			if (is_array($ret)) {
			$theme_options = get_option( $this->text_domain );
				if (isset($theme_options[$name])) {
					$to = $theme_options[$name];
						foreach ($ret as $key => $value) {
							$to[$key] = $value;
						}
					$ret = $to;
				}
			}
			return $ret;
		}
	}
	if (RBIMP_THEME_SLUG == "happykids"){
		$theme_options = get_option( RBIMP_THEME_SLUG . "_general" );
	} else {
		$theme_options = get_option( RBIMP_THEME_SLUG );
	}
	$ret = isset($theme_options[$name]) ? $theme_options[$name] : null;
	$ret = stripslashes_deep( $ret );
	return $ret;
}

function splitXml($file, $options, $chunk = '30') {
	$features = array();
	if ( isset($options['rb_features']) ) {
		$features = $options['rb_features'];
	}

	$upload_dir = wp_upload_dir();
	$xml_upload_dir = $upload_dir['basedir'] . '/rb_demo/';
	$xml_header = '<?xml version="1.0" encoding="UTF-8" ?><rss><channel><wp:wxr_version>1.2</wp:wxr_version>';
	$xml_footer = '</channel></rss>';
	if (!is_dir($xml_upload_dir)) {
		mkdir($xml_upload_dir, 0755, true);
	}
	$filesize = filesize($file);
	$content = file_get_contents($file);
	unlink($file);
	// first we build the very first xml
	$channel0 = strpos($content, '<channel>') + 9;
	$item = strpos($content, '<item>', $channel0);

	$demo_file = $xml_header . trim(substr($content, $channel0, $item - $channel0)) . $xml_footer;
	$h_demo = fopen($xml_upload_dir . 'demo00.xml', 'w+');
	fwrite($h_demo, $demo_file);
	fclose($h_demo);
	// now we have to divide items into similar chunks

	$i = 1;
	if (empty($features) || in_array('content', $features) || in_array('all', $features)) {
		$should_break = false;
		$item_e = $item + 6;
		$chunk_size = 1000*(int)$chunk;
		while(2===2) {
			$item_t = $item_e; // save temporary value as the last successfull match
			$item_e = strpos($content, '</item>', $item_e);
			if (!$item_e) {
				$item_e = $item_t - 7;
				$should_break = true;
			}
			$item_e += 7; // length of </item>
			if ($item_e - $item > $chunk_size || $should_break) {
				$demo_file = $xml_header . trim(substr($content, $item, $item_e - $item)) . $xml_footer;
				$demo_name = sprintf('demo%02d.xml', $i);
				$h_demo = fopen($xml_upload_dir . $demo_name, 'w+');
				fwrite($h_demo, $demo_file);
				fclose($h_demo);
				$i++;
				$item = $item_e;
			}
			if ($should_break) { break; }
		}
	}
	echo '<h2>Progress:</h2>';
	echo '<p>Note that the whole process can take a few minutes depending on your web-hosting provider (usually 5-7 minutes). Please, do not close this page until the process is finished.</p>';
	echo '<br/>';
	echo '<p>Importing data, please, wait...</p>';
	echo '<div class="rb_prg_cont"><p id="rb_imp_percent" style="width:0%" data-value="0">&nbsp;</p>';
	echo '<progress id="rb_imp" value="0" max="100"></progress></div>';
	$ta_style = !IMPORT_DEBUG ? ' style="display:none"' : '';
	echo '<textarea id="rb_error_log" cols="200" rows="20" readonly'.$ta_style.'></textarea>';
	echo '<div id="rb_imp_done" style="display:none">All done. Have fun!</div>';
	echo '<div id="rb_imp_err" style="display:none">Sorry, something went wrong. Most likely due to operation timeout.<br>
			You need to increase the maximum execution time of your web server. The default value is 30 seconds. Please increase it to 120 seconds. <br>
			<p><strong>Possible ways to achieve this are:</strong> <br>
			<ul>
				<li>
					* by wp-config.php edits - set_time_limit(120);</li>
				<li>
					* by htaccess edits - php_value max_execution_time 120;</li>
				<li>
					* by php.ini edits - max_execution_time = 120</li>
				<li>
					* ask your hosting commpany to take care of this for you</li>
			</ul>
			</p>	
			Or start over and try to reduce the chunk size or contact us providing your url, login and password so we could help you sort it out.</div>';
	echo '<script>startImport("'.$i.'")</script>';
}

if ( class_exists( 'WP_Importer' ) ) {
class WP_RB_Demo_Import extends WP_Importer {
	var $max_wxr_version = 1.2; // max. supported WXR version

	var $id; // WXR attachment ID
	var $uhash;
	var $working_dir;
	var $is_full;
	var $menu_id;

	// information to import from WXR file
	var $version;
	var $authors = array();
	var $posts = array();
	var $terms = array();
	var $categories = array();
	var $tags = array();
	var $base_url = '';

	var $widgets = array();
	var $custom_fields = array();
	var $options = array();
	var $options_w = array();

	// mappings from old information to new
	var $processed_authors = array();
	var $author_mapping = array();
	var $processed_terms = array();
	var $processed_posts = array();
	var $post_orphans = array();
	var $processed_menu_items = array();
	var $menu_item_orphans = array();
	var $missing_menu_items = array();

	var $fetch_attachments = true;
	var $url_remap = array();
	var $featured_images = array();

	var $upload_dir;
	var $upload_url;

	function __construct() {
	}

	/**
	 * Registered callback function for the WordPress Importer
	 *
	 * Manages the three separate stages of the WXR import process
	 */
	function dispatch() {
		$this->header();

		$step = empty( $_GET['step'] ) ? 0 : (int) $_GET['step'];
		switch ( $step ) {
			case 0:
				$this->greet();
				break;
			case 1:
				check_admin_referer( 'import-upload' ); // checking nonce
				$this->uhash = $_GET['h'];
				$this->is_full = isset($_GET['is_full']) && $_GET['is_full'] == 1 ? true : false;
				$options = '';
				$options_a = array();
				foreach ($_POST as $key => $value) {
					if (0 === strpos($key, 'rb_')) {
						if (is_string($value)) {
							$options .= '&' . $key . '=' . $value;
						}
						$options_a[$key] = $value;
					}
				}
				echo '<script>window.rb_imp = JSON.parse(\''. json_encode($options_a) .'\');';
				echo 'window.rb_imp_ajax="'. wp_create_nonce('rb_imp_ajax') .'";';
				echo '</script>';
				if (!empty($this->uhash)) {
					$this->id = download_url( RB_DEMO_URL . '/demo.php?h=' . $this->uhash  . '&full=' . ($this->is_full ? '1' : '0') . $options);
				} else {
					$this->id = $this->rb_import_handle_upload();
				}
				$ch_size = !empty($_POST['chunk_size']) ? $_POST['chunk_size'] : '30';
				splitXml($this->id, $options_a, $ch_size);
				break;
		}
		$this->footer();
	}

	function rb_import_handle_upload() {
		if ( ! isset( $_FILES['zip_import'] ) ) {
			return array(
				'error' => __( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.' )
			);
		}

		$overrides = array( 'test_form' => false, 'test_type' => false );
		$upload = wp_handle_upload( $_FILES['zip_import'], $overrides );
		if ( isset( $upload['error'] ) ) {
			return $upload;
		}
		return $upload['file'];
	}

	// Display import page title
	function header() {
		echo '<div class="wrap">';
		echo '<h2>' . __( 'Import WordPress', 'rb_demo_imp' ) . '</h2>';

		$updates = get_plugin_updates();
		$basename = plugin_basename(__FILE__);
		if ( isset( $updates[$basename] ) ) {
			$update = $updates[$basename];
			echo '<div class="error"><p><strong>';
			printf( __( 'A new version of this importer is available. Please update to version %s to ensure compatibility with newer export files.', 'rb_demo_imp' ), $update->update->new_version );
			echo '</strong></p></div>';
		}
	}

	// Close div.wrap
	function footer() {
		echo '</div>';
	}

	/**
	 * Display introductory text and file upload form
	 */

	function greet() {
		wp_nonce_field( 'import-upload' );
		echo '<div class="narrow">';
		$active_plugins = get_option('active_plugins');
		$installed_plugins = get_plugins();
		$reqd = array(
			'woocommerce/woocommerce.php' => 'WooCommerce',
			);
		$f = 0;
		$this->is_full = false;
		$woo_text = '';
		foreach ($reqd as $k => $v) {
			if (!in_array($k, $active_plugins)) {
				$f++;
				if (array_key_exists($k, $installed_plugins)) {
					$woo_text .= $v . ' is installed, but not activated.<br />';
				} else {
					$woo_text .= $v . ' is not installed. <a href="plugin-install.php?tab=search&s=' . str_replace(' ', '+', $v) . '">Click here</a> to install it.<br />';
				}
			} else {
				$woo_text .= $v . ' is activated.<br />';
			}
		}
		if ($f >= 1) {
			$woo_text .= '<p>Please note: WooCommerce plugin is not installed or activated, therefore the WooCommerce dummy data will not be imported.</p>';
		} else {
			$this->is_full = true; // 0 or 1 is good for full
		}

		$bFormNeeded = true;
		$options = '';

		/*
		*/
		$pc = rb_imp_get_option('_theme_purchase_code');
		if( empty($pc) ){
			$rb_curr_theme = wp_get_theme();
			$pc = get_option('envato_purchase_code_' . esc_html( $rb_curr_theme->get( 'TextDomain' ) ));
		}
		if (empty($pc)) { // let's propose this theme was downloaded from Envato Elements.
			$pc = "abcd1234-ab12-cwst-13en-vatoelements"; 
		}
		if (empty($pc)) {
			echo '<b><font color=red>Warning!</font></b> Please insert your <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Item Purchase Code</a> with the help of Customizer <a href="/wp-admin/customize.php?autofocus[section]=purchase_code">here</a> to proceed.';
			echo '</div>';
			return;
		} else {
			$opt_res = wp_remote_get(RB_DEMO_URL . '/t_options.php?tname=' . RBIMP_THEME_SLUG );
			if (is_wp_error($opt_res)) {
				echo '<b><font color=red>Error:</font></b> ' . $opt_res->get_error_message();
				echo '</div>';
			} else if (200 == $opt_res['response']['code'] ) {
				$options = $opt_res['body'];
				$result = wp_remote_get(RB_DEMO_URL . '/demo.php?pc=' . $pc . '&tname=' . RBIMP_THEME_SLUG );
				if (is_wp_error($result)) {
					echo '<b><font color=red>Error:</font></b> ' . $result->get_error_message();
					echo '</div>';
				}	else {
					if (200 == $result['response']['code'] ) {
						if  (26 == strlen($result['body']) ) {
							$this->uhash = $result['body'];
							$temp_demo = download_url( RB_DEMO_URL . '/demo.php?h=' . $this->uhash . '&full=' . ($this->is_full ? '1' : '0'));
							if (!is_wp_error($temp_demo) && (100*1024 < filesize($temp_demo)) ) { // it's impossible to have demo xml less than that
								$bFormNeeded = false;
							}
							unlink($temp_demo);
						} elseif (!empty($result['body'])) {		
							if(empty($pc) || $pc == "abcd1234-ab12-cwst-13en-vatoelements"){
								echo '<b><font color=red>Warning!</font></b> Please insert your <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Item Purchase Code</a> with the help of Customizer <a href="/wp-admin/customize.php?autofocus[section]=purchase_code">here</a> to proceed.';
							} else {
								echo ('<b><font color=red>Error: </font></b>');
								echo(esc_html($result['body']));
								echo ("<p>Something went wrong. The demo content cannot be imported at this time.</p>");								
							}
							return;
						} else {
							echo ('<b><font color=red>Error: </font></b>');
							echo(esc_html($result['body']));
							echo '<p>The demo content cannot be imported at this time. Your web server is unable to retreive the dummy file from ours. <br>
							Contact us at support@rbthemes.com providing your url, login and password so we could help you sort it out.</p>';
							echo '</div>';
							return;
						}
					} else {
						echo '<b><font color=red>Error code ('. $result['response']['code'] .'):</font></b> There\'s something wrong with the network.';
						echo '</div>';
						return;
					}
				}
			}
		}

		echo '<p>'.__( '<p>Thanks for choosing our products! <br>
		 This tool will import the demo content. If you want to import woocommerce products,
		 please install and activate WooCommerce plugin BEFORE running this tool.</p> Plugin summary: ', 'rb_demo_imp' ).'</p>';

		$c = 0;
		echo $woo_text;
		$url = 'admin.php' . (!$c ? '?import=rb_demo_imp&amp;step=1&amp;h='. $this->uhash .'&amp;is_full=' . ($this->is_full ? '1' : '0') : '');
?>
		<form enctype="multipart/form-data" id="import-upload-form" method="post" class="wp-form" action="<?php echo esc_url( wp_nonce_url( $url, 'import-upload' ) ); ?>">
		<label>Chunks size:</label><br>
		<select name="chunk_size">
			<option value='1'>1</option>
			<option value='10'>10</option>
			<option value='20'>20</option>
			<option value='30' selected='selected'>30</option>
		</select>
		(!) Don't change unless you were instructed to.
		<?php
			if (!empty($options)) {
				echo $options;
			}
			if ($bFormNeeded) {
				echo '<br/>Unfortunately you have to manually download this file and then select it using  the following button:<br/>';
				$this->rb_zip_upload();
			} // $bFormNeeded
			submit_button( __('Start demo content importing'), 'button' );
		?>
		</form>
<?php
		echo '</div>';
	}

	function rb_zip_upload() {
		$bytes = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
		$size = size_format( $bytes );
		$upload_dir = wp_upload_dir();
		if ( ! empty( $upload_dir['error'] ) ) :
			?><div class="error"><p><?php _e('Before you can upload your import file, you will need to fix the following error:'); ?></p>
				<p><strong><?php echo $upload_dir['error']; ?></strong></p></div><?php
			else :
			?>
			<p>
			<label for="upload"><?php _e( 'Choose a file from your computer:' ); ?></label> (<?php printf( __('Maximum size: %s' ), $size ); ?>)
			<input type="file" id="upload" accept=".xml" name="zip_import" size="25" />
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="max_file_size" value="<?php echo $bytes; ?>" />
			</p>
		<?php
		endif;
	}

	/**
	 * The main controller for the actual import stage.
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	function import( $file, $options, $id ) {
		add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
		add_filter( 'http_request_timeout', array( &$this,'bump_request_timeout' ) );

		$pc = rb_imp_get_option('_theme_purchase_code');
		$features = array();
		if ( isset($options['rb_features']) ) {
			$features = $options['rb_features'];
		}
		$this->import_start( $file );

		wp_suspend_cache_invalidation( true );
		if (!$id) {
			$this->process_categories();
			$this->process_tags();
			$this->process_users();

			if (empty($features) || in_array('theme_options', $features) || in_array('all', $features) ) {
				$this->process_options($this->options);
			}

			if (empty($features) || in_array('widgets', $features) || in_array('all', $features)) {
				$this->process_options($this->options_w);
				$this->process_widgets('widgets');
			}

			$this->process_terms();
			$this->process_widgets('custom_field');
		}

		if (empty($features) || in_array('content', $features) || in_array('all', $features)) {
			$this->process_posts();
		}
		wp_suspend_cache_invalidation( false );

		// update incorrect/missing information in the DB

		$this->import_end($file);

		if (!empty($pc)) {
			$theme_options = get_option(RBIMP_THEME_SLUG);
			$theme_options['_theme_purchase_code'] = $pc;
			update_option(RBIMP_THEME_SLUG, $theme_options);
		}

		// assign nav_menu
		if (!empty($this->menu_id)) {
			set_theme_mod('nav_menu_locations', array('header-menu' => $this->menu_id));
		}
	}

	function finalize() {
		$temp = get_option('rbimp_temp');
		if (!empty($temp)) {
			$this->processed_terms = $temp['processed_terms'];
			$this->processed_posts = $temp['processed_posts'];
			$this->post_orphans = $temp['post_orphans'];
			$this->processed_menu_items = $temp['processed_menu_items'];
			$this->menu_item_orphans = $temp['menu_item_orphans'];
			$this->missing_menu_items = $temp['missing_menu_items'];
		}
		$this->backfill_parents();
		$this->backfill_attachment_urls();
		$this->remap_featured_images();
	}

	/**
	 * Parses the WXR file and prepares us for the task of processing parsed data
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	function import_start( $file ) {
		if ( ! is_file($file) ) {
			echo '<p><strong>' . __( 'Sorry, there has been an error.', 'rb_demo_imp' ) . '</strong><br />';
			echo __( 'The file does not exist, please try again.', 'rb_demo_imp' ) . '</p>';
			$this->footer();
			die();
		}

		$import_data = $this->parse( $file );

		if ( is_wp_error( $import_data ) ) {
			echo '<p><strong>' . __( 'Sorry, there has been an error.', 'rb_demo_imp' ) . '</strong><br />';
			echo esc_html( $import_data->get_error_message() ) . '</p>';
			$this->footer();
			die();
		}

		$this->version = $import_data['version'];
		$this->get_authors_from_import( $import_data );
		$this->posts = $import_data['posts'];
		$this->terms = $import_data['terms'];
		$this->widgets = $import_data['widgets'];
		$this->custom_field = $import_data['custom_field'];
		$this->options = $import_data['options'];
		$this->options_w = $import_data['options_w'];
		$this->categories = $import_data['categories'];
		$this->users = $import_data['users'];
		$this->tags = $import_data['tags'];
		$this->base_url = esc_url( $import_data['base_url'] );

		wp_defer_term_counting( true );
		wp_defer_comment_counting( true );

		$temp = get_option('rbimp_temp');
		if (!empty($temp)) {
			$this->processed_terms = $temp['processed_terms'];
			$this->processed_posts = $temp['processed_posts'];
			$this->post_orphans = $temp['post_orphans'];
			$this->processed_menu_items = $temp['processed_menu_items'];
			$this->menu_item_orphans = $temp['menu_item_orphans'];
			$this->missing_menu_items = $temp['missing_menu_items'];
		}

		do_action( 'import_start' );
	}

	/**
	 * Performs post-import cleanup of files and the cache
	 */
	function import_end($file) {
		unlink($file);
		wp_cache_flush();
		foreach ( get_taxonomies() as $tax ) {
			delete_option( "{$tax}_children" );
			_get_term_hierarchy( $tax );
		}

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );

		$temp = array(
			'processed_terms' => $this->processed_terms,
			'processed_posts' => $this->processed_posts,
			'post_orphans' => $this->post_orphans,
			'processed_menu_items' => $this->processed_menu_items,
			'menu_item_orphans' => $this->menu_item_orphans,
			'missing_menu_items' => $this->missing_menu_items,
			);

		update_option('rbimp_temp', $temp);

		do_action( 'import_end' );
	}

	/**
	 * Handles the WXR upload and initial parsing of the file to prepare for
	 * displaying author import options
	 *
	 * @return bool False if error uploading or invalid file, true otherwise
	 */
	function handle_upload() {
		if (!empty($this->unpack_to) && array_key_exists(RBIMP_THEME_SLUG . '.xml', $this->unpack_list)) {
			$this->id = $this->unpack_to . '/' . RBIMP_THEME_SLUG . '.xml';
			$this->working_dir = $this->unpack_to;
		} else {
			$dir = $this->unpack_package(false);
		}
		return true;
	}

	function unpack_package($delete_package = true) {
		global $wp_filesystem;
		WP_Filesystem();

		if (1==1) {
		//if (is_wp_error($wp_filesystem->errors)) {
			echo $wp_filesystem->errors->get_error_code();
			$working_dir = get_template_directory() . '/demo/';
			$this->id = $working_dir . RBIMP_THEME_SLUG .'.xml';
		} else {
		$upgrade_folder = $wp_filesystem->wp_content_dir() . 'upgrade/';
		$package = $this->is_full ? RBIMP_THEME_SLUG . '.demo.full.zip' : RBIMP_THEME_SLUG . '.demo.zip';
		//$demo_url = 'http://fpostedit.com/' . $package;
		$demo_url = 'http://up.rainbow-themes.net/demo/' . $package;
		$tempname = $upgrade_folder . $package;  //wp_tempnam($demo_url);
		$response = wp_safe_remote_get( $demo_url, array( 'timeout' => 3000, 'stream' => true, 'filename' => $tempname) );
		echo 'Downloading demo content';
		if ( is_wp_error( $response ) || (isset($response['response']) && 404 === $response['response']['code']) ) {
			unlink($tempname);
			$tempname = get_template_directory() . '/demo/' . $package;
			if ( !is_readable( $tempname ) ) {
				echo 'Demo package is not available!';
				return;
			}
		}
		$upgrade_files = $wp_filesystem->dirlist($upgrade_folder);
		//We need a working directory
		$working_dir = $upgrade_folder . basename($package, '.zip');

		// Clean up working directory
		if ( $wp_filesystem->is_dir($working_dir) )
			$wp_filesystem->delete($working_dir, true);

		// Unzip package to working directory
		echo 'Unpacking demo content';
		$result = unzip_file( $tempname, $working_dir );

		// Once extracted, delete the package if required.
		unlink($tempname);

		if ( is_wp_error($result) ) {
			$wp_filesystem->delete($working_dir, true);
			if ( 'incompatible_archive' == $result->get_error_code() ) {
				return new WP_Error( 'incompatible_archive', $result->get_error_data() );
			}
			return $result;
		}
		// there should be only one file
		$array = $wp_filesystem->dirlist($working_dir);
		reset($array);
		$first_key = key($array);
		$this->id = $working_dir . '/' . $first_key;
		}
		$this->working_dir = $working_dir;
		return $working_dir;
	}


	/**
	 * Retrieve authors from parsed WXR data
	 *
	 * Uses the provided author information from WXR 1.1 files
	 * or extracts info from each post for WXR 1.0 files
	 *
	 * @param array $import_data Data returned by a WXR parser
	 */
	function get_authors_from_import( $import_data ) {
		if ( ! empty( $import_data['authors'] ) ) {
			$this->authors = $import_data['authors'];
		// no author information, grab it from the posts
		} else {
			foreach ( $import_data['posts'] as $post ) {
				$login = sanitize_user( $post['post_author'], true );
				if ( empty( $login ) ) {
					printf( __( 'Failed to import author %s. Their posts will be attributed to the current user.'."\n", 'rb_demo_imp' ), esc_html( $post['post_author'] ) );
					continue;
				}

				if ( ! isset($this->authors[$login]) )
					$this->authors[$login] = array(
						'author_login' => $login,
						'author_display_name' => $post['post_author']
					);
			}
		}
	}

	/**
	 * Create new categories based on import information
	 *
	 * Doesn't create a new category if its slug already exists
	 */
	function process_categories() {
		$this->categories = apply_filters( 'wp_import_categories', $this->categories );

		if ( empty( $this->categories ) )
			return;

		foreach ( $this->categories as $cat ) {
			// if the category already exists leave it alone
			$term_id = term_exists( $cat['category_nicename'], 'category' );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($cat['term_id']) )
					$this->processed_terms[intval($cat['term_id'])] = (int) $term_id;
				continue;
			}

			$category_parent = empty( $cat['category_parent'] ) ? 0 : category_exists( $cat['category_parent'] );
			$category_description = isset( $cat['category_description'] ) ? $cat['category_description'] : '';
			$catarr = array(
				'category_nicename' => $cat['category_nicename'],
				'category_parent' => $category_parent,
				'cat_name' => $cat['cat_name'],
				'category_description' => $category_description
			);
			$catarr = wp_slash( $catarr );

			$id = wp_insert_category( $catarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($cat['term_id']) )
					$this->processed_terms[intval($cat['term_id'])] = $id;
			} else {
				printf( __( 'Failed to import category %s'."\n", 'rb_demo_imp' ), esc_html($cat['category_nicename']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				continue;
			}
			$this->process_termmeta( $cat, $id['term_id'] );
		}

		unset( $this->categories );
	}

	function process_users() {
		if (!empty($this->users)) {
			foreach ($this->users as $key => $u) {
				$user = json_decode($u, true);
				$metas = json_decode($user['meta'], true);
				// first we add user, get his id and then add meta values
				$userdata = array(
					'user_pass' => null,
					'user_login' => $user['user_login'],
					'user_nicename' => $user['user_nicename'],
					'user_email' => $user['user_email'],
					'user_url' => $user['user_url'],
					'user_registered' => $user['user_registered'],
					'user_status' => $user['user_status'],
					'display_name' => $user['display_name'],
				);
				$user_id = wp_insert_user( $userdata );

				$replace_from = $this->get_replace_from();
				$replace_to = $this->get_replace_to();
				$this->rb_arr_replace( $metas, $replace_from, $replace_to );

				foreach ($metas as $key => $value) {
					if ('a:' === substr($value, 0, 2)) {
						$value = maybe_unserialize($value); // we have to do this, because of WP
					}
					add_user_meta($user_id, $key, $value);
				}
			}
		}
	}

	/**
	 * Create new post tags based on import information
	 *
	 * Doesn't create a tag if its slug already exists
	 */
	function process_tags() {
		$this->tags = apply_filters( 'wp_import_tags', $this->tags );

		if ( empty( $this->tags ) )
			return;

		foreach ( $this->tags as $tag ) {
			// if the tag already exists leave it alone
			$term_id = term_exists( $tag['tag_slug'], 'post_tag' );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($tag['term_id']) )
					$this->processed_terms[intval($tag['term_id'])] = (int) $term_id;
				continue;
			}

			$tag_desc = isset( $tag['tag_description'] ) ? $tag['tag_description'] : '';
			$tagarr = array( 'slug' => $tag['tag_slug'], 'description' => $tag_desc );

			$tag = wp_slash( $tag );

			$id = wp_insert_term( $tag['tag_name'], 'post_tag', $tagarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($tag['term_id']) )
					$this->processed_terms[intval($tag['term_id'])] = $id['term_id'];
			} else {
				printf( __( 'Failed to import post tag %s'."\n", 'rb_demo_imp' ), esc_html($tag['tag_name']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				continue;
			}
			$this->process_termmeta( $tag, $id['term_id'] );
		}

		unset( $this->tags );
	}

	function process_widgets($w) {
		global $wpdb;

		$this->$w = apply_filters( 'wp_import_widgets', $this->$w );

		if ( empty( $this->$w ) )
			return;

		$replace_from = $this->get_replace_from();
		$replace_to = $this->get_replace_to();

		foreach ( $this->$w as $widget ) {
			// if the tag already exists leave it alone
			$theme_options_unserialized = maybe_unserialize($widget['option_value']);
			$this->rb_arr_replace( $theme_options_unserialized, $replace_from, $replace_to );
			$widget['option_value'] = serialize($theme_options_unserialized);

			$wpdb->replace(
				$wpdb->options,
				array(
					'option_name' => $widget['option_name'],
					'option_value' => $widget['option_value'],
				),
				array(
					'%s',
					'%s'
				)
			);
		}
		unset( $this->$w );
	}

	function rb_arr_replace( &$arr, $from, $to) {
		foreach ($arr as $k => &$v) {
			if (is_array($v)) {
				//var_dump($v);
				$this->rb_arr_replace($v, $from, $to);
			} else if (is_string($v) && 'a:' === substr($v,0,2)) {
			// serialized array, let's unserialize it, process it and serialize back corrected version
				$v_arr = maybe_unserialize($v);
				$this->rb_arr_replace($v_arr, $from, $to);
				$arr[$k] = maybe_serialize($v_arr);
			} else if (is_string($v)) {
				$arr[$k] = preg_replace($from, $to, $v);
			}
		}
	}

	function get_replace_from() {
		return array(
			'/\.\.(\/wp-content\/uploads\/.*?)(["\'\s\)]|$)/',
		);
	}

	function get_replace_to() {
		return array(
			site_url() . '$1$2',
		);
	}

	function process_options($options) {
		global $wpdb;

		if (count($options) > 0) {
			echo 'Importing specific options'."\n";
		}

		$replace_from = $this->get_replace_from();
		$replace_to = $this->get_replace_to();

		foreach ( $options as $option => $value ) {
			if ('theme_options' === $option) {
				if ('happykids' === RBIMP_THEME_SLUG) {
					$option = 'happykids_general';
				} else {
					$option = RBIMP_THEME_SLUG;
				}
				$theme_options_unserialized = maybe_unserialize($value);
				$this->rb_arr_replace( $theme_options_unserialized, $replace_from, $replace_to );
				$value = serialize($theme_options_unserialized);
			}

			if ('theme_mods' === $option) {
				// update sidebars
				$option = 'theme_mods_' . RBIMP_THEME_SLUG;
				$value = maybe_unserialize($value);
				$widgets = maybe_unserialize($this->options_w);
				$widgets = maybe_unserialize($widgets['sidebars_widgets']);
				unset($widgets['array_version']);
				$value['sidebars_widgets']['data'] = $widgets;
				$value = maybe_serialize($value);
			}

			$wpdb->replace(
				$wpdb->options,
				array(
					'option_name' => $option,
					'option_value' => $value,
				),
				array(
					'%s',
					'%s'
				)
			);
			if ( 'page_on_front' === $option && !empty($value)) {
				update_option( 'show_on_front', 'page' );
			}
		}
		//unset( $options );
	}

	/**
	 * Create new terms based on import information
	 *
	 * Doesn't create a term its slug already exists
	 */
	function process_terms() {
		$this->terms = apply_filters( 'wp_import_terms', $this->terms );

		if ( empty( $this->terms ) )
			return;

		foreach ( $this->terms as $term ) {
			// if the term already exists in the correct taxonomy leave it alone
			$term_id = term_exists( $term['slug'], $term['term_taxonomy'] );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($term['term_id']) )
					$this->processed_terms[intval($term['term_id'])] = (int) $term_id;
				continue;
			}

			if ( empty( $term['term_parent'] ) ) {
				$parent = 0;
			} else {
				$parent = term_exists( $term['term_parent'], $term['term_taxonomy'] );
				if ( is_array( $parent ) ) $parent = $parent['term_id'];
			}
			$description = isset( $term['term_description'] ) ? $term['term_description'] : '';
			$termarr = array( 'slug' => $term['slug'], 'description' => $description, 'parent' => intval($parent) );

			$term = wp_slash( $term );
			$id = wp_insert_term( $term['term_name'], $term['term_taxonomy'], $termarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($term['term_id']) )
					$this->processed_terms[intval($term['term_id'])] = $id['term_id'];
			} else {
				printf( __( 'Failed to import %s %s'."\n", 'rb_demo_imp' ), esc_html($term['term_taxonomy']), esc_html($term['term_name']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				continue;
			}
			$this->process_termmeta( $term, $id['term_id'] );
		}

		unset( $this->terms );
	}

	/**
	 * Add metadata to imported term.
	 *
	 * @since 0.6.2
	 *
	 * @param array $term    Term data from WXR import.
	 * @param int   $term_id ID of the newly created term.
	 */
	protected function process_termmeta( $term, $term_id ) {
		if ( ! isset( $term['termmeta'] ) ) {
			$term['termmeta'] = array();
		}

		/**
		 * Filters the metadata attached to an imported term.
		 *
		 * @since 0.6.2
		 *
		 * @param array $termmeta Array of term meta.
		 * @param int   $term_id  ID of the newly created term.
		 * @param array $term     Term data from the WXR import.
		 */
		$term['termmeta'] = apply_filters( 'wp_import_term_meta', $term['termmeta'], $term_id, $term );

		if ( empty( $term['termmeta'] ) ) {
			return;
		}

		foreach ( $term['termmeta'] as $meta ) {
			/**
			 * Filters the meta key for an imported piece of term meta.
			 *
			 * @since 0.6.2
			 *
			 * @param string $meta_key Meta key.
			 * @param int    $term_id  ID of the newly created term.
			 * @param array  $term     Term data from the WXR import.
			 */
			$key = apply_filters( 'import_term_meta_key', $meta['key'], $term_id, $term );
			if ( ! $key ) {
				continue;
			}

			// Export gets meta straight from the DB so could have a serialized string
			$value = maybe_unserialize( $meta['value'] );

			add_term_meta( $term_id, $key, $value );

			/**
			 * Fires after term meta is imported.
			 *
			 * @since 0.6.2
			 *
			 * @param int    $term_id ID of the newly created term.
			 * @param string $key     Meta key.
			 * @param mixed  $value   Meta value.
			 */
			do_action( 'import_term_meta', $term_id, $key, $value );
		}
	}

	/**
	 * Create new posts based on import information
	 *
	 * Posts marked as having a parent which doesn't exist will become top level items.
	 * Doesn't create a new post if: the post type doesn't exist, the given post ID
	 * is already noted as imported or a post with the same title and date already exists.
	 * Note that new/updated terms, comments and meta are imported for the last of the above.
	 */
	function process_posts() {
		$this->posts = apply_filters( 'wp_import_posts', $this->posts );

		$replace_from = $this->get_replace_from();
		$replace_to = $this->get_replace_to();

		foreach ( $this->posts as $post ) {
			$post = apply_filters( 'wp_import_post_data_raw', $post );

			if ( ! post_type_exists( $post['post_type'] ) ) {
				printf( __( 'Failed to import "%s": Invalid post type %s'."\n", 'rb_demo_imp' ),
					esc_html($post['post_title']), esc_html($post['post_type']) );
				do_action( 'wp_import_post_exists', $post );
				continue;
			}

			if ( isset( $this->processed_posts[$post['post_id']] ) && ! empty( $post['post_id'] ) )
				continue;

			if ( $post['status'] == 'auto-draft' )
				continue;

			if ( 'nav_menu_item' == $post['post_type'] ) {
				$this->process_menu_item( $post );
				continue;
			}

			$post_type_object = get_post_type_object( $post['post_type'] );

			$post_exists = post_exists( $post['post_title'], '', $post['post_date'] );
			if ( $post_exists && get_post_type( $post_exists ) == $post['post_type'] ) {
				printf( __('%s "%s" already exists.'."\n", 'rb_demo_imp'), $post_type_object->labels->singular_name, esc_html($post['post_title']) );
				$comment_post_ID = $post_id = $post_exists;
				$this->processed_posts[ intval( $post['post_id'] ) ] = intval( $post_exists );
			} else {
				$post_parent = (int) $post['post_parent'];
				if ( $post_parent ) {
					// if we already know the parent, map it to the new local ID
					if ( isset( $this->processed_posts[$post_parent] ) ) {
						$post_parent = $this->processed_posts[$post_parent];
					// otherwise record the parent for later
					} else {
						$this->post_orphans[intval($post['post_id'])] = $post_parent;
						$post_parent = 0;
					}
				}

				// map the post author
				$author = sanitize_user( $post['post_author'], true );
				if ( isset( $this->author_mapping[$author] ) )
					$author = $this->author_mapping[$author];
				else
					$author = (int) get_current_user_id();

				// process content first
				$dummy_content = array($post['post_content']);

				$this->rb_arr_replace( $dummy_content, $replace_from, $replace_to );

				$post['post_content'] = $dummy_content[0];

				$postdata = array(
					'import_id' => $post['post_id'],
					'post_author' => $author,
					'post_date' => $post['post_date'],
					'post_date_gmt' => $post['post_date_gmt'],
					'post_content' => $post['post_content'],
					'post_excerpt' => $post['post_excerpt'],
					'post_title' => $post['post_title'],
					'post_status' => $post['status'],
					'post_name' => $post['post_name'],
					'comment_status' => $post['comment_status'],
					'ping_status' => $post['ping_status'],
					'guid' => $post['guid'],
					'post_parent' => $post_parent,
					'menu_order' => $post['menu_order'],
					'post_type' => $post['post_type'],
					'post_password' => $post['post_password'],
				);

				$original_post_ID = $post['post_id'];
				$postdata = apply_filters( 'wp_import_post_data_processed', $postdata, $post );

				$postdata = wp_slash( $postdata );

				if ( 'attachment' == $postdata['post_type'] ) {
					$remote_url = ! empty($post['attachment_url']) ? $post['attachment_url'] : $post['guid'];

					// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
					// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
					$postdata['upload_date'] = $post['post_date'];
					if ( isset( $post['postmeta'] ) ) {
						foreach( $post['postmeta'] as $meta ) {
							if ( $meta['key'] == '_wp_attached_file' ) {
								if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) )
									$postdata['upload_date'] = $matches[0];
								break;
							}
						}
					}

					$comment_post_ID = $post_id = $this->process_attachment( $postdata, $remote_url );
				} else {
					$comment_post_ID = $post_id = wp_insert_post( $postdata, true );
					do_action( 'wp_import_insert_post', $post_id, $original_post_ID, $postdata, $post );
				}
				if ( is_wp_error( $post_id ) ) {
					printf( __( 'Failed to import %s "%s"'."\n", 'rb_demo_imp' ),
						$post_type_object->labels->singular_name, esc_html($post['post_title']) );
						echo ': ' . $post_id->get_error_message();
					continue;
				}

				if ( $post['is_sticky'] == 1 )
					stick_post( $post_id );
			}


			// map pre-import ID to local ID
			$this->processed_posts[intval($post['post_id'])] = (int) $post_id;

			if ( ! isset( $post['terms'] ) )
				$post['terms'] = array();

			$post['terms'] = apply_filters( 'wp_import_post_terms', $post['terms'], $post_id, $post );

			// add categories, tags and other terms
			if ( ! empty( $post['terms'] ) ) {
				$terms_to_set = array();
				foreach ( $post['terms'] as $term ) {
					// back compat with WXR 1.0 map 'tag' to 'post_tag'
					$taxonomy = ( 'tag' == $term['domain'] ) ? 'post_tag' : $term['domain'];
					$term_exists = term_exists( $term['slug'], $taxonomy );
					$term_id = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
					if ( ! $term_id ) {
						$t = wp_insert_term( $term['name'], $taxonomy, array( 'slug' => $term['slug'] ) );
						if ( ! is_wp_error( $t ) ) {
							$term_id = $t['term_id'];
							do_action( 'wp_import_insert_term', $t, $term, $post_id, $post );
						} else {
							printf( __( 'Failed to import %s %s'."\n", 'rb_demo_imp' ), esc_html($taxonomy), esc_html($term['name']) );
							if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
								echo ': ' . $t->get_error_message();
							do_action( 'wp_import_insert_term_failed', $t, $term, $post_id, $post );
							continue;
						}
					}
					$terms_to_set[$taxonomy][] = intval( $term_id );
				}

				foreach ( $terms_to_set as $tax => $ids ) {
					$tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
					do_action( 'wp_import_set_post_terms', $tt_ids, $ids, $tax, $post_id, $post );
				}
				unset( $post['terms'], $terms_to_set );
			}

			if ( ! isset( $post['comments'] ) )
				$post['comments'] = array();

			$post['comments'] = apply_filters( 'wp_import_post_comments', $post['comments'], $post_id, $post );

			// add/update comments
			if ( ! empty( $post['comments'] ) ) {
				$num_comments = 0;
				$inserted_comments = array();
				foreach ( $post['comments'] as $comment ) {
					$comment_id	= $comment['comment_id'];
					$newcomments[$comment_id]['comment_post_ID']      = $comment_post_ID;
					$newcomments[$comment_id]['comment_author']       = $comment['comment_author'];
					$newcomments[$comment_id]['comment_author_email'] = $comment['comment_author_email'];
					$newcomments[$comment_id]['comment_author_IP']    = $comment['comment_author_IP'];
					$newcomments[$comment_id]['comment_author_url']   = $comment['comment_author_url'];
					$newcomments[$comment_id]['comment_date']         = $comment['comment_date'];
					$newcomments[$comment_id]['comment_date_gmt']     = $comment['comment_date_gmt'];
					$newcomments[$comment_id]['comment_content']      = $comment['comment_content'];
					$newcomments[$comment_id]['comment_approved']     = $comment['comment_approved'];
					$newcomments[$comment_id]['comment_type']         = $comment['comment_type'];
					$newcomments[$comment_id]['comment_parent'] 	  = $comment['comment_parent'];
					$newcomments[$comment_id]['commentmeta']          = isset( $comment['commentmeta'] ) ? $comment['commentmeta'] : array();
					if ( isset( $this->processed_authors[$comment['comment_user_id']] ) )
						$newcomments[$comment_id]['user_id'] = $this->processed_authors[$comment['comment_user_id']];
				}
				ksort( $newcomments );

				foreach ( $newcomments as $key => $comment ) {
					// if this is a new post we can skip the comment_exists() check
					if ( ! $post_exists || ! comment_exists( $comment['comment_author'], $comment['comment_date'] ) ) {
						if ( isset( $inserted_comments[$comment['comment_parent']] ) )
							$comment['comment_parent'] = $inserted_comments[$comment['comment_parent']];
						$comment = wp_filter_comment( $comment );
						$inserted_comments[$key] = wp_insert_comment( $comment );
						do_action( 'wp_import_insert_comment', $inserted_comments[$key], $comment, $comment_post_ID, $post );

						foreach( $comment['commentmeta'] as $meta ) {
							$value = maybe_unserialize( $meta['value'] );
							add_comment_meta( $inserted_comments[$key], $meta['key'], $value );
						}

						$num_comments++;
					}
				}
				unset( $newcomments, $inserted_comments, $post['comments'] );
			}

			if ( ! isset( $post['postmeta'] ) )
				$post['postmeta'] = array();

			$post['postmeta'] = apply_filters( 'wp_import_post_meta', $post['postmeta'], $post_id, $post );

			// add/update post meta
			if ( ! empty( $post['postmeta'] ) ) {
				foreach ( $post['postmeta'] as $meta ) {
					$key = apply_filters( 'import_post_meta_key', $meta['key'], $post_id, $post );
					$value = false;

					if ( '_edit_last' == $key ) {
						if ( isset( $this->processed_authors[intval($meta['value'])] ) )
							$value = $this->processed_authors[intval($meta['value'])];
						else
							$key = false;
					}

					if ( $key ) {
						$this->rb_arr_replace( $meta, $replace_from, $replace_to );
						// export gets meta straight from the DB so could have a serialized string
						if ( ! $value )
							$value = maybe_unserialize( $meta['value'] );

						add_post_meta( $post_id, $key, $value );
						//do_action( 'import_post_meta', $post_id, $key, $value );

						// if the post has a featured image, take note of this in case of remap
						if ( '_thumbnail_id' == $key )
							$this->featured_images[$post_id] = (int) $value;
					}
				}
			}
		}

		unset( $this->posts );
	}

		/**
	 * If fetching attachments is enabled then attempt to create a new attachment
	 *
	 * @param array $post Attachment post details from WXR
	 * @param string $url URL to fetch attachment from
	 * @return int|WP_Error Post ID on success, WP_Error otherwise
	 */
	function process_attachment( $post, $url ) {
		if ( ! $this->fetch_attachments )
			return new WP_Error( 'attachment_processing_error',
				__( 'Fetching attachments is not enabled', 'rb_demo_imp' ) );

		// if the URL is absolute, but does not contain address, then upload it assuming base_site_url
		if ( preg_match( '|^/[\w\W]+$|', $url ) )
			$url = rtrim( $this->base_url, '/' ) . $url;

		if (empty($url)) {
		//if (!empty($this->unpack_to) && array_key_exists(basename($url), $this->unpack_list)) {
			$upload_dir = wp_upload_dir();
				file_put_contents ( $upload_dir['basedir'] . '/' . $post['post_name'], base64_decode($post['post_content']) );
				$post['post_content'] = '';
			$upload = array (
				'file' => $upload_dir['basedir'] . '/' . $post['post_name'],
				'url' =>  $upload_dir['baseurl'] . '/' . $post['post_name'],
				'error' => false
				);
			$url = $upload_dir['baseurl'] . '/' . $post['post_name'];
		} else {
			$upload = $this->fetch_remote_file( $url, $post );
		}

		if ( is_wp_error( $upload ) )
			return $upload;

		if ( $info = wp_check_filetype( $upload['file'] ) )
			$post['post_mime_type'] = $info['type'];
		else
			return new WP_Error( 'attachment_processing_error', __('Invalid file type', 'rb_demo_imp') );

		$post['guid'] = $upload['url'];

		// as per wp-admin/includes/upload.php
		$post_id = wp_insert_attachment( $post, $upload['file'] );
		wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

		// remap resized image URLs, works by stripping the extension and remapping the URL stub.
		if ( preg_match( '!^image/!', $info['type'] ) ) {
			$parts = pathinfo( $url );
			$name = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

			$parts_new = pathinfo( $upload['url'] );
			$name_new = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

			$this->url_remap[$parts['dirname'] . '/' . $name] = $parts_new['dirname'] . '/' . $name_new;
		}

		return $post_id;
	}

	/**
	 * Attempt to create a new menu item from import data
	 *
	 * Fails for draft, orphaned menu items and those without an associated nav_menu
	 * or an invalid nav_menu term. If the post type or term object which the menu item
	 * represents doesn't exist then the menu item will not be imported (waits until the
	 * end of the import to retry again before discarding).
	 *
	 * @param array $item Menu item details from WXR file
	 */
	function process_menu_item( $item ) {
		// skip draft, orphaned menu items
		if ( 'draft' == $item['status'] )
			return;

		$menu_slug = false;
		if ( isset($item['terms']) ) {
			// loop through terms, assume first nav_menu term is correct menu
			foreach ( $item['terms'] as $term ) {
				if ( 'nav_menu' == $term['domain'] ) {
					$menu_slug = $term['slug'];
					break;
				}
			}
		}

		// no nav_menu term associated with this menu item
		if ( ! $menu_slug ) {
			_e( 'Menu item skipped due to missing menu slug', 'rb_demo_imp' );
			return;
		}

		$menu_id = term_exists( $menu_slug, 'nav_menu' );
		if ( ! $menu_id ) {
			printf( __( 'Menu item skipped due to invalid menu slug: %s', 'rb_demo_imp' ), esc_html( $menu_slug ) );
			return;
		} else {
			$menu_id = is_array( $menu_id ) ? $menu_id['term_id'] : $menu_id;
		}

		if (empty($this->menu_id)) {
			$this->menu_id = $menu_id;
		}

		foreach ( $item['postmeta'] as $meta ) {
			${$meta['key']} = $meta['value'];
		}

		if ( 'taxonomy' == $_menu_item_type && isset( $this->processed_terms[intval($_menu_item_object_id)] ) ) {
			$_menu_item_object_id = $this->processed_terms[intval($_menu_item_object_id)];
		} else if ( 'post_type' == $_menu_item_type && isset( $this->processed_posts[intval($_menu_item_object_id)] ) ) {
			$_menu_item_object_id = $this->processed_posts[intval($_menu_item_object_id)];
		} else if ( 'custom' != $_menu_item_type ) {
			// associated object is missing or not imported yet, we'll retry later
			$this->missing_menu_items[] = $item;
			return;
		}

		if ( isset( $this->processed_menu_items[intval($_menu_item_menu_item_parent)] ) ) {
			$_menu_item_menu_item_parent = $this->processed_menu_items[intval($_menu_item_menu_item_parent)];
		} else if ( $_menu_item_menu_item_parent ) {
			$this->menu_item_orphans[intval($item['post_id'])] = (int) $_menu_item_menu_item_parent;
			$_menu_item_menu_item_parent = 0;
		}

		// wp_update_nav_menu_item expects CSS classes as a space separated string
		$_menu_item_classes = maybe_unserialize( $_menu_item_classes );
		if ( is_array( $_menu_item_classes ) )
			$_menu_item_classes = implode( ' ', $_menu_item_classes );

		$args = array(
			'menu-item-object-id' => $_menu_item_object_id,
			'menu-item-object' => $_menu_item_object,
			'menu-item-parent-id' => $_menu_item_menu_item_parent,
			'menu-item-position' => intval( $item['menu_order'] ),
			'menu-item-type' => $_menu_item_type,
			'menu-item-title' => $item['post_title'],
			'menu-item-url' => $_menu_item_url,
			'menu-item-description' => $item['post_content'],
			'menu-item-attr-title' => $item['post_excerpt'],
			'menu-item-target' => $_menu_item_target,
			'menu-item-classes' => $_menu_item_classes,
			'menu-item-xfn' => $_menu_item_xfn,
			'menu-item-status' => $item['status']
		);

		$id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( $id && ! is_wp_error( $id ) ) {
			$this->processed_menu_items[intval($item['post_id'])] = (int) $id;
		}
	}

	/**
	 * Attempt to download a remote file attachment
	 *
	 * @param string $url URL of item to fetch
	 * @param array $post Attachment details
	 * @return array|WP_Error Local file location details on success, WP_Error otherwise
	 */
	function fetch_remote_file( $url, $post ) {
		// extract the file name and extension from the url
		$file_name = basename( $url );

		// get placeholder file in the upload dir with a unique, sanitized filename
		$upload_date = $post['upload_date'];
		preg_match('/uploads\/(\d{4})\/(\d{2})/', $url, $matches);
		if (!empty($matches)) {
			$upload_date = $matches[1] . '/' . $matches[2];
		}
		$upload = wp_upload_bits( $file_name, 0, '', $upload_date);
		if ( $upload['error'] )
			return new WP_Error( 'upload_dir_error', $upload['error'] );

		// fetch the remote url and write it to the placeholder file
		//$headers = wp_get_http( $url, $upload['file'] );

		$response = wp_remote_get($url, array(
			'timeout'     => 120,
			'httpversion' => '1.1',
		));

		// request failed
		if ( ! $response ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', __('Remote server did not respond', 'rb_demo_imp') );
		}

		// make sure the fetch was successful
		$status =  wp_remote_retrieve_response_code( $response );
		if ( $status != '200' ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', sprintf( __('Remote server returned error response %1$d %2$s', 'rb_demo_imp'), esc_html($response['response']), get_status_header_desc($response['response']) ) );
		}

		$out_fp = fopen($upload['file'], 'w+');
    if ( !$out_fp ) {
			return new WP_Error( 'import_file_error', sprintf(__('Failed to open %s', 'rb_demo_imp'), $upload['file'] ) );
    }

    fwrite( $out_fp, wp_remote_retrieve_body(  $response ) );
    fclose($out_fp);
    clearstatcache();

		$filesize = filesize( $upload['file'] );

		$headers = wp_remote_retrieve_headers( $response );
		$headers = $headers->getAll();

		// if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
		// 	@unlink( $upload['file'] );
		// 	return new WP_Error( 'import_file_error', __('Remote file is incorrect size', 'rb_demo_imp') );
		// }

		if ( 0 == $filesize ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', __('Zero size file downloaded', 'rb_demo_imp') );
		}

		$max_size = (int) $this->max_attachment_size();
		if ( ! empty( $max_size ) && $filesize > $max_size ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', sprintf(__('Remote file is too large, limit is %s', 'rb_demo_imp'), size_format($max_size) ) );
		}

		// keep track of the old and new urls so we can substitute them later
		$this->url_remap[$url] = $upload['url'];
		$this->url_remap[$post['guid']] = $upload['url']; // r13735, really needed?
		// keep track of the destination if the remote url is redirected somewhere else
		if ( isset($headers['x-final-location']) && $headers['x-final-location'] != $url )
			$this->url_remap[$headers['x-final-location']] = $upload['url'];

		return $upload;
	}

	function get_http( $url, $file_path = false, $red = 1 ) {
		@set_time_limit( 60 );

		if ( $red > 5 )
			return false;

		$options = array();
		$options['redirection'] = 5;

		if ( false == $file_path )
			$options['method'] = 'HEAD';
		else
			$options['method'] = 'GET';

		//$response = wp_safe_remote_request( $url, $options );
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) )
			return false;

		$headers = wp_remote_retrieve_headers( $response );
		$headers['response'] = wp_remote_retrieve_response_code( $response );

		/*
		// WP_HTTP no longer follows redirects for HEAD requests.
		if ( 'HEAD' == $options['method'] && in_array($headers['response'], array(301, 302)) && isset( $headers['location'] ) ) {
			return $this->get_http( $headers['location'], $file_path, ++$red );
		}
		*/

		if ( false == $file_path )
			return $headers;

		// GET request - write it to the supplied filename
		$out_fp = fopen($file_path, 'w');
		if ( !$out_fp )
			return $headers;


		fwrite( $out_fp, wp_remote_retrieve_body( $response ) );
		fclose($out_fp);
		clearstatcache();

		return $headers;
	}

	/**
	 * Attempt to associate posts and menu items with previously missing parents
	 *
	 * An imported post's parent may not have been imported when it was first created
	 * so try again. Similarly for child menu items and menu items which were missing
	 * the object (e.g. post) they represent in the menu
	 */
	function backfill_parents() {
		global $wpdb;

		// find parents for post orphans
		foreach ( $this->post_orphans as $child_id => $parent_id ) {
			$local_child_id = $local_parent_id = false;
			if ( isset( $this->processed_posts[$child_id] ) )
				$local_child_id = $this->processed_posts[$child_id];
			if ( isset( $this->processed_posts[$parent_id] ) )
				$local_parent_id = $this->processed_posts[$parent_id];

			if ( $local_child_id && $local_parent_id ) {
				$wpdb->update( $wpdb->posts, array( 'post_parent' => $local_parent_id ), array( 'ID' => $local_child_id ), '%d', '%d' );
				unset($this->post_orphans[$child_id]);
			}
		}

		// all other posts/terms are imported, retry menu items with missing associated object
		$missing_menu_items = $this->missing_menu_items;
		foreach ( $missing_menu_items as $item )
			$this->process_menu_item( $item );

		// find parents for menu item orphans
		foreach ( $this->menu_item_orphans as $child_id => $parent_id ) {
			$local_child_id = $local_parent_id = 0;
			if ( isset( $this->processed_menu_items[$child_id] ) )
				$local_child_id = $this->processed_menu_items[$child_id];
			if ( isset( $this->processed_menu_items[$parent_id] ) )
				$local_parent_id = $this->processed_menu_items[$parent_id];

			if ( $local_child_id && $local_parent_id ) {
				update_post_meta( $local_child_id, '_menu_item_menu_item_parent', (int) $local_parent_id );
				unset($this->menu_item_orphans[$child_id]);
			}
		}
	}

	/**
	 * Use stored mapping information to update old attachment URLs
	 */
	function backfill_attachment_urls() {
		global $wpdb;
		// make sure we do the longest urls first, in case one is a substring of another
		uksort( $this->url_remap, array(&$this, 'cmpr_strlen') );

		foreach ( $this->url_remap as $from_url => $to_url ) {
			// remap urls in post_content
			$wpdb->query( $wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url) );
			// remap enclosure urls
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url) );
		}
	}

	/**
	 * Update _thumbnail_id meta to new, imported attachment IDs
	 */
	function remap_featured_images() {
		// cycle through posts that have a featured image
		foreach ( $this->featured_images as $post_id => $value ) {
			if ( isset( $this->processed_posts[$value] ) ) {
				$new_id = $this->processed_posts[$value];
				// only update if there's a difference
				if ( $new_id != $value )
					update_post_meta( $post_id, '_thumbnail_id', $new_id );
			}
		}
	}

	/**
	 * Parse a WXR file
	 *
	 * @param string $file Path to WXR file for parsing
	 * @return array Information gathered from the WXR file
	 */
	function parse( $file ) {
		$parser = new RB_WXR_Parser();
		return $parser->parse( $file );
	}

	/**
	 * Decide if the given meta key maps to information we will want to import
	 *
	 * @param string $key The meta key to check
	 * @return string|bool The key if we do want to import, false if not
	 */
	function is_valid_meta_key( $key ) {
		// skip attachment metadata since we'll regenerate it from scratch
		// skip _edit_lock as not relevant for import
		if ( in_array( $key, array( '_wp_attached_file', '_wp_attachment_metadata', '_edit_lock' ) ) )
			return false;
		return $key;
	}

	/**
	 * Decide whether or not the importer is allowed to create users.
	 * Default is true, can be filtered via import_allow_create_users
	 *
	 * @return bool True if creating users is allowed
	 */
	function allow_create_users() {
		return apply_filters( 'import_allow_create_users', true );
	}

	/**
	 * Decide whether or not the importer should attempt to download attachment files.
	 * Default is true, can be filtered via import_allow_fetch_attachments. The choice
	 * made at the import options screen must also be true, false here hides that checkbox.
	 *
	 * @return bool True if downloading attachments is allowed
	 */
	function allow_fetch_attachments() {
		return apply_filters( 'import_allow_fetch_attachments', true );
	}

	/**
	 * Decide what the maximum file size for downloaded attachments is.
	 * Default is 0 (unlimited), can be filtered via import_attachment_size_limit
	 *
	 * @return int Maximum attachment file size to import
	 */
	function max_attachment_size() {
		return apply_filters( 'import_attachment_size_limit', 0 );
	}

	/**
	 * Added to http_request_timeout filter to force timeout at 60 seconds during import
	 * @return int 60
	 */
	function bump_request_timeout($val) {
		return 60;
	}

	// return the difference in length between two strings
	function cmpr_strlen( $a, $b ) {
		return strlen($b) - strlen($a);
	}
}

} // class_exists( 'WP_Importer' )
