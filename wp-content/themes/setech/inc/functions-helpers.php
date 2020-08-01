<?php
defined( 'ABSPATH' ) or die();

/**
 * Helper function that getting custom metabox
 * 
 * @return  string
 */
function rb_get_metabox($metabox){
    return get_post_meta(get_the_id(), '_rb_'.$metabox, true);
}

/**
 * The helper function that will used to check
 * is it multi array
 *
 * @param   string  $arr  is array to check
 * @return  bool
 */
function rb_is_multi_array( $arr ) {
    rsort( $arr );
    return isset( $arr[0] ) && is_array( $arr[0] );
}

/**
 * The helper function that will used to get
 * main menu properties for wp_nav_menu() function
 *
 * @return  array
 */
function setech__main_menu_args(){
	return array(
		'theme_location'  	=> 'primary',
		'container'       	=> false,
		'menu_class'      	=> 'menu main-menu',
		'fallback_cb'     	=> false,
		'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           	=> 0
	);
}

/**
 * The helper function that will used to get
 * links for custom taxonomy archive page
 *
 * @return  string
 */
function rb_get_taxonomy_links( $tax = "", $delim = "", $layout = 'frontend', $pid = '' ){
	$pid = empty($pid) ? get_the_id() : $pid;
	$terms_arr = wp_get_post_terms( $pid, $tax );
	$terms = "";

	if ( is_wp_error( $terms_arr ) ){
		return $terms;
	}

	if( $layout == 'backend' ){
		$terms = array();

		foreach( $terms_arr as $term ){
			$terms[] = $term->slug;	
		}
	} else {
		for( $i = 0; $i < count( $terms_arr ); $i++ ){
			$term_obj	= $terms_arr[$i];
			$term_slug	= $term_obj->slug;
			$term_name	= esc_html( $term_obj->name );
			$term_link	= esc_url( get_term_link( $term_slug, $tax ) );
			$terms		.= "<a href='$term_link'>$term_name</a>" . ( $i < ( count( $terms_arr ) - 1 ) ? $delim : "" );
		}
	}
	
	return $terms;
}

/**
 * The helper function that will used to get
 * right page title
 *
 * @return  string
 */
