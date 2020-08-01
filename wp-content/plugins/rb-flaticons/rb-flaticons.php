<?php
/*
Plugin Name: RB Flaticons
Description: Adds Flaticon font library support.
Text Domain: rb_flaticons
Version: 1.0.0
*/


if (!defined('CWS_FI_THEME_DIR'))
	define('CWS_FI_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('CWS_FI_PLUGIN_NAME'))
	define('CWS_FI_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('CWS_FI_PLUGIN_DIR'))
	define('CWS_FI_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . CWS_FI_PLUGIN_NAME);

if (!defined('CWS_FI_PLUGIN_URL'))
	define('CWS_FI_PLUGIN_URL', WP_PLUGIN_URL . '/' . CWS_FI_PLUGIN_NAME);

$theme = wp_get_theme();
if ($theme->get( 'Template' )) {
	define('CWSFI_THEME_SLUG', $theme->get( 'Template' ));
} else {
	define('CWSFI_THEME_SLUG', $theme->get( 'TextDomain' ));
}

add_action('admin_menu', 'rb_fi_plugin_menu');

function rb_fi_plugin_menu() {
	add_theme_page('RB FlatIcon Options', 'RB FlatIcons', 'edit_theme_options', 'rb_flaticons', 'rb_fi_page');
}

function rb_fi_page() {
	if (isset($_FILES['zip_import'])) {
		global $wp_filesystem;
		WP_Filesystem();

		$upload = wp_handle_upload( $_FILES['zip_import'], array( 'test_form' => false, 'test_type' => false ) );
		if ( isset( $upload['error'] ) ) { return; }

		$upload_dir = wp_upload_dir();
		$font_folder = $upload_dir['basedir'] . '/rb-flaticons/';
		if ( $wp_filesystem->is_dir($font_folder) )
			$wp_filesystem->delete($font_folder, true);
		$result = unzip_file( $upload['file'], $font_folder );
		unlink($upload['file']);
		$fi_css = $font_folder . 'font/flaticon.css';

		$rdi = new RecursiveDirectoryIterator($font_folder);
		foreach(new RecursiveIteratorIterator($rdi) as $file) {
			$fname = strtolower($file->getFilename());
			if ('flaticon.css' === $fname) {
				$path = str_replace('\\', '/', $file->getPathname() );
				$rel_path = substr($path, strpos($path , '/rb-flaticons/') );
				$fi_css = $upload_dir['basedir'] . $rel_path;
			} else if (0 !== strpos($fname, 'flaticon') && 0 !== strpos($fname, '.') ) {
				unlink($file->getPathname());
			}
		}
		$out = null;
		if ( $wp_filesystem && $wp_filesystem->exists($fi_css) ) {
			$fi_content = $wp_filesystem->get_contents($fi_css);

			// remove filesize and margins
			$ficss_class = strpos($fi_content, '[class^="flaticon-"]:before');
			$ficss_class = strpos($fi_content, '{', $ficss_class) + 1;
			$ficss_class_end = strpos($fi_content, '}', $ficss_class);
			$fi_content = substr($fi_content, 0, $ficss_class) . 'font-family: Flaticon;font-style: normal;' . substr($fi_content, $ficss_class_end);

			$fi_file = fopen($fi_css, 'w+');
			fwrite($fi_file, $fi_content);
			fclose($fi_file);

			if ( preg_match_all( "/flaticon-((\w+|-?)+):before/", $fi_content, $matches, PREG_PATTERN_ORDER ) ){
				$out = array( 'td' => time(),
					'css' => $upload_dir['baseurl'] . $rel_path,
					'entries' => $matches[1],
					);
			}
			update_option('rbfi', $out);
			esc_html_e('All done, have fun!', CWSFI_THEME_SLUG);
			echo '<script>parent.window.location.reload(true);</script>';
		} else {
			esc_html_e('Error: Required font files were not found.', CWSFI_THEME_SLUG);
		}
	} else {
		$bytes = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
		$size = size_format( $bytes );
		$upload_dir = wp_upload_dir();
		if ( ! empty( $upload_dir['error'] ) ) :
			?><div class="error"><p><?php esc_html_e('Before you can upload your import file, you will need to fix the following error:', 'rb_flaticons'); ?></p>
			<p><strong><?php echo $upload_dir['error']; ?></strong></p></div><?php
		else :
	?>
			<p>
			<form enctype="multipart/form-data" id="rbfi-upload-form" method="post" class="wp-form" action="<?php echo esc_url( wp_nonce_url( 'themes.php?page=rb_flaticons', 'rbfi-upload' ) ); ?>">
			<label for="upload"><?php esc_html_e( 'Choose a zip file you\'ve downloaded from http://www.flaticon.com/ :', 'rb_flaticons'); ?></label> (<?php printf( esc_html__('Maximum size: %s', 'rb_flaticons'), $size ); ?>)
			<input type="file" id="upload" accept=".zip" name="zip_import" size="25" />
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="max_file_size" value="<?php echo $bytes; ?>" />
			<?php
				submit_button( esc_attr__( 'Import FlatIcons', 'rb_flaticons' ), 'primary', 'rbfi-upload', false );
			?>
			</form>
			</p>
		<?php
			$rbfi = get_option('rbfi');
			if (!empty($rbfi) && isset($rbfi['css'])) {
				wp_enqueue_style( 'rbfi-css', $rbfi['css']);
				esc_html_e('The following icons are already imported. Keep in mind they will be overwritten if you import a new set.');
				echo '<ul class="rbfi_icons">';
				foreach ($rbfi['entries'] as $key => $value) {
					echo '<li><i class="flaticon-' . $value . '"></i>&nbsp;'. $value .'</li>';
				}
				echo '</ul>';
			}
		endif;
	}
}

add_filter( 'mce_buttons', 'rbfi_mce_buttons', 110 );
add_filter( 'mce_external_plugins', 'rbfi_mce_plugin' );

function rbfi_mce_buttons($b) {
	$rbfi = get_option('rbfi');
	if (!empty($rbfi) && isset($rbfi['css'])) {
		wp_enqueue_style( 'rbfi-css', $rbfi['css']);
		wp_enqueue_style( 'rbfi-tmce-css', CWS_FI_PLUGIN_URL . '/rbfi_tmce.css');
	}
	array_push($b, 'rbfi_icon');
	return $b;
}

function rbfi_mce_plugin($pa) {
	$pa['rbfi_sc'] = CWS_FI_PLUGIN_URL . '/rbfi_tmce.js';
	return $pa;
}

add_action( 'admin_footer', 'rbfi_print_templates' );

function rbfi_print_templates() {
	$rbfi = get_option('rbfi');
	$out = '<script type="text/html" id="tmpl-rbfi-icons">';
	if (!empty($rbfi) && isset($rbfi['entries'])) {
		foreach ($rbfi['entries'] as $key => $value) {
			$out .= $value . ',';
		}
	}
	$out .= '</script>';
	echo $out;
}

add_action( 'admin_enqueue_scripts', 'rbfi_enqueue_css' );
add_action( 'wp_enqueue_scripts', 'rbfi_enqueue_css' );

function rbfi_enqueue_css($a) {
	$rbfi = get_option('rbfi');
	if (!empty($rbfi) && isset($rbfi['css'])) {
		wp_enqueue_style( 'rbfi-css', $rbfi['css']);
	}
}

?>
