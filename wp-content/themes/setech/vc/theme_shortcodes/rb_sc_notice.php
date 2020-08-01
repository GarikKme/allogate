<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'RB_VC_Notice', 'setech' ),
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
				"type"				=> "textarea",
				"heading"			=> esc_html_x( 'Notice', 'RB_VC_Notice', 'setech' ),
				"param_name"		=> "notice",
				"value"				=> "FINAL CLEARANCE: Take 20% off ‘Sale Must-Haves'",
				"admin_label"		=> true,
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "closable",
				"value"				=> array( esc_html_x( 'Closable', 'RB_VC_Notice', 'setech' ) => true ),
				"std"				=> "1"
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Text Color', 'RB_VC_Notice', 'setech' ),
				"param_name"		=> "font_color",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> '#fff',
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Close Color', 'RB_VC_Notice', 'setech' ),
				"param_name"		=> "close_color",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "closable",
					"not_empty"	=> true
				),
				"value"				=> '#858585',
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Extra class name', 'RB_VC_Notice', 'setech' ),
				"description"		=> esc_html_x( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'RB_VC_Notice', 'setech' ),
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
		"name"				=> esc_html_x( 'RB Notice', 'RB_VC_Notice', 'setech' ),
		"base"				=> "rb_sc_notice",
		'category'			=> "By RB",
		"icon"     			=> "rb_icon",		
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Notice extends WPBakeryShortCode {
	    }
	}
?>