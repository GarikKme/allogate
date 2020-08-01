<?php

/* -----> STYLING TAB PROPERTIES <----- */
$styles = array(
	array(
		"type"			=> "css_editor",
		"param_name"	=> "custom_styles",
		"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
		"responsive"	=> "all"
	),
	array(
		"type"			=> "checkbox",
		"param_name"	=> "hover_animate",
		"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
		"value"			=> array( esc_html_x( 'Animate on Hover', 'backend', 'setech' ) => true ),
		"dependency"	=> array(
			"element"	=> "layout",
			"value"		=> array( "2","3","4" )
		),
	),
	array(
		"type"			=> "checkbox",
		"param_name"	=> "customize_size",
		"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
		"value"			=> array( esc_html_x( 'Customize Sizes', 'backend', 'setech' ) => true ),
	),
	array(
		"type"				=> "textfield",
		"heading"			=> esc_html_x( "Title Size", 'backend', 'setech' ),
		"param_name"		=> "title_size",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> "24px",
		"dependency"		=> array(
			"element"	=> "customize_size",
			"not_empty"	=> true
		),
	),
	array(
		"type"				=> "textfield",
		"heading"			=> esc_html_x( "Title Line Height", 'backend', 'setech' ),
		"param_name"		=> "title_lh",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> "31px",
		"dependency"		=> array(
			"element"	=> "customize_size",
			"not_empty"	=> true
		),
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Background Color', 'backend', 'setech' ),
		"param_name"		=> "background_color",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"value"				=> "#fff"
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Title Color', 'backend', 'setech' ),
		"param_name"		=> "title_color",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> "#000"
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Text Color', 'backend', 'setech' ),
		"param_name"		=> "text_color",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> "#4C4C4D"
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Accent Color', 'backend', 'setech' ),
		"param_name"		=> "accent_color",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> PRIMARY_COLOR
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Meta Color', 'backend', 'setech' ),
		"param_name"		=> "meta_color",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> "#000"
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Active Dot', 'backend', 'setech' ),
		"param_name"		=> "active_dot",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"dependency"		=> array(
			"element"	=> "enable_carousel",
			"not_empty"	=> true
		),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> PRIMARY_COLOR
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Arrows Color', 'backend', 'setech' ),
		"param_name"		=> "arrows_color",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"dependency"		=> array(
			"element"	=> "enable_carousel",
			"not_empty"	=> true
		),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> PRIMARY_COLOR
	),
	array(
		'type'				=> 'dropdown',
		'heading'			=> esc_html_x( 'Button Type', 'backend', 'setech' ),
		'param_name'		=> 'button_type',
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"value"				=> array(
			esc_html_x( 'Round', 'backend', 'setech' )				=> 'round',
			esc_html_x( 'Simple', 'backend', 'setech' )				=> 'simple',
		),
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Button Title', 'backend', 'setech' ),
		"param_name"		=> "btn_font_color",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> '#fff'
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
		"value"				=> PRIMARY_COLOR
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
		"value"				=> PRIMARY_COLOR
	),
	array(
		"type"				=> "colorpicker",
		"heading"			=> esc_html_x( 'Button Border Hover', 'backend', 'setech' ),
		"param_name"		=> "btn_border_color_hover",
		"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
		"edit_field_class" 	=> "vc_col-xs-6",
		"value"				=> PRIMARY_COLOR
	),
);

/* -----> GET TAXONOMIES <----- */
$post_type = "post";
$taxonomies = array();

$taxes = get_object_taxonomies ( $post_type, 'object' );
$avail_taxes = array(
	esc_html_x( 'None', 'backend', 'setech' )	=> '',
	esc_html_x( 'Titles', 'backend', 'setech' )	=> 'title',
);

foreach ( $taxes as $tax => $tax_obj ){
	$tax_name = isset( $tax_obj->labels->name ) && !empty( $tax_obj->labels->name ) ? $tax_obj->labels->name : $tax;
	$avail_taxes[$tax_name] = $tax;
}

array_push( $taxonomies, array(
	"type"				=> "dropdown",
	"heading"			=> esc_html_x( 'Filter by', 'backend', 'setech' ),
	"param_name"		=> "post_tax",
	"value"				=> $avail_taxes
));