function rb_get_page_title(){
	$page_title = '';

	if( is_404() ){
		$page_title = esc_html_x('404', 'frontend', 'setech');
	} else if( is_front_page() ){
		$page_title = esc_html_x('Home', 'frontend', 'setech');
	} else if( is_search() ){
		$page_title = esc_html_x('Search', 'frontend', 'setech');
	} else if( is_category() ){
		$cat = get_category( get_query_var( 'cat' ) );
		$cat_name = isset( $cat->name ) ? $cat->name : '';
		$page_title = sprintf( esc_html_x('Category: %s', 'frontend', 'setech'), $cat_name );
	} else if( is_tag() ){
		$page_title = sprintf( esc_html_x('Tag: %s', 'frontend', 'setech'), single_tag_title( '', false ) );
	} else if( is_day() ){
		$page_title = get_the_time( get_option('date_format') );
	} else if( is_month() ){
		$page_title = get_the_time( 'F, Y' );
	} else if( is_year() ){
		$page_title = get_the_time( 'Y' );
	} else if( has_post_format() && !is_singular() ){
		$page_title = get_post_format_string( get_post_format() );
	} else if( is_tax( array('rb_portfolio_cat', 'rb_portfolio_tag', 'rb_staff_member_department', 'rb_staff_member_position', 'rb_case_study_cat', 'rb_case_study_tag') ) ){
		$tax_slug = get_query_var( 'taxonomy' );
		$term_slug = get_query_var( $tax_slug );
		$tax_obj = get_taxonomy( $tax_slug );
		$term_obj = get_term_by( 'slug', $term_slug, $tax_slug );

		$singular_tax_label = isset( $tax_obj->labels ) && isset( $tax_obj->labels->singular_name ) ? $tax_obj->labels->singular_name : '';
		$term_name = isset( $term_obj->name ) ? $term_obj->name : '';
		$page_title = $singular_tax_label . ' ' . $term_name;
	} else if( class_exists('WooCommerce') && is_woocommerce() ){
		$page_title = !empty(get_theme_mod('woo_slug')) ? esc_html(get_theme_mod('woo_slug')) : esc_html_x('Shop', 'frontend', 'setech');;  
	} else if( get_post_type() == 'rb_staff' ){
		if( is_singular() ){
			$page_title = !empty(get_theme_mod('rb_staff_single_slug')) ? esc_html(get_theme_mod('rb_staff_single_slug')) : esc_html_x('Our Team Single', 'frontend', 'setech');
		} else {
			$page_title = !empty(get_theme_mod('rb_staff_slug')) ? esc_html(get_theme_mod('rb_staff_slug')) : esc_html_x('Our Team', 'frontend', 'setech');
		}
	} else if( get_post_type() == 'rb_portfolio' ){
		if( is_singular() ){
			$page_title = !empty(get_theme_mod('rb_portfolio_single_slug')) ? esc_html(get_theme_mod('rb_portfolio_single_slug')) : esc_html_x('Portfolio Single', 'frontend', 'setech');
		} else {
			$page_title = !empty(get_theme_mod('rb_portfolio_slug')) ? esc_html(get_theme_mod('rb_portfolio_slug')) : esc_html_x('Portfolio', 'frontend', 'setech');
		}
	} else if( get_post_type() == 'rb_case_study' ){
		if( is_singular() ){
			$page_title = get_the_title();
		} else {
			$page_title = !empty(get_theme_mod('rb_case_study_slug')) ? esc_html(get_theme_mod('rb_case_study_slug')) : esc_html_x('Case Studies', 'frontend', 'setech');
		}
	} else if( is_archive() ){
		$post_type_obj = get_post_type_object( get_post_type() );
		$post_type_name = isset( $post_type_obj->label ) ? $post_type_obj->label : '';
		$page_title = $post_type_name;

		if(is_author()){
			$page_title = sprintf( esc_html_x('Posted by %s', 'frontend', 'setech'), get_the_author_meta('display_name'));
		}
	} else {
		$page_title = get_the_title();
	}

	$page_title = wp_kses( $page_title, array(
		"b"			=> array(),
		"em"		=> array(),
		"sup"		=> array(),
		"sub"		=> array(),
		"strong"	=> array(),
		"mark"		=> array(),
		"br"		=> array()
	));

	return $page_title;
}

/**
 * The helper function that will used to get
 * current post type
 *
 * @return  string
 */
function rb_get_post_type(){
	$out = 'regular';

	if( class_exists('WooCommerce') && is_woocommerce() ){
		if( is_product() ){
			$out = 'woo_single';
		} else {
			$out = 'woo_archive';
		}
	} else if( get_post_type() == 'rb_staff' ){
		if( is_singular() ){
			$out = 'staff_single';
		} else {
			$out = 'staff_archive';
		}
	} else if( get_post_type() == 'rb_portfolio' ){
		if( is_singular() ){
			$out = 'portfolio_single';
		} else {
			$out = 'portfolio_archive';
		}
	} else if( get_post_type() == 'rb_case_study' ){
		if( is_singular() ){
			$out = 'case_study_single';
		} else {
			$out = 'case_study_archive';
		}
	} else if( get_post_type() == 'post' ){
		if( is_singular() ){
			$out = 'blog_single';
		} else {
			$out = 'blog_archive';
		}
	}

	return $out;
}

/**
 * The helper function that will used to print
 * needed sticky/header/footer template
 *
 * @return  string
 */
function rb_print_template( $template, $type ){
	$default_template = 'tmpl/'.esc_attr($type);

	if( get_theme_mod($template) != 'default' ){

		$template = get_theme_mod($template) == 'inherit' ? 'custom_'.$type : $template;

		if( class_exists('SitePress') ){
			$rb_sitepress = new SitePress();
		}

		if( class_exists('SitePress') && $rb_sitepress->get_setting( 'setup_complete' ) ){
			$cws_template_id = icl_object_id( get_theme_mod($template), 'page', false );
		} else {
			$cws_template_id = get_theme_mod($template);
		}

		if( get_theme_mod($template) == 'default' ){
			get_template_part( $default_template );
			return;
		} else {
			$custom_template = get_post_field( 'post_content', get_theme_mod($template) );
		}

		if( !empty($custom_template) ){
			$vc_custom_css = get_post_meta( get_theme_mod($template), '_wpb_shortcodes_custom_css', true );
			rb__vc_styles($vc_custom_css);

			echo "<div class='rb_".esc_attr($type)."_template'>";
				echo "<div class='container'>";
					echo do_shortcode($custom_template);
				echo "</div>";
			echo "</div>";
		}
	} else {
		get_template_part( $default_template );
	}
}

