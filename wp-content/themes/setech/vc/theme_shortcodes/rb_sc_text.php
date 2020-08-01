<?php
	/* -----> ICONS PROPERTIES <----- */
	$icons = rb_ext_icon_vc_sc_config_params('style', 'with_icon');

	/* -----> STYLING TAB PROPERTIES <----- */
	$styles = array(
		array(
			"type"			=> "css_editor",
			"param_name"	=> "custom_styles",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> 'all',
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
			"dependency"		=> array(
				"element"	=> "customize_align",
				"not_empty"	=> true
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
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"	=> 'all',
			"value"			=> array( esc_html_x( 'Customize Sizes', 'backend', 'setech' ) => true ),
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Icon Size', 'backend', 'setech' ),
			"param_name"		=> "icon_size",
			"edit_field_class" 	=> "vc_col-xs-4",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "30px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Icon Shape Size', 'backend', 'setech' ),
			"param_name"		=> "icon_shape_size",
			"edit_field_class" 	=> "vc_col-xs-4",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "74px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Icon margin', 'backend', 'setech' ),
			"param_name"		=> "icon_margin",
			"edit_field_class" 	=> "vc_col-xs-4",
			"description"		=> esc_html_x( 'Margin could be left, right or bottom. It depends from module alignment', 'backend', 'setech' ),
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "27px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Subtitle Size', 'backend', 'setech' ),
			"param_name"		=> "subtitle_size",
			"edit_field_class" 	=> "vc_col-xs-6",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "14px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Subtitle Margin Bottom', 'backend', 'setech' ),
			"param_name"		=> "subtitle_margin",
			"edit_field_class" 	=> "vc_col-xs-6",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "15px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Title Size', 'backend', 'setech' ),
			"param_name"		=> "title_size",
			"edit_field_class" 	=> "vc_col-xs-4",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "36px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Title Line-Height', 'backend', 'setech' ),
			"param_name"		=> "title_lh",
			"edit_field_class" 	=> "vc_col-xs-4",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"description"		=> esc_html_x( 'In em', 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "1.4em",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Title Margin Bottom', 'backend', 'setech' ),
			"param_name"		=> "title_margin",
			"edit_field_class" 	=> "vc_col-xs-4",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "18px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Content Size', 'backend', 'setech' ),
			"param_name"		=> "content_size",
			"edit_field_class" 	=> "vc_col-xs-6",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "15px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Content Line-Height', 'backend', 'setech' ),
			"param_name"		=> "content_lh",
			"edit_field_class" 	=> "vc_col-xs-6",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "27px",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Paragraph Spacing', 'backend', 'setech' ),
			"param_name"		=> "paragraph_spacing",
			"edit_field_class" 	=> "vc_col-xs-6",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "1.7em",
		),
		array(
			"type"				=> "textfield",
			"heading"			=> esc_html_x( 'Button Margin Top', 'backend', 'setech' ),
			"param_name"		=> "button_margin",
			"edit_field_class" 	=> "vc_col-xs-6",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"responsive"		=> 'all',
			"dependency"		=> array(
				"element"	=> "customize_size",
				"not_empty"	=> true
			),
			"value"				=> "35px",
		),
		array(
			"type"			=> "checkbox",
			"param_name"	=> "customize_colors",
			"std"			=> "1",
			"group"			=> esc_html_x( "Styling", 'backend', 'setech' ),
			"value"			=> array( esc_html_x( 'Customize Colors', 'backend', 'setech' ) => true ),
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icon Color', 'backend', 'setech' ),
			"param_name"		=> "icon_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR,
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Icon Shape Color', 'backend', 'setech' ),
			"param_name"		=> "icon_background",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "#FFEEED",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Subtitle Color', 'backend', 'setech' ),
			"param_name"		=> "subtitle_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR,
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Subtitle Background', 'backend', 'setech' ),
			"param_name"		=> "subtitle_background",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "#FFEEED",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Title Color', 'backend', 'setech' ),
			"param_name"		=> "title_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "#000",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Font Color', 'backend', 'setech' ),
			"param_name"		=> "font_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> "rgba(0,0,0, .75)",
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Font Color Hover', 'backend', 'setech' ),
			"param_name"		=> "font_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR,
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'List Markers Color', 'backend', 'setech' ),
			"param_name"		=> "font_list_markers",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR,
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Divider Color', 'backend', 'setech' ),
			"param_name"		=> "divider_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR,
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Color', 'backend', 'setech' ),
			"param_name"		=> "btn_font_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> '#fff'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Color Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_font_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> '#fff'
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Background', 'backend', 'setech' ),
			"param_name"		=> "btn_bg_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Background Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_bg_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Border', 'backend', 'setech' ),
			"param_name"		=> "btn_border_color",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR
		),
		array(
			"type"				=> "colorpicker",
			"heading"			=> esc_html_x( 'Button Border Hover', 'backend', 'setech' ),
			"param_name"		=> "btn_border_color_hover",
			"group"				=> esc_html_x( "Styling", 'backend', 'setech' ),
			"edit_field_class" 	=> "vc_col-xs-6",
			"dependency"		=> array(
				"element"	=> "customize_colors",
				"not_empty"	=> true
			),
			"value"				=> PRIMARY_COLOR
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
					esc_html_x( "With Subtitle", 'backend', 'setech' ) 	=> 'with_subtitle',
					esc_html_x( "With Icon", 'backend', 'setech' ) 		=> 'with_icon',
				),
			),
		),
		$icons,
		array(
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Icon Shape', 'backend', 'setech' ),
				"param_name"		=> "icon_shape",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "with_icon"
				),
				"value"				=> array(
					esc_html_x( "None", 'backend', 'setech' ) 		=> 'none',
					esc_html_x( "Round", 'backend', 'setech' ) 		=> 'round',
					esc_html_x( "Square", 'backend', 'setech' ) 	=> 'square',
				),
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Subtitle', 'backend', 'setech' ),
				"admin_label"		=> true,
				"param_name"		=> "subtitle",
				"dependency"		=> array(
					"element"	=> "style",
					"value"		=> "with_subtitle"
				),
				"value"				=> "",
			),
			array(
				"type"				=> "textarea",
				"heading"			=> esc_html_x( 'Title', 'backend', 'setech' ),
				"admin_label"		=> true,
				"param_name"		=> "title",
				"value"				=> "",
				"edit_field_class" 	=> "vc_col-xs-6",
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Title HTML Tag', 'backend', 'setech' ),
				"param_name"		=> "title_tag",
				"edit_field_class" 	=> "vc_col-xs-6",
				"value"				=> array(
					esc_html_x( "Default - (H3)", 'backend', 'setech' ) 	=> 'h3',
					esc_html_x( "H1", 'backend', 'setech' ) 				=> 'h1',
					esc_html_x( "H2", 'backend', 'setech' ) 				=> 'h2',
					esc_html_x( "H3", 'backend', 'setech' ) 				=> 'h3',
					esc_html_x( "H4", 'backend', 'setech' ) 				=> 'h4',
					esc_html_x( "H5", 'backend', 'setech' ) 				=> 'h5',
					esc_html_x( "H6", 'backend', 'setech' ) 				=> 'h6',
				),
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Button Title', 'backend', 'setech' ),
				"param_name"		=> "button_title",
				"value"				=> "",
				"edit_field_class" 	=> "vc_col-xs-6",
			),
			array(
				"type"				=> "textfield",
				"heading"			=> esc_html_x( 'Button URL', 'backend', 'setech' ),
				"param_name"		=> "button_url",
				"value"				=> "#",
				"edit_field_class" 	=> "vc_col-xs-6",
			),
				array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Button Type', 'backend', 'setech' ),
				"param_name"		=> "button_type",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"		=> "button_title",
					"not_empty"		=> true
				),
				"value"				=> array(
					esc_html_x( 'Arrow Fade Out', 'backend', 'setech' )		=> 'arrow_fade_out',
					esc_html_x( 'Arrow Fade In', 'backend', 'setech' )		=> 'arrow_fade_in',
					esc_html_x( 'Simple', 'backend', 'setech' )				=> 'simple',
				)
			),
			array(
				"type"				=> "dropdown",
				"heading"			=> esc_html_x( 'Button Size', 'backend', 'setech' ),
				"param_name"		=> "button_size",
				"edit_field_class" 	=> "vc_col-xs-6",
				"dependency"		=> array(
					"element"		=> "button_title",
					"not_empty"		=> true
				),
				"value"				=> array(
					esc_html_x( "Small", 'backend', 'setech' ) 		=> 'small',
					esc_html_x( "Medium", 'backend', 'setech' ) 	=> 'medium',
					esc_html_x( "Large", 'backend', 'setech' ) 		=> 'large',
				),
				"std"				=> "medium"
			),
			array(
				"type"				=> "checkbox",
				"param_name"		=> "show_divider",
				"value"				=> array( esc_html_x( 'Show Divider', 'backend', 'setech' ) => true ),
				"std"				=> true
			),
			array(
				"type"				=> "textarea_html",
				"heading"			=> esc_html_x( 'Text', 'backend', 'setech' ),
				"param_name"		=> "content",
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
		"name"				=> esc_html_x( 'RB Text', 'backend', 'setech' ),
		"base"				=> "rb_sc_text",
		'category'			=> "By RB",
		"icon"     			=> "rb_icon",		
		"weight"			=> 80,
		"params"			=> $params
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
	    class WPBakeryShortCode_RB_Sc_Text extends WPBakeryShortCode {
	    }
	}
?>