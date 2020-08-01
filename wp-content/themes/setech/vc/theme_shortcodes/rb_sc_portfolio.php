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
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Color', 'backend', 'setech' ),
			"param_name"		=> "title_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "#fff",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Meta Color', 'backend', 'setech' ),
			"param_name"		=> "meta_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> 'rgba(255,255,255, .8)',
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Divider Color', 'backend', 'setech' ),
			"param_name"		=> "divider_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> '#DADCE2',
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Background Color', 'backend', 'setech' ),
			"param_name"		=> "background_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> 'rgba(0,0,0, .8)',
		),
	);

	/* -----> GET TAXONOMIES <----- */
	$post_type = "rb_portfolio";
	$taxonomies = $titles_arr = array();
	$taxes = get_object_taxonomies ( 'rb_portfolio', 'object' );
	$avail_taxes = array(
		esc_html_x( 'None', 'backend', 'setech' )	=> '',
		esc_html_x( 'Titles', 'backend', 'setech' )	=> 'title',
	);
	$portfolio_hide_meta = get_theme_mod('rb_portfolio_hide_meta') ? get_theme_mod('rb_portfolio_hide_meta') : array();

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
		array(
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Layout', 'backend', 'setech' ),
				"param_name"		=> "layout",
				"value"				=> array(
					esc_html_x( 'Grid', 'backend', 'setech' )					=> 'grid',
					esc_html_x( 'Grid with Filter', 'backend', 'setech' )		=> 'grid_filter',
					esc_html_x( 'Masonry', 'backend', 'setech' )				=> 'masonry',
					esc_html_x( 'Pinterest', 'backend', 'setech' )				=> 'pinterest',
					esc_html_x( 'Asymmetric', 'backend', 'setech' )				=> 'asymmetric',
					esc_html_x( 'Carousel', 'backend', 'setech' )				=> 'carousel',
					esc_html_x( 'Carousel Wide', 'backend', 'setech' )			=> 'carousel_wide',
					esc_html_x( 'Motion Category', 'backend', 'setech' )		=> 'motion_category',
				),
				"std"				=> get_theme_mod('rb_portfolio_layout')
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Hover', 'backend', 'setech' ),
				"param_name"		=> "hover",
				"value"				=> array(
					esc_html_x( 'Overlay', 'backend', 'setech' )				=> 'overlay',
					esc_html_x( 'Slide From Bottom', 'backend', 'setech' )		=> 'slide_bottom',
					esc_html_x( 'Slide From Left', 'backend', 'setech' )		=> 'slide_left',
					esc_html_x( 'Swipe Right', 'backend', 'setech' )			=> 'swipe_right',
				),
				'dependency'	=> array(
					'element'		=> 'layout',
					'value'			=> array( "grid", "grid_filter", "masonry", "pinterest", "asymmetric", "carousel", "motion_category" )
				),
				"std"			=> get_theme_mod('rb_portfolio_hover')
			),
		),
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
				'std'				=> get_theme_mod('rb_portfolio_orderby')
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Order', 'backend', 'setech' ),
				"param_name"		=> "order",
				"value"				=> array(
					esc_html_x( 'ASC', 'backend', 'setech' )	=> 'ASC',
					esc_html_x( 'DESC', 'backend', 'setech' )	=> 'DESC',
				),
				'std'				=> get_theme_mod('rb_portfolio_order')
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
					esc_html_x( '5', 'backend', 'setech' )		=> '5',
					esc_html_x( '6', 'backend', 'setech' )		=> '6',
				),
				'dependency'	=> array(
					'element'	=> 'layout',
					'value'		=> array( "grid", "grid_filter", "masonry", "pinterest", "carousel" )
				),
				"std"				=> get_theme_mod('rb_portfolio_columns')
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
				'dependency'		=> array(
					'element'	=> 'layout',
					'value'		=> array( "grid", "grid_filter", "masonry", "pinterest", "asymmetric" )
				),
				"std"				=> get_theme_mod('rb_portfolio_items_pp')
			),
			array(
				'type'				=> 'checkbox',
				'param_name'		=> 'square_img',
				'value'				=> array(
					esc_html_x( 'Square Images', 'backend', 'setech' ) => true
				),
				'std'				=> get_theme_mod('rb_portfolio_square_img')
			),
			array(
				'type'				=> 'checkbox',
				'param_name'		=> 'no_spacing',
				'value'				=> array(
					esc_html_x( 'Disable Spacings', 'backend', 'setech' ) => true
				),
				'dependency'	=> array(
					'element'	=> 'layout',
					'value'		=> array( "grid", "grid_filter", "masonry", "pinterest" )
				),
				'std'				=> get_theme_mod('rb_portfolio_no_spacing')
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Pagination', 'backend', 'setech' ),
				"param_name"		=> "pagination",
				"value"				=> array(
					esc_html_x( 'Standart', 'backend', 'setech' )		=> 'standart',
					esc_html_x( 'Load More', 'backend', 'setech' )		=> 'load_more',
				),
				'dependency'		=> array(
					'element'	=> 'layout',
					'value'		=> array( "grid", "grid_filter", "masonry", "pinterest", "asymmetric" )
				),
				"std"				=> get_theme_mod('rb_portfolio_pagination')
			),
			array(
				'type'				=> 'checkbox',
				'param_name'		=> 'hide_meta',
				'value'				=> array(
					esc_html_x( 'Hide Meta Data', 'backend', 'setech' ) => true
				),
				'std'				=> '1'
			),
			array(
				'type'			=> 'rb_dropdown',
				'multiple'		=> "true",
				'heading'		=> esc_html_x( 'Hide', 'backend', 'setech' ),
				'param_name'	=> 'portfolio_hide_meta',
				'dependency'	=> array(
					'element'	=> 'hide_meta',
					'not_empty'	=> true
				),
				'value'			=> array(
					esc_html_x( 'None', 'backend', 'setech' )				=> '',
					esc_html_x( 'Title', 'backend', 'setech' )				=> 'title',
					esc_html_x( 'Categories', 'backend', 'setech' )			=> 'categories',
					esc_html_x( 'Tags', 'backend', 'setech' )				=> 'tags',
				),
				'std'			=> implode(',', $portfolio_hide_meta)
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
		"name"				=> esc_html_x( 'RB Portfolio', 'backend', 'setech' ),
		"base"				=> "rb_sc_portfolio",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Portfolio extends WPBakeryShortCode {
	    }
	}
?>