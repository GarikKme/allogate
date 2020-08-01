<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> "all",
		),
		array(
			"type"				=> "checkbox",
			"param_name"		=> "hover_animate",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"				=> array( esc_html_x( 'Animate on Hover', 'backend', 'setech' ) => true ),
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Color', 'backend', 'setech' ),
			"param_name"		=> "title_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "#000",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Text Color', 'backend', 'setech' ),
			"param_name"		=> "text_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> 'rgba(0,0,0, .75)',
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Divider Color', 'backend', 'setech' ),
			"param_name"		=> "divider_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"				=> '#DADCE2',
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Title', 'backend', 'setech' ),
			"param_name"		=> "btn_font_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> '#000'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Title Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_font_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> '#fff'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Background', 'backend', 'setech' ),
			"param_name"		=> "btn_bg_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "#fff"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Background Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_bg_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Border', 'backend', 'setech' ),
			"param_name"		=> "btn_border_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "#DADCE2"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Border Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_border_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Background Color', 'backend', 'setech' ),
			"param_name"		=> "background_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "#fff",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Shadow Color', 'backend', 'setech' ),
			"param_name"		=> "shadow_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "rgba(0,0,0,.05)",
		),
	);

	/* -----> GET TAXONOMIES <----- */
	$post_type = "rb_case_study";
	$taxonomies = $titles_arr = array();
	$taxes = get_object_taxonomies ( 'rb_case_study', 'object' );
	$avail_taxes = array(
		esc_html_x( 'None', 'backend', 'setech' )	=> '',
		esc_html_x( 'Titles', 'backend', 'setech' )	=> 'title',
	);

	foreach( $taxes as $tax => $tax_obj ){
		$tax_name = isset( $tax_obj->labels->name ) && !empty( $tax_obj->labels->name ) ? $tax_obj->labels->name : $tax;
		$avail_taxes[$tax_name] = $tax;
	}
	array_push( $taxonomies, array(
		"type"			=> "dropdown",
		"heading"		=> esc_html__( 'Filter by', 'setech' ),
		"param_name"	=> "tax",
		"description"	=> esc_html_x( 'Filter by titles is not applicable when Motion Category Layout used.', 'backend', 'setech' ),
		"value"			=> $avail_taxes
	));
	foreach ( $avail_taxes as $tax_name => $tax ) {
		if ($tax == 'title'){
			global $wpdb;

			$results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type LIKE %s and post_status = 'publish'", $post_type ) );

		    foreach( $results as $index => $post ) {
		    	$post_title = $post->post_title;
		        $titles_arr[$post_title] = $post->ID;
		    }
			array_push( $taxonomies, array(
				"type"				=> "rb_dropdown",
				"multiple"			=> "true",
				"heading"			=> esc_html_x( 'Titles', 'backend', 'setech' ),
				"param_name"		=> "titles",
				'edit_field_class'	=> 'inside-box vc_col-xs-12',
				"dependency"		=> array(
					"element"	=> "tax",
					"value"		=> 'title'
				),
				"value"				=> $titles_arr
			));		
		} else {
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
	}

	$params = rb_ext_merge_arrs( array(
		/* -----> GENERAL TAB <----- */
		$taxonomies,
		array(
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Order By', 'backend', 'setech' ),
				"param_name"		=> "orderby",
				"value"				=> array(
					esc_html_x( 'Date', 'backend', 'setech' )		=> 'date',
					esc_html_x( 'Order ID', 'backend', 'setech' )	=> 'menu_order',
					esc_html_x( 'Title', 'backend', 'setech' )		=> 'title',
				),
				'std'				=> get_theme_mod('rb_case_study_orderby')
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Order', 'backend', 'setech' ),
				"param_name"		=> "order",
				"value"				=> array(
					esc_html_x( 'ASC', 'backend', 'setech' )	=> 'ASC',
					esc_html_x( 'DESC', 'backend', 'setech' )	=> 'DESC',
				),
				'std'				=> get_theme_mod('rb_case_study_order')
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Columns', 'backend', 'setech' ),
				"param_name"		=> "columns",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> array(
					esc_html_x( '2', 'backend', 'setech' )		=> '2',
					esc_html_x( '3', 'backend', 'setech' )		=> '3',
					esc_html_x( '4', 'backend', 'setech' )		=> '4',
				),
				"std"				=> get_theme_mod('rb_case_study_columns')
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Items to Show', 'backend', 'setech' ),
				"description"		=> esc_html_x( 'Enter "-1" to show all posts', 'backend', 'setech' ),
				"param_name"		=> "total_items_count",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> "-1"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Items per Page', 'backend', 'setech' ),
				"param_name"		=> "items_pp",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> "-1",
				"std"				=> get_theme_mod('rb_case_study_items_pp')
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Chars Count', 'backend', 'setech' ),
				"param_name"		=> "chars_count",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "50",
				"std"				=> get_theme_mod('rb_case_study_chars_count')
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'More Button Text', 'backend', 'setech' ),
				"param_name"		=> "more_btn_text",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "View Case Study",
				"std"				=> get_theme_mod('rb_case_study_button_text')
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Extra class name', 'backend', 'setech' ),
				"description"		=> esc_html_x( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'backend', 'setech' ),
				"param_name"		=> "el_class",
				"value"				=> ""
			),
		),
		/* -----> STYLING TAB <----- */
		$styles
	));

	/* -----> MODULE DECLARATION <----- */
	vc_map( array(
		"name"				=> esc_html_x( 'RB Case Study', 'backend', 'setech' ),
		"base"				=> "rb_sc_case_study",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Case_Study extends WPBakeryShortCode {
	    }
	}
?>