foreach ( $avail_taxes as $tax_name => $tax ) {
	if ($tax == 'title'){
		global $wpdb;
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type LIKE %s and post_status = 'publish'", $post_type ) );
		$titles_arr = array(
			esc_html_x('None', 'backend', 'setech') => ''
		);
	    foreach( $results as $index => $post ) {
	    	$post_title = $post->post_title;
	        $titles_arr[$post_title] =  $post->ID;
	    }
		array_push( $taxonomies, array(
			"type"				=> "rb_dropdown",
			"multiple"			=> "true",
			"heading"			=> esc_html_x( 'Titles', 'backend', 'setech' ),
			"param_name"		=> "titles",
			'edit_field_class'	=> 'inside-box vc_col-xs-12',
			"dependency"		=> array(
				"element"	=> "post_tax",
				"value"		=> 'title'
			),
			"value"				=> $titles_arr
		));		
	} else {
		$terms = get_terms( $tax );
		$avail_terms = array(
			esc_html_x('None', 'backend', 'setech') => ''
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
			"param_name"	=> "{$post_type}_{$tax}_terms",
			"dependency"	=> array(
				"element"	=> "post_tax",
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
			'type'				=> 'dropdown',
			'heading'			=> esc_html_x( 'Order by', 'backend', 'setech' ),
			'param_name'		=> 'orderby',
			"edit_field_class" 	=> "vc_col-xs-4",
			"dependency"		=> array(
				"element"	=> "post_tax",
				"value"		=> array( "title","category","post_tag","post_format", )
			),
			'value'				=> array(
				esc_html_x( 'Date', 'backend', 'setech' ) 	=> 'date',
				esc_html_x( 'Title', 'backend', 'setech' ) 	=> 'title',
			),
		),
		array(
			'type'				=> 'dropdown',
			'heading'			=> esc_html_x( 'Order', 'backend', 'setech' ),
			'param_name'		=> 'order',
			"edit_field_class" 	=> "vc_col-xs-4",
			"dependency"		=> array(
				"element"	=> "post_tax",
				"value"		=> array( "title","category","post_tag","post_format", )
			),
			'value'				=> array(
				esc_html_x( 'DESC', 'backend', 'setech' ) 	=> 'DESC',
				esc_html_x( 'ASC', 'backend', 'setech' ) 	=> 'ASC',
			),
		),
		array(
			'type'				=> 'dropdown',
			'heading'			=> esc_html_x( 'Layout', 'backend', 'setech' ),
			'param_name'		=> 'layout',
			"edit_field_class" 	=> "vc_col-xs-4",
			'value'				=> array(
				esc_html_x( 'Large Image', 'backend', 'setech' ) 	=> 'large',
				esc_html_x( 'Small Image', 'backend', 'setech' ) 	=> 'small',
				esc_html_x( 'Two Columns', 'backend', 'setech' ) 	=> '2',
				esc_html_x( 'Three Columns', 'backend', 'setech' ) 	=> '3',
				esc_html_x( 'Four Columns', 'backend', 'setech' ) 	=> '4',
				esc_html_x( 'Checkerboard', 'backend', 'setech' ) 	=> 'checkerboard',
			)
		),
		array(
			'type'				=> 'checkbox',
			'param_name'		=> 'enable_masonry',
			"dependency"		=> array(
				"element"	=> "layout",
				"value"		=> array( "2","3","4" )
			),
			'value'				=> array(
				esc_html_x( 'Masonry', 'backend', 'setech' ) => true
			),
		),
		array(
			'type'				=> 'checkbox',
			'param_name'		=> 'enable_carousel',
			"dependency"		=> array(
				"element"	=> "layout",
				"value"		=> array("small", "2", "3", "4")
			),
			'value'				=> array(
				esc_html_x( 'Carousel', 'backend', 'setech' ) => true
			),
		),
		array(
			'type'				=> 'checkbox',
			'param_name'		=> 'post_hide_meta_override',
			'value'				=> array(
				esc_html_x( 'Hide Meta Data', 'backend', 'setech' ) => true
			)
		),
		array(
			'type'			=> 'rb_dropdown',
			'multiple'		=> "true",
			'heading'		=> esc_html_x( 'Hide', 'backend', 'setech' ),
			'param_name'	=> 'post_hide_meta',
			'dependency'	=> array(
				'element'	=> 'post_hide_meta_override',
				'not_empty'	=> true
			),
			'value'			=> array(
				esc_html_x( 'None', 'backend', 'setech' )				=> '',
				esc_html_x( 'Title', 'backend', 'setech' )				=> 'title',
				esc_html_x( 'Categories', 'backend', 'setech' )			=> 'cats',
				esc_html_x( 'Author', 'backend', 'setech' )				=> 'author',
				esc_html_x( 'Date', 'backend', 'setech' )				=> 'date',
				esc_html_x( 'Comments', 'backend', 'setech' )			=> 'comments',
				esc_html_x( 'Share', 'backend', 'setech' )				=> 'share',
				esc_html_x( 'Featured', 'backend', 'setech' )			=> 'featured',
				esc_html_x( 'Read More', 'backend', 'setech' )			=> 'read_more',
				esc_html_x( 'Excerpt', 'backend', 'setech' )			=> 'excerpt',	
			)
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Items to display', 'backend', 'setech' ),
			"description"		=> esc_html_x( 'Enter "-1" to show all posts', 'backend', 'setech' ),
			"param_name"		=> "total_items_count",
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> '-1'
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Items per Page', 'backend', 'setech' ),
			"param_name"		=> "items_pp",
			"edit_field_class" 	=> "vc_col-xs-4",
			"value"				=> get_theme_mod('blog_posts_per_page'),
		),
		array(
			'type'				=> 'textfield',
			'heading'			=> esc_html_x( 'Content Character Limit', 'backend', 'setech' ),
			'param_name'		=> 'chars_count',
			"edit_field_class" 	=> "vc_col-xs-4",
			'value'				=> get_theme_mod('blog_chars_count'),
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html_x( 'More button caption', 'backend', 'setech' ),
			"param_name"	=> "more_btn_text",
			"value"			=> get_theme_mod('blog_read_more'),
		),
		array(
			"type"			=> "textfield",
			"heading"		=> esc_html_x( 'Extra class name', 'backend', 'setech' ),
			"description"	=> esc_html_x( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'backend', 'setech' ),
			"param_name"	=> "el_class",
			"value"			=> ""
		),
	),
	$styles,
));

vc_map( array(
	"name"				=> esc_html_x( 'RB Blog', 'backend', 'setech' ),
	"base"				=> "rb_sc_blog",
	'category'			=> "By RB",
	"weight"			=> 80,
	"icon"     			=> "rb_icon",		
	"params"			=> $params
));

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_RB_Sc_Blog extends WPBakeryShortCode {
    }
}

?>