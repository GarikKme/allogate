<?php
	/* -----> ICONS PROPERTIES <----- */
	$icons = rb_ext_icon_vc_sc_config_params();

	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
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
			"dependency"	=> array(
				"element"		=> "customize_align",
				"not_empty"		=> true
			),
			"value"			=> array(
				esc_html_x( "Left", 'backend', 'setech' ) 	=> 'left',
				esc_html_x( "Center", 'backend', 'setech' ) => 'center',
				esc_html_x( "Right", 'backend', 'setech' ) 	=> 'right',
			),
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "customize_size",
			"group"			=> esc_html_x( "Styling", "backend", 'setech' ),
			"responsive"	=> "all",
			"value"			=> array( esc_html_x( 'Customize Sizes', "backend", 'setech' ) => true ),
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Icon Size', "backend", 'setech' ),
			"param_name"		=> "icon_size",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "36px"
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Count Size', "backend", 'setech' ),
			"param_name"		=> "count_size",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "36px"
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Title Size', "backend", 'setech' ),
			"param_name"		=> "title_size",
			"group"				=> esc_html_x( "Styling", "backend", 'setech' ),
			"responsive"		=> "all",
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "14px"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icon Shape', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "icon_shape_color",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icon Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "icon_color",
			"value"				=> "#fff"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Count Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "count_color",
			"value"				=> "#000"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "title_color",
			"value"				=> "#4C4C4D"
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Background Hover Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "bg_hover_color",
			"value"				=> ""
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Shadow Color', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"param_name"		=> "shadow_color",
			"value"				=> "rgba(0,0,0,.15)"
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
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Style', 'backend', 'setech' ),
				"param_name"		=> "style",
				"value"				=> array(
					esc_html_x( "Simple", 'backend', 'setech' ) 	=> 'simple',
					esc_html_x( "Advanced", 'backend', 'setech' ) 	=> 'advanced',
				),
			)
		),
		$icons,
		array(
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Icon Shape', 'backend', 'setech' ),
				"param_name"		=> "icon_shape",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "simple"
				),
				"value"				=> array(
					esc_html_x( "None", 'backend', 'setech' ) 		=> 'none',
					esc_html_x( "Square", 'backend', 'setech' ) 	=> 'square',
					esc_html_x( "Round", 'backend', 'setech' ) 		=> 'round',
				),
			),
			array(
				"type"				=> "textfield",
				"admin_label"		=> true,
				"heading"			=> esc_html_x( 'Title', 'backend', 'setech' ),
				"param_name"		=> "title",
				"value"				=> ""
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Count', 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"param_name"		=> "count",
				"value"				=> "50"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Extra Symbol', 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"param_name"		=> "symbol",
				"value"				=> "%"
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
		"name"				=> esc_html_x( 'RB Milestone', 'backend', 'setech' ),
		"base"				=> "rb_sc_milestone",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Milestone extends WPBakeryShortCode {
	    }
	}
?>