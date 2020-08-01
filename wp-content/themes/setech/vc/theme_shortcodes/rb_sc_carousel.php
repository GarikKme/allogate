<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> 'all'
		),
		array(
			"type"				=> "checkbox",
			"param_name"		=> "custom_colors",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"				=> array( esc_html_x( 'Custom Colors', 'backend', 'setech' ) => true ),
			"std"				=> '1'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Arrows Color', 'backend', 'setech' ),
			"param_name"		=> "nav_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"dependency"		=> array(
				"element"	=> "custom_colors",
				"not_empty"	=> true
			),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Arrows Hover Color', 'backend', 'setech' ),
			"param_name"		=> "nav_hover_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"dependency"		=> array(
				"element"	=> "custom_colors",
				"not_empty"	=> true
			),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Dots Color', 'backend', 'setech' ),
			"param_name"		=> "dots_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"dependency"		=> array(
				"element"	=> "custom_colors",
				"not_empty"	=> true
			),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> '#e5e5e5'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Dots Active Color', 'backend', 'setech' ),
			"param_name"		=> "dots_active_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"dependency"		=> array(
				"element"	=> "custom_colors",
				"not_empty"	=> true
			),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR
		),
	);

	/* -----> RESPONSIVE STYLING TABS PROPERTIES <----- */
	$styles_landscape = $styles_portrait = $styles_mobile = $styles;

	$styles_landscape =  rb_responsive_styles($styles_landscape, 'landscape', rb_landscape_group_name());
	$styles_portrait =  rb_responsive_styles($styles_portrait, 'portrait', rb_tablet_group_name());
	$styles_mobile =  rb_responsive_styles($styles_mobile, 'mobile', rb_mobile_group_name());

	$params = rb_ext_merge_arrs( array(
		/* -----> GENERAL TAB <----- */
		array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html_x( 'Carousel Columns', 'backend', 'setech' ),
				"param_name"	=> "columns",
				"value"			=> array(
					esc_html_x( "One", 'backend', 'setech' ) 		=> '1',
					esc_html_x( "Two", 'backend', 'setech' )		=> '2',
					esc_html_x( "Three", 'backend', 'setech' )	=> '3',
					esc_html_x( "Four", 'backend', 'setech' )		=> '4',
					esc_html_x( "Five", 'backend', 'setech' )		=> '5',
					esc_html_x( "Six", 'backend', 'setech' )		=> '6',
				)		
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Landscape Columns', 'backend', 'setech' ),
				"param_name"		=> "landscape_columns",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> array(
					esc_html_x( "One", 'backend', 'setech' ) 		=> '1',
					esc_html_x( "Two", 'backend', 'setech' )		=> '2',
					esc_html_x( "Three", 'backend', 'setech' )		=> '3',
					esc_html_x( "Four", 'backend', 'setech' )		=> '4',
					esc_html_x( "Five", 'backend', 'setech' )		=> '5',
					esc_html_x( "Six", 'backend', 'setech' )		=> '6',
				)		
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Portrait Columns', 'backend', 'setech' ),
				"param_name"		=> "portrait_columns",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> array(
					esc_html_x( "One", 'backend', 'setech' ) 		=> '1',
					esc_html_x( "Two", 'backend', 'setech' )		=> '2',
					esc_html_x( "Three", 'backend', 'setech' )		=> '3',
					esc_html_x( "Four", 'backend', 'setech' )		=> '4',
					esc_html_x( "Five", 'backend', 'setech' )		=> '5',
					esc_html_x( "Six", 'backend', 'setech' )		=> '6',
				)		
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Mobile Columns', 'backend', 'setech' ),
				"param_name"		=> "mobile_columns",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> array(
					esc_html_x( "One", 'backend', 'setech' ) 		=> '1',
					esc_html_x( "Two", 'backend', 'setech' )		=> '2',
					esc_html_x( "Three", 'backend', 'setech' )		=> '3',
					esc_html_x( "Four", 'backend', 'setech' )		=> '4',
					esc_html_x( "Five", 'backend', 'setech' )		=> '5',
					esc_html_x( "Six", 'backend', 'setech' )		=> '6',
				)		
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html_x( 'Slides to scroll', 'backend', 'setech' ),
				"param_name"	=> "slides_to_scroll",
				"value"			=> "1"
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "pagination",
				"value"			=> array( esc_html_x( 'Add Pagination Dots', 'backend', 'setech' ) => true ),
				"std"			=> '1'
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "navigation",
				"value"			=> array( esc_html_x( 'Add Navigation Arrows', 'backend', 'setech' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "auto_height",
				"value"			=> array( esc_html_x( 'Auto Height', 'backend', 'setech' ) => true ),
				"std"			=> '1'
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "draggable",
				"value"			=> array( esc_html_x( 'Draggable', 'backend', 'setech' ) => true ),
				"std"			=> '1'
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "infinite",
				"value"			=> array( esc_html_x( 'Infinite Loop', 'backend', 'setech' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "autoplay",
				"value"			=> array( esc_html_x( 'Autoplay', 'backend', 'setech' ) => true )
			),
			array(
				"type"			=> "textfield",
				"heading"		=> esc_html_x( 'Autoplay Speed', 'backend', 'setech' ),
				"dependency"	=> array(
					"element"	=> "autoplay",
					"not_empty"	=> true
				),
				"param_name"	=> "autoplay_speed",
				"value"			=> "3000"
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "pause_on_hover",
				"dependency"	=> array(
					"element"	=> "autoplay",
					"not_empty"	=> true
				),
				"value"			=> array( esc_html_x( 'Pause on Hover', 'backend', 'setech' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "vertical",
				"value"			=> array( esc_html_x( 'Vertical Direction', 'backend', 'setech' ) => true )
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "vertical_swipe",
				"value"			=> array( esc_html_x( 'Vertical Swipe', 'backend', 'setech' ) => true )
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
		$styles,
		/* -----> TABLET LANDSCAPE TAB <----- */
		$styles_landscape,
		/* -----> TABLET PORTRAIT TAB <----- */
		$styles_portrait,
		/* -----> MOBILE TAB <----- */
		$styles_mobile
	));

	vc_map( array(
		"name"				=> esc_html_x( 'RB Carousel', 'backend', 'setech' ),
		"base"				=> "rb_sc_carousel",
		'content_element' 	=> true,
		'as_parent'			=> array('only' => 'vc_column_text, rb_sc_image, rb_sc_text, rb_sc_services, rb_sc_widget_text, vc_single_image, products'),
		'category'			=> "By RB",
		"icon"     			=> "rb_icon",
		"weight"			=> 80,
		'js_view' 			=> 'VcColumnView',
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	    class WPBakeryShortCode_RB_Sc_Carousel extends WPBakeryShortCodesContainer {
	    }
	}
?>