/**
 * The helper function that will used to retrieve the
 * theme options value
 *
 * @param   string  $name  The option ID
 * @return  mixed
 */
function setech__option( $name ) {
	static $options;
	if (empty($options)) {
		global $wp_query;
		$pid = get_the_id();

		$theme_options = get_option(SETECH__ID);
		if (empty($theme_options)) return null;
		$options = $theme_options;
	}

	$ret = null;
	if (is_customize_preview()) {
		global $rbfw_settings;
		if (isset($rbfw_settings[$name])) {
			$ret = $rbfw_settings[$name];
			if (is_array($ret)) {
				$theme_options = get_option( SETECH__ID );
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

	$theme_options = get_option( SETECH__ID );
	$ret = isset($theme_options[$name]) ? $theme_options[$name] : null;
	$ret = stripslashes_deep( $ret );
	
	return $ret;
}

/**
 * Return currently post type
 *
 * @return  strings
 */
function setech__current_post_type() {
	global $post, $typenow, $current_screen;

	//we have a post so we can just get the post type from that
	if ( true == isset( $post ) && true == isset( $post->post_type ) )
		return $post->post_type;

	//check the global $typenow - set in admin.php
	elseif ( true == isset( $typenow ) )
		return $typenow;

	//check the global $current_screen object - set in sceen.php
	elseif ( true == isset( $current_screen ) && true == isset( $current_screen->post_type ) )
		return $current_screen->post_type;

	//lastly check the post_type querystring
	elseif ( true == isset( $_REQUEST['post_type'] ) )
		return sanitize_key( $_REQUEST['post_type'] );

	//we do not know the post type!
	return null;
}

/**
 * The helper function for showing the logo was set
 * from the theme customize
 *
 * @param   string  $logo_field  The option id
 *
 * @return  void
 * @since   1.0.0
 */
function setech_logo( $logo_field = '', $logo_dimensions = '', $tag = 'h1' ){
	if( !empty( get_theme_mod($logo_field) ) ){

		$logo_id = get_theme_mod($logo_field);
		$logo_sizes = 'full';

		$logo_url = wp_get_attachment_image_url( $logo_id, $logo_sizes, false );
		$logo_alt = trim(strip_tags( get_post_meta( $logo_id, '_wp_attachment_image_alt', true) ));
		$logo_alt = empty($logo_alt) ? get_bloginfo('name') : $logo_alt;
		
		if( !empty($logo_dimensions) ){
			$logo_dimensions = get_theme_mod($logo_dimensions);

			$logo_width = !empty($logo_dimensions['width']) ? (int)$logo_dimensions['width'] : '';
			$logo_height = !empty($logo_dimensions['height']) ? (int)$logo_dimensions['height'] : '';
		}

		$logo = "<img src='".esc_url($logo_url)."'";
		$logo .= " alt='".esc_attr($logo_alt)."'";
		$logo .= !empty($logo_width) ? " width='".esc_attr($logo_width)."'" : "";
		$logo .= !empty($logo_height) ? " height='".esc_attr($logo_height)."'" : "";
		$logo .= " />";

		echo sprintf('%s', $logo);
	} else {
		echo "<".$tag." class='sitename'>";
			echo get_bloginfo('name');
		echo "</".$tag.">";
	}
}

/**
 * This function will be used to generate the HTML attributes
 * string from an given array
 *
 * @param   array  $attrs  The attribute list
 *
 * @return  string
 * @since   1.0.0
 */
function setech__attributes( $attrs ) {
	$attributes = array();

	foreach ( $attrs as $name => $value ) {
		$attributes[] = sprintf( '%s="%s"', esc_attr( $name ), esc_attr( $value ) );
	}

	return join( ' ', $attributes );
}