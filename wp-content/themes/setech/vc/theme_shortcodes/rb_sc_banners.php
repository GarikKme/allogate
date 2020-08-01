<?php
	/* -----> STYLING TAB PROPERTIES <----- */
	$background_properties = rb_module_background_props();

	$styles = rb_ext_merge_arrs( array(
		array(
			array(
				"type"			=> "css_editor",
				"param_name"	=> "custom_styles",
				"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
				"responsive"	=> 'all'
			)
		),
		$background_properties,
		array(
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Title color', 'backend', 'setech' ),
				"param_name"		=> "title_color",
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#000",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Text color', 'backend', 'setech' ),
				"param_name"		=> "text_color",
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "#4C4C4D",
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Divider color', 'backend', 'setech' ),
				"param_name"		=> "divider_color",
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> PRIMARY_COLOR,
			),
			array(
				"type"				=> "colorpicker",
				"heading"			=> esc_html_x( 'Background Overlay Color', 'backend', 'setech' ),
				"param_name"		=> "overlay_color",
				"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> "rgba(255,255,255,.6)",
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
			array(
				"type"			=> "checkbox",
				"param_name"	=> "customize_size",
				"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
				"responsive"	=> "all",
				"value"			=> array( esc_html_x( 'Customize Sizes', 'backend', 'setech' ) => true ),
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
				"heading"		=> esc_html_x( 'Text Alignment', 'backend', 'setech' ),
				"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
				"param_name"	=> "module_alignment",
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
				"type"				=> "textarea",
				"admin_label"		=> true,
				"heading"			=> esc_html_x( 'Title', 'backend', 'setech' ),
				"param_name"		=> "title",
				"value"				=> ""
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "add_divider",
				"value"				=> array( esc_html_x( 'Add Divider', 'backend', 'setech' ) => true ),
			),
			array(
				"type"				=> "textarea",
				"admin_label"		=> true,
				"heading"			=> esc_html_x( 'Description', 'backend', 'setech' ),
				"param_name"		=> "description",
				"value"				=> ""
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Button Title', 'backend', 'setech' ),
				"param_name"		=> "button_title",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> ""
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Banner Url', 'backend', 'setech' ),
				"param_name"		=> "banner_url",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> "#"
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Button Position', 'backend', 'setech' ),
				"param_name"		=> "button_pos",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> array(
					esc_html_x( 'Default', 'backend', 'setech' )		=> 'default',
					esc_html_x( 'Floated', 'backend', 'setech' )		=> 'floated',
				)
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "new_tab",
				"edit_field_class" 	=> "vc_col-xs-4",
				"value"				=> array( esc_html_x( 'Open Link in New Tab', 'backend', 'setech' ) => true ),
				"std"				=> '1'
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
		"name"				=> esc_html_x( 'RB Banner', 'backend', 'setech' ),
		"base"				=> "rb_sc_banners",
		"category"			=> "By RB",
		"icon" 				=> "rb_icon",
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Banners extends WPBakeryShortCode {
	    }
	}
?>