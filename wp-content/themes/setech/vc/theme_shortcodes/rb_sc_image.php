<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = rb_ext_merge_arrs( array(
		array(
			array(
				"type"			=> "css_editor",
				"param_name"	=> "custom_styles",
				"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
				"responsive"	=> 'all'
			),
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_align",
				"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
				"responsive"	=> "all",
				"value"			=> array( esc_html_x( 'Customize Alignment', 'backend', 'setech' ) => true ),
			),
			array(
				"type"			=> "dropdown",
				"heading"		=> esc_html_x( 'Alignment', 'backend', 'setech' ),
				"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"	=> "alignment",
				"responsive"	=> "all",
				"dependency"		=> array(
					"element"	=> "customize_align",
					"not_empty"	=> true
				),
				"value"			=> array(
					esc_html_x( "Left", 'backend', 'setech' ) => 'left',
					esc_html_x( "Center", 'backend', 'setech' ) => 'center',
					esc_html_x( "Right", 'backend', 'setech' ) => 'right',
				),
				"std"			=> 'center',
			),
		)
	));

	/* -----> RESPONSIVE STYLING TABS PROPERTIES <----- */
	$styles_landscape = $styles_portrait = $styles_mobile = $styles;

	$styles_landscape = rb_responsive_styles($styles_landscape, 'landscape', rb_landscape_group_name());
	$styles_portrait = rb_responsive_styles($styles_portrait, 'portrait', rb_tablet_group_name());
	$styles_mobile = rb_responsive_styles($styles_mobile, 'mobile', rb_mobile_group_name());

	$params = rb_ext_merge_arrs( array(
		/* -----> GENERAL TAB <----- */
		array(
			array(
				"type"				=> "attach_image",
				"heading"			=> esc_html_x( 'Image', 'backend', 'setech' ),
				"param_name"		=> "image",
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Image Hover Effect', 'backend', 'setech' ),
				"param_name"		=> "bg_hover",
				"value"				=> array(
					esc_html_x( 'No Hover', 'backend', 'setech' )		=> 'no_hover',
					esc_html_x( '3D', 'backend', 'setech' )				=> '3d',
					esc_html_x( 'Flip', 'backend', 'setech' )			=> 'flip',
					esc_html_x( 'Falling Down', 'backend', 'setech' )	=> 'fall',
					esc_html_x( 'Grayscale', 'backend', 'setech' )		=> 'grayscale',
				),
				"std"				=> 'no_hover'
			),
			array(
				"type"				=> "attach_image",
				"heading"			=> esc_html_x( 'Hover Image', 'backend', 'setech' ),
				"param_name"		=> "hover_image",
				"dependency"		=> array(
					"element"	=> "bg_hover",
					"value"		=> array('flip', 'fall'),
				),
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Sensivity', "backend", 'setech' ),
				"param_name"		=> "max_tilt",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "bg_hover",
					"value"		=> array('3d'),
				),
				"value"				=> "10"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Perspective', "backend", 'setech' ),
				"param_name"		=> "perspective",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "bg_hover",
					"value"		=> array('3d'),
				),
				"value"				=> "1000"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Scale', "backend", 'setech' ),
				"param_name"		=> "scale",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "bg_hover",
					"value"		=> array('3d'),
				),
				"value"				=> "1"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Speed', "backend", 'setech' ),
				"description"		=> esc_html_x( 'Speed of the enter/exit transition', "backend", 'setech' ),
				"param_name"		=> "speed",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"	=> "bg_hover",
					"value"		=> array('3d'),
				),
				"value"				=> "300"
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
		"name"				=> esc_html_x( 'RB Image', 'backend', 'setech' ),
		"base"				=> "rb_sc_image",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Image extends WPBakeryShortCode {
	    }
	}
?>