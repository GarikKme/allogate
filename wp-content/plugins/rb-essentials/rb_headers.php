<?php
add_filter('block_categories', 'rbhdgb_block_categories');
function rbhdgb_block_categories($cats) {
	array_unshift($cats, array('slug'  => 'rbhdgb', 'title' => 'RB Header Blocks', 'icon' => null ));
	array_unshift($cats, array('slug'  => 'rbgb', 'title' => 'RB Blocks', 'icon' => null ));
	return $cats;
}
/* /update */

function rb_fix_shortcodes_autop($content){
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	
	return $content;
}

function rb_hf_adminmenu() {
	add_menu_page(
		'RB Templates',
		'RB Templates',
		'read',
		'rb-templates',
		'', // Callback, leave empty
		'dashicons-calendar',
		24 // Position
	);

	//remove_submenu_page( 'edit.php?post_type=rb-tmpl-header', 'edit.php?post_type=rb-tmpl-header' );
	add_submenu_page('rb-templates', 'Header', 'Header', 'manage_options', 'edit.php?post_type=rb-tmpl-header');
	add_submenu_page('rb-templates', 'Add Header', 'Add Header', 'manage_options', 'post-new.php?post_type=rb-tmpl-header');

	//remove_submenu_page( 'edit.php?post_type=rb-tmpl-footer', 'edit.php?post_type=rb-tmpl-footer' );
	add_submenu_page('rb-templates', 'Footer', 'Footer', 'manage_options', 'edit.php?post_type=rb-tmpl-footer');
	add_submenu_page('rb-templates', 'Add Footer', 'Add Footer', 'manage_options', 'post-new.php?post_type=rb-tmpl-footer');

	//remove_submenu_page( 'edit.php?post_type=rb-tmpl-sticky', 'edit.php?post_type=rb-tmpl-sticky' );
	add_submenu_page('rb-templates', 'Sticky Menu', 'Sticky', 'manage_options', 'edit.php?post_type=rb-tmpl-sticky');
	add_submenu_page('rb-templates', 'Add Sticky Menu', 'Add Sticky', 'manage_options', 'post-new.php?post_type=rb-tmpl-sticky');

	remove_submenu_page( 'rb-templates', 'rb-templates' );
}

add_action( 'admin_menu', 'rb_hf_adminmenu' );
add_action('init', 'rb_hf_init');


function rb_hf_init() {
	$labels = array(
		'name' => __('Header Templates', 'rb_hf'),
		'singular_name' => __('Header Template', 'rb_hf'),
		'add_new' => __('Add Header Template', 'rb_hf'),
		'add_new_item' => __('Add New Header Template', 'rb_hf'),
		'edit_item' => __('Edit Header Template', 'rb_hf'),
		'new_item' => __('New Header Template', 'rb_hf'),
		'view_item' => __('View Header Template', 'rb_hf'),
		'search_items' => __('Search Header Template', 'rb_hf'),
		'not_found' => __('No Header Templates found', 'rb_hf'),
		'not_found_in_trash' => __('No Header Templates found in Trash', 'rb_hf'),
		'parent_item_colon' => '',
		'menu_name' => __('Header Templates', 'rb_hf')
	);

	$labelsf = array(
		'name' => __('Footer Templates', 'rb_hf'),
		'singular_name' => __('Footer Template', 'rb_hf'),
		'add_new' => __('Add Footer Template', 'rb_hf'),
		'add_new_item' => __('Add New Footer Template', 'rb_hf'),
		'edit_item' => __('Edit Footer Template', 'rb_hf'),
		'new_item' => __('New Footer Template', 'rb_hf'),
		'view_item' => __('View Footer Template', 'rb_hf'),
		'search_items' => __('Search Footer Template', 'rb_hf'),
		'not_found' => __('No Footer Templates found', 'rb_hf'),
		'not_found_in_trash' => __('No Footer Templates found in Trash', 'rb_hf'),
		'parent_item_colon' => '',
	);

	$labelss = array(
		'name' => __('Sticky Templates', 'rb_hf'),
		'singular_name' => __('Sticky Template', 'rb_hf'),
		'add_new' => __('Add Sticky Template', 'rb_hf'),
		'add_new_item' => __('Add New Sticky Template', 'rb_hf'),
		'edit_item' => __('Edit Sticky Template', 'rb_hf'),
		'new_item' => __('New Sticky Template', 'rb_hf'),
		'view_item' => __('View Sticky Template', 'rb_hf'),
		'search_items' => __('Search Sticky Template', 'rb_hf'),
		'not_found' => __('No Sticky Templates found', 'rb_hf'),
		'not_found_in_trash' => __('No Sticky Templates found in Trash', 'rb_hf'),
		'parent_item_colon' => '',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'show_in_menu' => false,
		'hierarchical' => true,
		'show_in_rest' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
	);
	register_post_type('rb-tmpl-header', $args);

	$args = array(
		'labels' => $labelsf,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => false,
		'capability_type' => 'post',
		'hierarchical' => true,
		'show_in_rest' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
	);
	register_post_type('rb-tmpl-footer', $args);

	$args = array(
		'labels' => $labelss,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => false,
		'capability_type' => 'post',
		'hierarchical' => true,
		'show_in_rest' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
	);
	register_post_type('rb-tmpl-sticky', $args);
}

