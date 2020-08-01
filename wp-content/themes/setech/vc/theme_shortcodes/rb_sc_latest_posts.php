<?php
	
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Shortcode Title', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "title_color",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Date Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "date_color",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Article Title', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "article_color",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Article Title Hover', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "article_color_hover",
			"value"				=> PRIMARY_COLOR
		),
	);

	/* -----> GET TAXONOMIES <----- */
	$post_type = "post";
	$taxonomies = array();
	$taxes = get_object_taxonomies ( 'post', 'object' );
	$avail_taxes = array(
		esc_html_x( 'None', 'backend', 'setech' )	=> '',
	);

	$staff_hide_meta = get_theme_mod('rb_staff_hide_meta') ? get_theme_mod('rb_staff_hide_meta') : array();

	foreach( $taxes as $tax => $tax_obj ){
		$tax_name = isset( $tax_obj->labels->name ) && !empty( $tax_obj->labels->name ) ? $tax_obj->labels->name : $tax;
		$avail_taxes[$tax_name] = $tax;
	}
	array_push( $taxonomies, array(
		"type"			=> "dropdown",
		"heading"		=> esc_html__( 'Filter by', 'setech' ),
		"param_name"	=> "tax",
		"value"			=> $avail_taxes
	));
	foreach ( $avail_taxes as $tax_name => $tax ) {
		$terms = get_terms( $tax );
		$avail_terms = array(
			''				=> ''
		);
		if ( !is_a( $terms, 'WP_Error' ) ){
			foreach ( $terms as $term ) {
				$avail_terms[$term->name] = $term->slug;
			}
		}
		array_push( $taxonomies, array(
			"type"			=> "rb_dropdown",
			"multiple"		=> "true",
			"heading"		=> $tax_name,
			"param_name"	=> "{$tax}_terms",
			"dependency"	=> array(
				"element"	=> "tax",
				"value"		=> $tax
			),
			"value"			=> $avail_terms
		));				
	}

	$params = rb_ext_merge_arrs( array(
		array(
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Title', 'backend', 'setech' ),
				"param_name"		=> "title",
				"value"				=> ""
			),
		),
		$taxonomies,
		array(
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Items to Show', 'backend', 'setech' ),
				"description"		=> esc_html_x( 'Enter "-1" to show all posts', 'backend', 'setech' ),
				"param_name"		=> "total_items_count",
				"value"				=> "2"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Extra class name', 'backend', 'setech' ),
				"description"		=> esc_html_x( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'backend', 'setech' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			)
		),
		$styles
	));

	/* -----> MODULE DECLARATION <----- */
	vc_map( array(
		"name"				=> esc_html_x( 'RB Latest Posts', 'backend', 'setech' ),
		"base"				=> "rb_sc_latest_posts",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Latest_Posts extends WPBakeryShortCode {
	    }
	}