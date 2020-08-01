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
			"heading"		=> esc_html_x( 'Aligning', 'backend', 'setech' ),
			"param_name"	=> "aligning",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> "all",
			"dependency"	=> array(
				"element"		=> "customize_align",
				"not_empty"		=> true
			),
			"value"			=> array(
				esc_html_x( 'Left', 'backend', 'setech' )	=> 'left',
				esc_html_x( 'Center', 'backend', 'setech' )	=> 'center',
				esc_html_x( 'Right', 'backend', 'setech' )	=> 'right',
			)
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html_x( 'Button Size', 'backend', 'setech' ),
			"param_name"	=> "btn_size",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"			=> array(
				esc_html_x( 'Large', 'backend', 'setech' )		=> 'large',
				esc_html_x( 'Medium', 'backend', 'setech' )		=> 'medium',
				esc_html_x( 'Small', 'backend', 'setech' )		=> 'small',
			)
		),
		array(
			"type"			=> "dropdown",
			"heading"		=> esc_html_x( 'Button Style', 'backend', 'setech' ),
			"param_name"	=> "btn_style",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"			=> array(
				esc_html_x( 'Arrow Fade Out', 'backend', 'setech' )		=> 'arrow_fade_out',
				esc_html_x( 'Arrow Fade In', 'backend', 'setech' )		=> 'arrow_fade_in',
				esc_html_x( 'Simple', 'backend', 'setech' )				=> 'simple',
			),
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Color', 'backend', 'setech' ),
			"param_name"		=> "btn_font_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> '#fff'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Color Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_font_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> '#fff'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Background Color', 'backend', 'setech' ),
			"param_name"		=> "btn_bg_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Background Color Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_bg_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Border Color', 'backend', 'setech' ),
			"param_name"		=> "btn_border_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Border Color Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_border_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
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
		$icons,
		array(
			array(
				"type"				=> "textfield",
				"admin_label"		=> true,
				"heading"			=> esc_html_x( 'Title', 'backend', 'setech' ),
				"param_name"		=> "title",
				"value"				=> "Click Me!"
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Link', 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"param_name"		=> "url",
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "new_tab",
				"value"				=> array( esc_html_x( 'Open in New Tab', 'backend', 'setech' ) => true ),
				"std"				=> "1"
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
		"name"				=> esc_html_x( 'RB Button', 'backend', 'setech' ),
		"base"				=> "rb_sc_button",
		'category'			=> "By RB",
		"icon"     			=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Button extends WPBakeryShortCode {
	    }
	}
?>