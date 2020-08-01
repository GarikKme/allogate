<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> 'all',
		),
	);

	/* -----> RESPONSIVE STYLING TABS PROPERTIES <----- */
	$styles_landscape = $styles_portrait = $styles_mobile = $styles;

	$styles_landscape = rb_responsive_styles($styles_landscape, 'landscape', rb_landscape_group_name());
	$styles_portrait = rb_responsive_styles($styles_portrait, 'portrait', rb_tablet_group_name());
	$styles_mobile = rb_responsive_styles($styles_mobile, 'mobile', rb_mobile_group_name());

	$params = rb_ext_merge_arrs( array(
		/* -----> GENERAL TAB <----- */
		array(
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html_x( 'Style', 'backend', 'setech' ),
				"param_name"	=> "style",
				"value"			=> array(
					esc_html_x( 'Default', 'backend', 'setech' )		=> 'default',
					esc_html_x( 'Style 1', 'backend', 'setech' )		=> 'style_1',
					esc_html_x( 'Style 2', 'backend', 'setech' )		=> 'style_2',
					esc_html_x( 'Dashed', 'backend', 'setech' )		=> 'dashed',
				),
				"std"			=> 'filled_default'
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Divider Color', 'backend', 'setech' ),
				"param_name"		=> "color",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> PRIMARY_COLOR
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Divider Helper Color', 'backend', 'setech' ),
				"param_name"		=> "helper_color",
				"edit_field_class" 	=> "vc_col-xs-4",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> array('style_1', 'dashed')
				),
				"value"				=> '#e5e5e5',
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

	/* -----> MODULE DECLARATION <----- */
	vc_map( array(
		"name"				=> esc_html_x( 'RB Divider', 'backend', 'setech' ),
		"base"				=> "rb_sc_divider",
		'category'			=> "By RB",
		"icon"     			=> "rb_icon",		
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Divider extends WPBakeryShortCode {
	    }
	}
?>