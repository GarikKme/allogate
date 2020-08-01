<?php 
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'RB_VC_Search', 'setech' ),
			"responsive"	=> 'all',
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "customize_align",
			"group"			=> esc_html_x( "Styling", 'RB_VC_Search', 'setech' ),
			"responsive"	=> "all",
			"value"			=> array( esc_html_x( 'Customize Alignment', 'RB_VC_Search', 'setech' ) => true ),
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html_x( 'Alignment', 'RB_VC_Search', 'setech' ),
			"group"			=> esc_html_x( "Styling", 'RB_VC_Search', 'setech' ),
			"param_name"	=> "alignment",
			"responsive"	=> "all",
			"dependency"		=> array(
				"element"	=> "customize_align",
				"not_empty"	=> true
			),
			"value"			=> array(
				esc_html_x( "Left", 'RB_VC_Search', 'setech' ) => 'left',
				esc_html_x( "Center", 'RB_VC_Search', 'setech' ) => 'center',
				esc_html_x( "Right", 'RB_VC_Search', 'setech' ) => 'right',
			),
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Color', 'RB_VC_Icon_List', 'setech' ),
			"param_name"		=> "color",
			"group"				=> esc_html_x( "Styling", 'RB_VC_Icon_List', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> "#000",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Color on Hover', 'RB_VC_Icon_List', 'setech' ),
			"param_name"		=> "color_hover",
			"group"				=> esc_html_x( "Styling", 'RB_VC_Icon_List', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR,
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
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Label', 'RB_VC_Search', 'setech' ),
				"param_name"		=> "label",
				"value"				=> "Search"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Extra class name', 'RB_VC_Search', 'setech' ),
				"description"		=> esc_html_x( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'RB_VC_Search', 'setech' ),
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
		"name"				=> esc_html_x( 'RB Search', 'RB_VC_Search', 'setech' ),
		"base"				=> "rb_sc_search",
		'category'			=> "By RB",
		"icon"     			=> "rb_icon",		
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Search extends WPBakeryShortCode {
	    }
	}
?>