add_action( 'add_meta_boxes', 'rbhf_post_addmb' );

function rbhf_post_addmb() {
	add_meta_box( 'rb-post-metabox-id-3', 'RB Template Options', 'rbhf_mb_page_callback', 'page', 'normal', 'high' );
}

function rbhf_mb_page_callback( $post ) {
	wp_nonce_field( 'rbhf_mb_nonce', 'mb_nonce' );

	$rb_stored_meta = get_post_meta( $post->ID, 'rbhf_mb_post', true );
	$meta_header = $meta_footer = $meta_sticky = 0;
	if (!empty($rb_stored_meta)) {
		$meta_header = (int)$rb_stored_meta['header'];
		$meta_footer = (int)$rb_stored_meta['footer'];
		$meta_sticky = (int)$rb_stored_meta['sticky'];
	}
	echo '<p>Header Templates</p>';
	echo '<select name="rbhf_header">';
	echo '<option value="">'.esc_html_x('Default', 'backend', 'setech').'</option>';
	echo buildTemplates('rb-tmpl-header', $meta_header);
	echo '</select>';

	echo '<p>Footer Templates</p>';
	echo '<select name="rbhf_footer">';
	echo '<option value="">'.esc_html_x('Default', 'backend', 'setech').'</option>';
	echo buildTemplates('rb-tmpl-footer', $meta_footer);
	echo '</select>';

	echo '<p>Sticky Templates</p>';
	echo '<select name="rbhf_sticky">';
	echo '<option value="">'.esc_html_x('Default', 'backend', 'setech').'</option>';
	echo buildTemplates('rb-tmpl-sticky', $meta_sticky);
	echo '</select>';
}

function buildTemplates($term, $selected) {
	$args = array(
		'post_type' => $term,
		'posts_per_page' => -1
	);

	$r_query = new WP_Query($args);
	$ret = '';
	foreach ($r_query->posts as $k => $v) {
		$sel = $v->ID === $selected ? ' selected' : '';
		$ret .= sprintf('<option value="%s"%s>%s</option>', $v->ID, $sel, $v->post_title);
	}
	return $ret;
}

add_action( 'save_post', 'rbhf_metabox_save', 11, 2 );

function rbhf_metabox_save($post_id, $post) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return;

	if ( !isset( $_POST['mb_nonce']) || !wp_verify_nonce($_POST['mb_nonce'], 'rbhf_mb_nonce') )
		return;

	if ( !current_user_can( 'edit_post', $post->ID ) )
		return;

	$save_array = array();

	foreach($_POST as $key => $value) {
		if (0 === strpos($key, 'rbhf_')) {
			$save_array[substr($key, 5)] = $value;
		}
	}

	if (!empty($save_array)) {
		update_post_meta($post_id, 'rbhf_mb_post', $save_array);
	}
}
add_action( 'rb_custom_sticky', 'rbhf_sticky', 5 );
function rbhf_sticky() {
	global $post;

	if( !empty($post) ){
		$rb_stored_meta = get_post_meta( $post->ID, 'rbhf_mb_post', true );
		$meta_sticky = 0;

		if (!empty($rb_stored_meta) && !empty($rb_stored_meta['sticky'])) {
			$vc_shortcodes_custom_css = get_post_meta( $rb_stored_meta['sticky'], '_wpb_shortcodes_custom_css', true );
			$vc_shortcodes_custom_css = strip_tags( $vc_shortcodes_custom_css );
			rb__vc_styles($vc_shortcodes_custom_css);

			$meta_sticky = (int)$rb_stored_meta['sticky'];
			$page_object = get_page( $meta_sticky );
			$content = $page_object->post_content;
			$content = rb_fix_shortcodes_autop($content);

			echo "<div class='rb_sticky_template'>";
				echo "<div class='container'>";
					echo do_shortcode($content);
				echo "</div>";
			echo "</div>";
		}
	}
}

add_action( 'rb_custom_footer', 'rbhf_footer', 5 );
function rbhf_footer(){
	global $post;

	if( !empty($post) ){
		$rb_stored_meta = get_post_meta( $post->ID, 'rbhf_mb_post', true );
		$meta_footer = 0;

		if( !empty($rb_stored_meta) && !empty($rb_stored_meta['footer']) ){
			$vc_shortcodes_custom_css = get_post_meta( $rb_stored_meta['footer'], '_wpb_shortcodes_custom_css', true );
			$vc_shortcodes_custom_css = strip_tags( $vc_shortcodes_custom_css );
			rb__vc_styles($vc_shortcodes_custom_css);

			$meta_footer = (int)$rb_stored_meta['footer'];
			$page_object = get_page( $meta_footer );
			$content = $page_object->post_content;
			$content = rb_fix_shortcodes_autop($content);

			echo "<div class='rb_footer_template".( get_theme_mod('sticky_footer') ? ' sticky_footer' : '' )."'>";
				echo "<div class='container'>";
					echo do_shortcode($content);
				echo "</div>";
			echo "</div>";
		}
	}
}

add_action( 'rb_custom_header', 'rbhf_header', 5 );
function rbhf_header() {
	global $post;

	if( !empty($post) ){
		$rb_stored_meta = get_post_meta( $post->ID, 'rbhf_mb_post', true );
		$meta_header = 0;

		if (!empty($rb_stored_meta) && !empty($rb_stored_meta['header'])) {
			$vc_shortcodes_custom_css = get_post_meta( $rb_stored_meta['header'], '_wpb_shortcodes_custom_css', true );
			$vc_shortcodes_custom_css = strip_tags( $vc_shortcodes_custom_css );

			rb__vc_styles($vc_shortcodes_custom_css);

			$meta_header = (int)$rb_stored_meta['header'];
			$page_object = get_page( $meta_header );
			$load_sidebars = array();
			$content = $page_object->post_content;
			$content = rb_fix_shortcodes_autop($content);

			$extra_classes = get_post_meta($page_object->ID, '_rb_header_absolute', true) == 'on' ? 'absolute_pos' : '';
			
			echo "<div class='rb_header_template ".esc_attr($extra_classes)."'>";
				echo "<div class='container'>";
					$out = do_shortcode($content);

					// Check any custom sidebar to load
					preg_match_all("/data-sidebar=.+?(\'|\")>/", $out, $results);

					foreach( $results[0] as $value ){
						preg_match("/(\'|\").+?(\'|\")/", $value, $result);
						$result = trim($result[0], "'");
						$result = trim($result, '"');

						$load_sidebars[] = setech__get_sidebar( '', $result, 'right', 'default', $result );
					}

					echo $out;
				echo "</div>";
			echo "</div>";

			if( !empty($load_sidebars) ){
				echo "<div class='custom_sidebars_wrapper'>";
					foreach( $load_sidebars as $sidebar ){
						echo $sidebar;
					}
				echo "</div>";
			}
		}
	}
}
